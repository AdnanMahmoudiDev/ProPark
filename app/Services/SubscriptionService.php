<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * گرفتن آخرین اشتراک فعال کاربر
     */
    public function getActiveSubscription(User $user): ?Subscription
    {
        return $user->subscriptions()
            ->active()
            ->latest('expires_at')
            ->first();
    }

    /**
     * ساخت اشتراک جدید
     */
    public function createSubscription(
        User $user,
        Plan $plan,
        int $durationMonths
    ): Subscription {

        $startedAt = now();
        $expiresAt = $startedAt->copy()->addMonths($durationMonths);

        return Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'started_at' => $startedAt,
            'expires_at' => $expiresAt,
            'status' => Subscription::STATUS_ACTIVE,
        ]);
    }

    /**
     * تمدید اشتراک
     */
    public function renewSubscription(
        Subscription $subscription,
        int $durationMonths
    ): Subscription {

        $baseDate = $subscription->expires_at && $subscription->expires_at->isFuture()
            ? $subscription->expires_at
            : now();

        $newExpiresAt = $baseDate->copy()->addMonths($durationMonths);

        $subscription->update([
            'expires_at' => $newExpiresAt,
            'status' => Subscription::STATUS_ACTIVE,
        ]);

        return $subscription->fresh();
    }

    /**
     * ارتقا پلن
     * نصف زمان باقی‌مانده به عنوان بونوس منتقل می‌شود
     */
    public function upgradeSubscription(
        Subscription $subscription,
        Plan $newPlan,
        int $durationMonths
    ): Subscription {

        $remainingSeconds = max(
            now()->diffInSeconds($subscription->expires_at, false),
            0
        );

        $bonusSeconds = (int) floor($remainingSeconds / 2);

        $newExpiresAt = now()
            ->addMonths($durationMonths)
            ->addSeconds($bonusSeconds);

        $subscription->update([
            'plan_id' => $newPlan->id,
            'started_at' => now(),
            'expires_at' => $newExpiresAt,
            'status' => Subscription::STATUS_ACTIVE,
        ]);

        return $subscription->fresh();
    }

    /**
     * کاهش پلن
     * تمام زمان باقی‌مانده منتقل می‌شود
     */
    public function downgradeSubscription(
        Subscription $subscription,
        Plan $newPlan,
        int $durationMonths
    ): Subscription {

        $remainingSeconds = max(
            now()->diffInSeconds($subscription->expires_at, false),
            0
        );

        $newExpiresAt = now()
            ->addMonths($durationMonths)
            ->addSeconds($remainingSeconds);

        $subscription->update([
            'plan_id' => $newPlan->id,
            'started_at' => now(),
            'expires_at' => $newExpiresAt,
            'status' => Subscription::STATUS_ACTIVE,
        ]);

        return $subscription->fresh();
    }

    /**
     * تعداد روز باقی مانده
     */
    public function getRemainingDays(Subscription $subscription): int
    {
        if (!$subscription->expires_at) {
            return 0;
        }

        $remainingSeconds = max(
            now()->diffInSeconds($subscription->expires_at, false),
            0
        );

        return (int) ceil($remainingSeconds / 86400);
    }
}
