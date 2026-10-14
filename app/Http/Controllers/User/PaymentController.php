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

class PaymentController extends Controller
{
    protected OrderService $orderService;
    protected PaymentService $paymentService;

    public function __construct(OrderService $orderService, PaymentService $paymentService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    /**
     * شروع فرایند پرداخت از طریق سبد خرید
     */
    public function checkout(Request $request): RedirectResponse
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

            // ۲. تعیین درگاه پرداخت بر اساس درخواست یا پیش‌فرض کانفیگ
            $driver = $request->input('gateway', config('payment.default', 'sep'));
            $result = $this->paymentService->initiatePayment($order, $driver);

            // اگر سفارش رایگان بود، مستقیم به داشبورد هدایت شود
            if (!empty($result['is_free'])) {
                return redirect()->route('dashboard')
                    ->with('success', __('سفارش شما با موفقیت و بدون هزینه ثبت و فعال گردید.'));
            }

            // ۳. هدایت کاربر به صفحه امن درگاه بانکی
            return redirect()->away($result['redirect_url']);

        } catch (Exception $e) {
            return redirect()->route('user.cart.index')
                ->with('error', __('خطا در انتقال به درگاه پرداخت: :message', ['message' => $e->getMessage()]));
        }
    }

    /**
     * بازگشت از درگاه پرداخت و اعتبارسنجی تراکنش (Callback)
     */
    public function callback(Request $request, Order $order): RedirectResponse
    {
        // در صورتی که سشن به دلیل ارسال POST از دامنه خارجی منقضی/ارسال نشده باشد،
        // کاربر مالک سفارش به طور امن لاگین می‌شود.
        if (!Auth::check()) {
            Auth::loginUsingId($order->user_id);
        } elseif (Auth::id() !== $order->user_id) {
            abort(403, __('شما دسترسی به این سفارش را ندارید.'));
        }

        // جلوگیری از تکرار فرآیند اعتبارسنجی در صورت رفرش صفحه یا پردازش قبلی
        if (defined(Order::class . '::STATUS_PAID') && $order->status === Order::STATUS_PAID) {
            return redirect()->route('dashboard')
                ->with('success', __('این سفارش قبلاً با موفقیت پرداخت و ثبت گردیده است.'));
        }

        // اعتبارسنجی تراکنش توسط سرویس پرداخت با ارسال کل داده‌های Request (متدهای GET و POST)
        $result = $this->paymentService->verifyPayment($order, $request->all());

        if (!empty($result['success'])) {
            return redirect()->route('dashboard')
                ->with('success', __(
                    'پرداخت با موفقیت انجام شد. شماره پیگیری: :ref',
                    ['ref' => $result['reference_id'] ?? '-']
                ));
        }

        // در صورت ناموفق بودن پرداخت، بازگشت به سبد خرید همراه با پیام خطا
        return redirect()->route('user.cart.index')
            ->with('error', __(
                'پرداخت ناموفق بود یا توسط شما لغو شد: :message',
                ['message' => $result['message'] ?? __('خطایی در انجام تراکنش رخ داد.')]
            ));
    }
}
