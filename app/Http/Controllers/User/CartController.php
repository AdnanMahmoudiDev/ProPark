<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Throwable;

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

        // فعلاً plan را لود می‌کنیم؛ اگر support هم رابطه دارد بعداً اضافه می‌کنیم
        $cart->load(['plan']);

        $action = null;
        if ($cart->plan) {
            $action = $this->checkoutService->determineAction($user, $cart->plan->level);
        }

        return view('user.cart.index', compact('cart', 'action'));
    }

    /**
     * افزودن آیتم به سبد خرید
     * - یا plan_id (برای خرید پلن)
     * - یا support_package_id (برای خرید پشتیبانی)
     */
    public function store(Request $request)
    {
        // تشخیص مطمئن اینکه درخواست AJAX/Fetch است یا نه
        $wantsJson = $request->expectsJson() || $request->ajax();

        // 1) Validation
        $validated = $request->validate([
            'type' => ['nullable', 'string', Rule::in(['plan', 'support'])],

            'plan_id' => ['nullable', 'integer', 'exists:plans,id'],

            // اگر جدول/نامش فرق دارد، همین خط را عوض می‌کنی
            'support_package_id' => ['nullable', 'integer', 'exists:support_packages,id'],
        ]);

        $type = $validated['type']
            ?? ($request->filled('support_package_id') ? 'support' : 'plan');

        $hasPlan = $request->filled('plan_id');
        $hasSupport = $request->filled('support_package_id');

        // باید دقیقاً یکی از دو ورودی ارسال شده باشد
        if (($hasPlan && $hasSupport) || (!$hasPlan && !$hasSupport)) {
            return $this->validationFail($request, [
                'type' => ['باید دقیقاً یکی از plan_id یا support_package_id ارسال شود.'],
            ]);
        }

        if ($type === 'plan' && !$hasPlan) {
            return $this->validationFail($request, [
                'plan_id' => ['فیلد plan_id برای خرید پلن الزامی است.'],
            ]);
        }

        if ($type === 'support' && !$hasSupport) {
            return $this->validationFail($request, [
                'support_package_id' => ['فیلد support_package_id برای خرید پشتیبانی الزامی است.'],
            ]);
        }

        $user = Auth::user();

        // 2) جلوگیری از داشتن سبد pending همزمان
        if ($this->cartService->hasPendingCart($user)) {
            $msg = 'شما یک سبد خرید فعال و پرداخت‌نشده دارید. ابتدا آن را نهایی یا لغو کنید.';

            if ($wantsJson) {
                return response()->json(['message' => $msg], 409);
            }

            return redirect()
                ->route('user.cart.index')
                ->with('warning', $msg);
        }

        try {
            // 3) ساخت سبد بر اساس نوع
            if ($type === 'plan') {
                $plan = Plan::findOrFail((int) $request->input('plan_id'));

                $cart = $this->cartService->createPendingCart($user, $plan);

                $action = $this->checkoutService->determineAction($user, $plan->level);
                $cart->update(['type' => $action]);

                $msg = 'پلن با موفقیت به سبد خرید اضافه شد.';
            } else {
                $cart = $this->cartService->createPendingSupportCart(
                    $user,
                    (int) $request->input('support_package_id')
                );

                // اگر CartService خودش type را تنظیم می‌کند، این خط اختیاری است
                $cart->update(['type' => 'support']);

                $msg = 'پکیج پشتیبانی با موفقیت به سبد خرید اضافه شد.';
            }

            if ($wantsJson) {
                return response()->json([
                    'message'   => $msg,
                    'redirect'  => route('user.cart.index'),
                    'cart_id'   => $cart->id ?? null,
                    'cart_type' => $cart->type ?? null,
                ], 201);
            }

            return redirect()
                ->route('user.cart.index')
                ->with('success', $msg);

        } catch (Throwable $e) {

            // ✅ این بخش کلیدی است: همیشه لاگ کن تا خطا گم نشود
            Log::error('CartController@store failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'user_id' => $user?->id,
                'type'    => $type ?? null,
                'payload' => $request->all(),
            ]);

            if ($wantsJson) {
                return response()->json([
                    'message' => 'خطا در افزودن به سبد خرید',
                    'error'   => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * لغو سبد خرید جاری
     */
    public function destroy()
    {
        $user = Auth::user();

        if ($this->cartService->cancelPendingCart($user)) {
            return redirect()
                ->route('shop') // اگر route نداری، شما را بعداً فیکس می‌کنیم
                ->with('success', 'سبد خرید شما با موفقیت لغو شد.');
        }

        return redirect()
            ->back()
            ->with('error', 'سبد خرید فعالی برای لغو یافت نشد.');
    }

    /**
     * تسویه حساب و نهایی‌سازی سبد خرید
     */
    public function checkout()
    {
        $user = Auth::user();
        $cart = $this->cartService->getPendingCart($user);

        if (!$cart) {
            return redirect()
                ->route('shop') // اگر route نداری، این را بعداً فیکس می‌کنیم
                ->with('error', 'سبد خرید شما خالی است.');
        }

        try {
            $result = $this->checkoutService->completeCheckout($cart);

            $message = 'پرداخت و فعال‌سازی اشتراک شما با موفقیت انجام شد.';

            if (($result['action'] ?? null) === 'upgrade') {
                $message = 'اشتراک شما با موفقیت ارتقا یافت و لایسنس جدید صادر شد.';
            } elseif (($result['action'] ?? null) === 'downgrade') {
                $message = 'درخواست تغییر پلن شما اعمال شد.';
            } elseif (($result['action'] ?? null) === 'support') {
                $message = 'پکیج پشتیبانی شما با موفقیت فعال شد.';
            }

            return redirect()
                ->route('dashboard')
                ->with('success', $message);

        } catch (Throwable $e) {
            Log::error('CartController@checkout failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'user_id' => $user?->id,
                'cart_id' => $cart?->id,
            ]);

            return redirect()
                ->route('user.cart.index')
                ->with('error', 'خطایی در پردازش خرید رخ داد: ' . $e->getMessage());
        }
    }

    /**
     * helper: برگرداندن خطای ولیدیشن برای fetch و فرم معمولی
     */
    private function validationFail(Request $request, array $errors)
    {
        $wantsJson = $request->expectsJson() || $request->ajax();

        if ($wantsJson) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors'  => $errors,
            ], 422);
        }

        return redirect()
            ->back()
            ->withErrors($errors)
            ->withInput();
    }
}
