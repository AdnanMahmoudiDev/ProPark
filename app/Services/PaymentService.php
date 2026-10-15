<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\RedirectionForm;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;

class PaymentService
{
    protected CheckoutService $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * ایجاد فاکتور، ثبت رکورد پرداخت و آماده‌سازی هدایت به درگاه
     *
     * @param Order $order
     * @param string|null $driver نام درگاه (در صورت خالی بودن از درگاه پیش‌فرض استفاده می‌شود)
     * @return array [ 'payment' => Payment, 'redirect_url' => string, 'form' => ... ]
     * @throws Exception
     */
    public function initiatePayment(Order $order, ?string $driver = null): array
    {
        $driver = $driver ?: config('payment.default', 'sep');

        // اگر مبلغ سفارش صفر باشد (مثلاً ۱۰۰٪ تخفیف یا پلن رایگان)
        if ($order->payable_amount <= 0) {
            return $this->handleFreeOrder($order);
        }

        // ۱. ساخت Invoice پکیج Multipay با مبلغ سفارش (به تومان بر اساس تنظیمات درگاه)
        $invoice = (new Invoice)
            ->amount((int) $order->payable_amount)
            ->detail('order_id', $order->id)
            ->detail('order_number', $order->order_number);

        // افزودن اطلاعات اختیاری کاربر برای درگاه
        if ($order->user) {
            if ($order->user->email) {
                $invoice->detail('email', $order->user->email);
            }
            if (!empty($order->user->phone)) {
                $invoice->detail('phone', $order->user->phone);
            }
        }

        $callbackUrl = route('payment.callback', ['order' => $order->id]);

        // ۲. ارسال به درگاه، دریافت شناسه تراکنش (Token / Authority) و هدایت
        try {
            $paymentDriver = ShetabitPayment::via($driver)->callbackUrl($callbackUrl);

            $paymentReceipt = null;

            // فراخوانی متوالی purchase و سپس pay برای دریافت شیء RedirectionForm
            /** @var RedirectionForm $redirection */
            $redirection = $paymentDriver->purchase(
                $invoice,
                function ($driverInstance, $transactionId) use ($order, $driver, &$paymentReceipt, $callbackUrl) {
                    // ثبت تراکنش در جدول payments به صورت pending با ستون‌های استاندارد دیتابیس
                    $paymentReceipt = Payment::create([
                        'user_id'         => $order->user_id,
                        'order_id'        => $order->id,
                        'gateway'         => $driver,
                        'amount'          => $order->payable_amount,
                        'currency'        => $order->currency ?: 'IRT',
                        'status'          => 'pending',
                        'authority'       => (string) $transactionId,
                        'request_payload' => [
                            'callback_url'   => $callbackUrl,
                            'transaction_id' => (string) $transactionId,
                            'initiated_at'   => now()->toDateTimeString(),
                        ],
                    ]);
                }
            )->pay();

            // استخراج ایمن URL انتقال به درگاه
            $redirectUrl = '';
            if ($redirection instanceof RedirectionForm || is_object($redirection)) {
                if (method_exists($redirection, 'getAction')) {
                    $redirectUrl = $redirection->getAction();
                } elseif (method_exists($redirection, 'getUrl')) {
                    $redirectUrl = $redirection->getUrl();
                } else {
                    $redirectUrl = (string) $redirection;
                }
            } elseif (is_string($redirection)) {
                $redirectUrl = $redirection;
            }

            return [
                'success'      => true,
                'payment'      => $paymentReceipt,
                'redirect_url' => $redirectUrl,
                'redirection'  => $redirection,
                'is_free'      => false,
            ];
        } catch (Exception $e) {
            Log::error('Payment initiation failed', [
                'order_id' => $order->id,
                'driver'   => $driver,
                'error'    => $e->getMessage(),
            ]);

            throw new Exception(__('خطا در اتصال به درگاه پرداخت: :message', ['message' => $e->getMessage()]));
        }
    }

