<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Models\SubscriptionSupport;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    /**
     * دریافت اشتراک/لایسنس فعال کاربر (در مدل Lifetime معمولاً یک Active داریم)
     */
    public function getActiveSubscription(User $user): ?Subscription
    {
        return $user->subscriptions()
            ->where('status', Subscription::STATUS_ACTIVE)
            ->latest('id')
            ->first();
    }

    /**
     * ساخت اشتراک جدید (مادام‌العمر)
     * + اگر اولین خرید کاربر باشد، 6 ماه پشتیبانی رایگان ایجاد می‌کند
     */
    public function createSubscription(User $user, Plan $plan): Subscription
    {
        return DB::transaction(function () use ($user, $plan) {

            // تعریف "اولین خرید": کاربر هیچ Subscription قبلی نداشته باشد
            $isFirstPurchase = !$user->subscriptions()->exists();

            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'status'  => Subscription::STATUS_ACTIVE,
            ]);

            // ایجاد پشتیبانی 6 ماهه فقط برای اولین خرید
            if ($isFirstPurchase) {
                $subscription->supports()->create([
                    'starts_at'  => now(),
                    'expires_at' => now()->addMonths(6),
                    'status'     => SubscriptionSupport::STATUS_ACTIVE,
                ]);
            }

            return $subscription;
        });
    }

    /**
     * ارتقا پلن لایسنس
     */
    public function upgradeSubscription(Subscription $subscription, Plan $newPlan): Subscription
    {
        $subscription->update([
            'plan_id' => $newPlan->id,
        ]);

        return $subscription->fresh();
    }

    /**
     * کاهش پلن لایسنس
     */
    public function downgradeSubscription(Subscription $subscription, Plan $newPlan): Subscription
    {
        $subscription->update([
            'plan_id' => $newPlan->id,
        ]);

        return $subscription->fresh();
    }

    /**
     * تمدید پشتیبانی (به‌روزرسانی رکورد قبلی یا ساخت در صورت عدم وجود)
     */
    public function renewSupport(Subscription $subscription, int $months = 6): SubscriptionSupport
    {
        return DB::transaction(function () use ($subscription, $months) {

            // پیدا کردن آخرین رکورد پشتیبانی فعال یا منقضی شده‌ی کاربر
            $support = $subscription->supports()
                ->latest('expires_at')
                ->first();

            if ($support) {
                // اگر رکورد پشتیبانی وجود دارد، تاریخ انقضای آن را آپدیت می‌کنیم (بدون ساخت رکورد جدید)
                $currentExpiry = $support->expires_at;

                if ($currentExpiry && $currentExpiry->isFuture()) {
                    // اگر هنوز منقضی نشده، ماه‌های جدید به تاریخ انقضای قبلی اضافه می‌شود
                    $newExpiresAt = (clone $currentExpiry)->addMonths($months);
                } else {
                    // اگر منقضی شده است، از زمان حال محاسبه می‌شود
                    $newExpiresAt = now()->addMonths($months);
                }

                $support->update([
                    'expires_at' => $newExpiresAt,
                    'status'     => SubscriptionSupport::STATUS_ACTIVE,
                ]);

                return $support->fresh();
            }

            // اگر کاربر کلاً هیچ رکورد پشتیبانی نداشته، یک رکورد جدید می‌سازیم
            return $subscription->supports()->create([
                'starts_at'  => now(),
                'expires_at' => now()->addMonths($months),
                'status'     => SubscriptionSupport::STATUS_ACTIVE,
            ]);
        });
    }

    /**
     * بررسی فعال بودن پشتیبانی
     */
    public function hasActiveSupport(Subscription $subscription): bool
    {
        return $subscription->supports()
            ->where('status', SubscriptionSupport::STATUS_ACTIVE)
            ->where('expires_at', '>=', now())
            ->exists();
    }

    /**
     * محاسبه روزهای باقی‌مانده پشتیبانی
     */
    public function getRemainingSupportDays(Subscription $subscription): int
    {
        $support = $subscription->supports()
            ->where('status', SubscriptionSupport::STATUS_ACTIVE)
            ->latest('expires_at')
            ->first();

        if (!$support || !$support->expires_at) {
            return 0;
        }

        $remaining = now()->diffInDays($support->expires_at, false);

        return max(0, (int) $remaining);
    }
}
