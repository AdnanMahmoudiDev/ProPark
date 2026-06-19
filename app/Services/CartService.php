<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Plan;
use App\Models\User;

class CartService
{
    public function getPendingCart(User $user): ?Cart
    {
        return $user->carts()
            ->where('status', 'pending')
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
            throw new \Exception('User already has a pending cart.');
        }

        return Cart::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'duration_months' => $durationMonths,
            'status' => 'pending',
        ]);
    }

    public function cancelPendingCart(User $user): bool
    {
        $cart = $this->getPendingCart($user);

        if (!$cart) {
            return false;
        }

        $cart->update([
            'status' => 'cancelled',
        ]);

        return true;
    }
}
