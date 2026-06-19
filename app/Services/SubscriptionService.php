<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionService
{
    public function getActiveSubscription(User $user): ?Subscription
    {
        return $user->subscriptions()
            ->where('expires_at', '>', now())
            ->latest()
            ->first();
    }

    public function createSubscription(User $user, Plan $plan, int $durationMonths): Subscription
    {
        $expiresAt = now()->addMonths($durationMonths);

        return Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'expires_at' => $expiresAt,
        ]);
    }

    public function renewSubscription(Subscription $subscription, int $durationMonths): Subscription
    {
        $subscription->update([
            'expires_at' => Carbon::parse($subscription->expires_at)->addMonths($durationMonths),
        ]);

        return $subscription->fresh();
    }

    public function upgradeSubscription(Subscription $subscription, Plan $newPlan, int $durationMonths): Subscription
    {
        $remainingSeconds = max(now()->diffInSeconds($subscription->expires_at, false), 0);
        $bonusSeconds = (int) floor($remainingSeconds / 2);

        $newExpiresAt = now()
            ->addMonths($durationMonths)
            ->addSeconds($bonusSeconds);

        $subscription->update([
            'plan_id' => $newPlan->id,
            'starts_at' => now(),
            'expires_at' => $newExpiresAt,
        ]);

        return $subscription->fresh();
    }

    public function downgradeSubscription(Subscription $subscription, Plan $newPlan, int $durationMonths): Subscription
    {
        $remainingSeconds = max(now()->diffInSeconds($subscription->expires_at, false), 0);

        $newExpiresAt = now()
            ->addMonths($durationMonths)
            ->addSeconds($remainingSeconds);

        $subscription->update([
            'plan_id' => $newPlan->id,
            'starts_at' => now(),
            'expires_at' => $newExpiresAt,
        ]);

        return $subscription->fresh();
    }

    public function getRemainingDays(Subscription $subscription): int
    {
        $remainingSeconds = max(now()->diffInSeconds($subscription->expires_at, false), 0);

        return (int) ceil($remainingSeconds / 86400);
    }
}
