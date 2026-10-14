<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shetabit\Multipay\RedirectionForm;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    protected OrderService $orderService;

    protected PaymentService $paymentService;

    public function __construct(
        OrderService $orderService,
        PaymentService $paymentService
    ) {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    /**
     * شروع فرایند پرداخت از طریق سبد خرید
     */
    public function checkout(Request $request): Response
    {
        $user = Auth::user();

        // دریافت سبد خرید معلق کاربر
        $cart = Cart::where('user_id', $user->id)
            ->where('status', Cart::STATUS_PENDING)
            ->first();

        if (!$cart) {
            return redirect()->route('user.cart.index')
                ->with('error', __('سبد خرید شما خالی است یا قبلاً پردازش شده است.'));
        }

        try {
            // ۱. تبدیل سبد خرید به سفارش قطعی
            $order = $this->orderService->createOrderFromCart($cart);

            // ۲. تعیین درگاه پرداخت بر اساس درخواست یا درگاه پیش‌فرض
            $driver = $request->input('gateway', config('payment.default', 'sep'));

            $result = $this->paymentService->initiatePayment($order, $driver);

            // سفارش رایگان نیازی به انتقال به درگاه ندارد
            if (!empty($result['is_free'])) {
                return redirect()->route('dashboard')
                    ->with('success', __('سفارش شما با موفقیت و بدون هزینه ثبت و فعال گردید.'));
            }

            /*
             * درگاه سپ باید با POST و پارامترهای فرم فراخوانی شود.
             * بنابراین فرم آماده‌شده توسط پکیج را به مرورگر برمی‌گردانیم،
             * نه اینکه فقط با GET به آدرس درگاه redirect کنیم.
             */
            $redirection = $result['redirection'] ?? null;

            if ($redirection instanceof RedirectionForm) {
                return response(
                    $redirection->render(),
                    Response::HTTP_OK,
                    ['Content-Type' => 'text/html; charset=UTF-8']
                );
            }

            /*
             * مسیر جایگزین برای درگاه‌هایی که خروجی آن‌ها فرم RedirectionForm نیست.
             */
            $redirectUrl = $result['redirect_url'] ?? null;

            if (!empty($redirectUrl)) {
                return redirect()->away($redirectUrl);
            }

            throw new Exception(__('اطلاعات انتقال به درگاه پرداخت دریافت نشد.'));
        } catch (Exception $e) {
            return redirect()->route('user.cart.index')
                ->with(
                    'error',
                    __('خطا در انتقال به درگاه پرداخت: :message', [
                        'message' => $e->getMessage(),
                    ])
                );
        }
    }

    /**
     * بازگشت از درگاه پرداخت و اعتبارسنجی تراکنش (Callback)
     */
    public function callback(Request $request, Order $order): RedirectResponse
    {
        // اگر کاربر وارد شده باشد، فقط اجازهٔ دسترسی به سفارش خودش را دارد.
        if (Auth::check() && Auth::id() !== $order->user_id) {
            abort(403, __('شما دسترسی به این سفارش را ندارید.'));
        }

        // جلوگیری از پردازش دوبارهٔ سفارشی که قبلاً پرداخت شده است
        if (
            defined(Order::class . '::STATUS_PAID')
            && $order->status === Order::STATUS_PAID
        ) {
            return redirect()->route('dashboard')
                ->with('success', __('این سفارش قبلاً با موفقیت پرداخت و ثبت گردیده است.'));
        }

        // اعتبارسنجی تراکنش با داده‌های دریافتی از درگاه، شامل GET و POST
        $result = $this->paymentService->verifyPayment($order, $request->all());

        if (!empty($result['success'])) {
            return redirect()->route('dashboard')
                ->with(
                    'success',
                    __(
                        'پرداخت با موفقیت انجام شد. شماره پیگیری: :ref',
                        ['ref' => $result['reference_id'] ?? '-']
                    )
                );
        }

        // پرداخت ناموفق یا لغوشده
        return redirect()->route('user.cart.index')
            ->with(
                'error',
                __(
                    'پرداخت ناموفق بود یا توسط شما لغو شد: :message',
                    [
                        'message' => $result['message']
                            ?? __('خطایی در انجام تراکنش رخ داد.'),
                    ]
                )
            );
    }
}
