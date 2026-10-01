<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Plan;
use App\Models\User;
use Exception;

class CartService
{
    /**
     * گرفتن سبد خرید در انتظار کاربر
     */
    public function getPendingCart(User $user): ?Cart
    {
        return $user->carts()
            ->where('status', Cart::STATUS_PENDING)
            ->latest()
            ->first();
    }

    /**
     * بررسی وجود سبد خرید فعال
     */
    public function hasPendingCart(User $user): bool
    {
        return $this->getPendingCart($user) !== null;
    }

    /**
     * ایجاد سبد خرید جدید برای خرید پلن
     */
    public function createPendingCart(User $user, Plan $plan): Cart
    {
        if ($this->hasPendingCart($user)) {
            throw new Exception('User already has a pending cart.');
        }

        return Cart::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,

            // اگر در Cart مدل ثابت جدا برای پلن داری، بهتره TYPE را دقیق‌تر کنی.
            // فعلاً همان چیزی که خودت داشتی:
            'type'    => Cart::TYPE_PURCHASE,
            'status'  => Cart::STATUS_PENDING,
        ]);
    }

    /**
     * ایجاد سبد خرید جدید برای خرید پکیج پشتیبانی
     *
     * نکته: این متد فرض می‌کند در جدول carts ستون support_package_id وجود دارد.
     * اگر نام ستون متفاوت است، همینجا اصلاحش کن.
     */
    public function createPendingSupportCart(User $user, int $supportPackageId): Cart
    {
        if ($this->hasPendingCart($user)) {
            throw new Exception('User already has a pending cart.');
        }

        return Cart::create([
            'user_id'            => $user->id,
            'support_package_id' => $supportPackageId,

            // اگر TYPE جدا برای پشتیبانی داری بهتره:
            // 'type' => Cart::TYPE_SUPPORT,
            // ولی چون هنوز مطمئن نیستیم، از string هم میشه استفاده کرد؛
            // با این حال برای سازگاری با منطق کنترلر قبلی:
            'type'               => 'support',

            'status'             => Cart::STATUS_PENDING,
        ]);
    }

    /**
     * لغو سبد خرید pending
     */
    public function cancelPendingCart(User $user): bool
    {
        $cart = $this->getPendingCart($user);

        if (!$cart) {
            return false;
        }

        $cart->update([
            'status' => Cart::STATUS_CANCELED,
        ]);

        return true;
    }
}
