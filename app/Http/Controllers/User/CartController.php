<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class CartController extends Controller
{
    protected CartService $cartService;
    protected CheckoutService $checkoutService;

    public function __construct(CartService $cartService, CheckoutService $checkoutService)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
    }

    /**
     * نمایش سبد خرید جاری کاربر
     */
    public function index()
    {
        $user = Auth::user();
        $cart = $this->cartService->getPendingCart($user);

        if (!$cart) {
            return view('user.cart.index', ['cart' => null]);
        }

        // بارگذاری روابط مورد نیاز برای نمایش اطلاعات در Blade
        $cart->load(['plan', 'planPrice']);

        // محاسبه نوع عملیات به صورت پویا جهت نمایش به کاربر
        $action = $this->checkoutService->determineAction($user, $cart->plan->level);

        return view('user.cart.index', compact('cart', 'action'));
    }

    /**
     * افزودن آیتم به سبد خرید
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'duration_months' => ['required', 'integer', 'min:1'],
        ]);

        $user = Auth::user();

        // اگر کاربر از قبل سبد خرید در جریان دارد، ابتدا باید آن را تعیین تکلیف کند
        if ($this->cartService->hasPendingCart($user)) {
            return redirect()->route('user.cart.index')->with(
                'warning', 
                'شما یک سبد خرید فعال و پرداخت‌نشده دارید. ابتدا آن را نهایی یا لغو کنید.'
            );
        }

        try {
            $plan = Plan::findOrFail($request->input('plan_id'));
            
            // ایجاد سبد خرید در وضعیت Pending
            $cart = $this->cartService->createPendingCart(
                $user, 
                $plan, 
                $request->input('duration_months')
            );

            // بروزرسانی نوع تراکنش بر اساس وضعیت فعلی اشتراک کاربر
            $action = $this->checkoutService->determineAction($user, $plan->level);
            $cart->update(['type' => $action]);

            return redirect()->route('user.cart.index')->with('success', 'پلن با موفقیت به سبد خرید اضافه شد.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * لغو یا حذف سبد خرید جاری
     */
    public function destroy()
    {
        $user = Auth::user();
        
        if ($this->cartService->cancelPendingCart($user)) {
            return redirect()->route('shop')->with('success', 'سبد خرید شما با موفقیت لغو شد.');
        }

        return redirect()->back()->with('error', 'سبد خرید فعالی برای لغو یافت نشد.');
    }

    /**
     * تسویه حساب و نهایی‌سازی سبد خرید
     */
    public function checkout()
    {
        $user = Auth::user();
        $cart = $this->cartService->getPendingCart($user);

        if (!$cart) {
            return redirect()->route('shop')->with('error', 'سبد خرید شما خالی است.');
        }

        try {
            // نهایی سازی خرید از طریق سرویس چک‌اوت (شامل تراکنش دیتابیس)
            $result = $this->checkoutService->completeCheckout($cart);

            $message = 'پرداخت و فعال‌سازی اشتراک شما با موفقیت انجام شد.';
            if ($result['action'] === 'upgrade') {
                $message = 'اشتراک شما با موفقیت ارتقا یافت و لایسنس جدید صادر شد.';
            } elseif ($result['action'] === 'downgrade') {
                $message = 'درخواست تغییر پلن شما به سطح پایین‌تر اعمال شد.';
            } elseif ($result['action'] === 'renew') {
                $message = 'مدت زمان اشتراک شما با موفقیت تمدید شد.';
            }

            return redirect()->route('dashboard')->with('success', $message);
        } catch (Exception $e) {
            return redirect()->route('user.cart.index')->with('error', 'خطایی در پردازش خرید رخ داد: ' . $e->getMessage());
        }
    }
}
