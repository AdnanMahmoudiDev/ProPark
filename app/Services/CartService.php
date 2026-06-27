<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Plan;
use App\Models\PlanPrice;
use App\Models\User;
use Exception;

class CartService
{
    public function getPendingCart(User $user): ?Cart
    {
        return $user->carts()
            ->pending()
            ->latest()
            ->first();
    }

    public function hasPendingCart(User $user): bool
    {
        return $this->getPendingCart($user) !== null;
    }

    public function createPendingCart(User $user, Plan $plan, int $durationMonths): Cart
    {
        if ($this->hasPendingCart($user)) {
            throw new Exception('User already has a pending cart.');
        }

        $planPrice = $this->resolveActivePlanPrice($plan, $durationMonths);

        return Cart::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'plan_price_id' => $planPrice->id,
            'type' => Cart::TYPE_PURCHASE,
            'status' => Cart::STATUS_PENDING,
        ]);
    }

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

    private function resolveActivePlanPrice(Plan $plan, int $durationMonths): PlanPrice
    {
        $planPrice = $plan->prices()
            ->where('duration_months', $durationMonths)
            ->where('is_active', true)
            ->first();

        if (!$planPrice) {
            throw new Exception('Selected plan price is not available.');
        }

        return $planPrice;
    }
}