    /**
     * اعتبارسنجی و تأیید نهایی پرداخت پس از بازگشت از درگاه (Callback)
     *
     * @param Order $order
     * @param array $callbackData
     * @return array [ 'success' => bool, 'message' => string, 'payment' => Payment|null, 'reference_id' => string|null ]
     */
    public function verifyPayment(Order $order, array $callbackData): array
    {
        // دریافت authority/token از پارامترهای بازگشتی:
        // در درگاه سپ: RefNum یا ResNum
        // در زرین‌پال: Authority یا authority
        $authority = $callbackData['RefNum']
            ?? $callbackData['Authority']
            ?? $callbackData['authority']
            ?? $callbackData['token']
            ?? $callbackData['Token']
            ?? null;

        // جستجوی آخرین پرداخت معلق بر اساس authority یا آخرین رکورد معلق سفارش
        $paymentQuery = $order->payments()->where('status', 'pending');
        if ($authority) {
            $paymentQuery->where(function ($q) use ($authority) {
                $q->where('authority', $authority)
                    ->orWhere('request_payload->transaction_id', $authority);
            });
        }
        $payment = $paymentQuery->latest('id')->first();

        // اگر با شناسه مستقیم پیدا نشد، آخرین پرداخت pending این سفارش را برمی‌داریم
        if (!$payment) {
            $payment = $order->payments()->where('status', 'pending')->latest('id')->first();
        }

        /**
         * بررسی اختصاصی وضعیت بازگشتی درگاه سپ (سامان کیش)
         * اگر State مقدار OK نداشته باشد، کاربر فرآیند را لغو کرده یا خطای بانکی رخ داده است.
         *
         * نکته: باگ قبلی اینجا بود؛ قبل از آپدیت Order/Payment return می‌شد.
         */
        if (isset($callbackData['State']) && strtoupper((string) $callbackData['State']) !== 'OK') {
            $statusDescription = (string) $callbackData['State'];

            // اگر پیام حالت انصراف کاربر را داشته باشد => cancelled، در غیر اینصورت failed
            $isCanceledByUser =
                stripos($statusDescription, 'Canceled') !== false
                || stripos($statusDescription, 'Cancel') !== false;

            $orderStatus = $isCanceledByUser ? 'cancelled' : 'failed';

            DB::transaction(function () use ($order, $payment, $callbackData, $statusDescription, $orderStatus) {
                if ($payment) {
                    $payment->update([
                        'status'           => 'failed',
                        'failure_message'  => "SEP State: {$statusDescription}",
                        'response_payload' => array_merge($payment->response_payload ?? [], [
                            'callback_data' => $callbackData,
                            'failed_at'     => now()->toDateTimeString(),
                        ]),
                    ]);
                }

                $order->update([
                    'status' => $orderStatus,
                ]);
            });

            return [
                'success' => false,
                'message' => __('تراکنش توسط درگاه لغو شد یا ناموفق بود (وضعیت: :state)', ['state' => $statusDescription]),
                'payment' => $payment,
            ];
        }

        if (!$payment) {
            return [
                'success' => false,
                'message' => __('تراکنش معتبری برای این سفارش یافت نشد یا قبلاً پردازش شده است.'),
                'payment' => null,
            ];
        }

        try {
            $authorityToVerify = $payment->authority ?: $authority;

            // اعتبارسنجی تراکنش توسط درگاه مربوطه
            $receipt = ShetabitPayment::via($payment->gateway)
                ->amount((int) $payment->amount)
                ->transactionId($authorityToVerify)
                ->verify();

            $referenceId = (string) $receipt->getReferenceId();

            return DB::transaction(function () use ($order, $payment, $referenceId, $callbackData) {
                // ۱. به‌روزرسانی رکورد Payment با اطلاعات دریافتی
                $payment->update([
                    'reference_id'     => $referenceId,
                    'status'           => 'completed',
                    'paid_at'          => now(),
                    'response_payload' => array_merge($payment->response_payload ?? [], [
                        'callback_data' => $callbackData,
                        'verified_at'   => now()->toDateTimeString(),
                    ]),
                ]);

                // ۲. به‌روزرسانی وضعیت سفارش به پرداخت شده
                $order->update([
                    'status'  => 'paid',
                    'paid_at' => now(),
                ]);

                // ۳. نهایی‌سازی سفارش و فعال‌سازی سرویس‌ها/لایسنس
                $this->finalizeOrderServices($order);

                return [
                    'success'      => true,
                    'message'      => __('پرداخت با موفقیت انجام شد.'),
                    'reference_id' => $referenceId,
                    'payment'      => $payment,
                ];
            });
        } catch (InvalidPaymentException $e) {
            DB::transaction(function () use ($order, $payment, $callbackData, $e) {
                $payment->update([
                    'status'           => 'failed',
                    'failure_message'  => $e->getMessage(),
                    'response_payload' => array_merge($payment->response_payload ?? [], [
                        'callback_data' => $callbackData,
                        'error_message' => $e->getMessage(),
                        'failed_at'     => now()->toDateTimeString(),
                    ]),
                ]);

                // باگ قبلی: Order آپدیت نمی‌شد و pending می‌ماند
                $order->update([
                    'status' => 'failed',
                ]);
            });

            Log::warning('Payment verification failed (InvalidPayment)', [
                'order_id'   => $order->id,
                'payment_id' => $payment->id,
                'error'      => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage() ?: __('پرداخت توسط درگاه تأیید نشد یا توسط کاربر لغو گردید.'),
                'payment' => $payment,
            ];
        } catch (Exception $e) {
            DB::transaction(function () use ($order, $payment, $callbackData, $e) {
                $payment->update([
                    'status'           => 'failed',
                    'failure_message'  => $e->getMessage(),
                    'response_payload' => array_merge($payment->response_payload ?? [], [
                        'callback_data' => $callbackData,
                        'error_message' => $e->getMessage(),
                        'failed_at'     => now()->toDateTimeString(),
                    ]),
                ]);

                // باگ قبلی: Order آپدیت نمی‌شد و pending می‌ماند
                $order->update([
                    'status' => 'failed',
                ]);
            });

            Log::error('Payment verification server error', [
                'order_id'   => $order->id,
                'payment_id' => $payment->id,
                'error'      => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => __('خطای سیستمی در تأیید پرداخت: :message', ['message' => $e->getMessage()]),
                'payment' => $payment,
            ];
        }
    }

    /**
     * مدیریت سفارش‌های رایگان بدون ارجاع به درگاه بانکی
     */
    protected function handleFreeOrder(Order $order): array
    {
        return DB::transaction(function () use ($order) {
            $payment = Payment::create([
                'user_id'          => $order->user_id,
                'order_id'         => $order->id,
                'gateway'          => 'free',
                'authority'        => 'FREE-' . strtoupper(uniqid()),
                'reference_id'     => 'FREE-' . time(),
                'amount'           => 0,
                'currency'         => $order->currency ?: 'IRT',
                'status'           => 'completed',
                'paid_at'          => now(),
                'request_payload'  => ['type' => 'free_order'],
                'response_payload' => ['completed_at' => now()->toDateTimeString()],
            ]);

            $order->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            $this->finalizeOrderServices($order);

            return [
                'success'      => true,
                'payment'      => $payment,
                'redirect_url' => route('dashboard'),
                'is_free'      => true,
            ];
        });
    }

    /**
     * اعمال تغییرات بیزینس (فعال‌سازی پلن/پشتیبانی/لایسنس) پس از پرداخت قطعی
     */
    protected function finalizeOrderServices(Order $order): void
    {
        $user = $order->user;

        $cart = Cart::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($cart) {
            $this->checkoutService->completeCheckout($cart);
        }
    }
}
