<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\SubscriptionService;
use App\Services\LicenseService;
use App\Services\CartService;
use RuntimeException;

class CheckoutService
{
    protected SubscriptionService $subscriptionService;
    protected LicenseService $licenseService;
    protected CartService $cartService;

    public function __construct(
        SubscriptionService $subscriptionService,
        LicenseService $licenseService,
        CartService $cartService
    ) {
        $this->subscriptionService = $subscriptionService;
        $this->licenseService = $licenseService;
        $this->cartService = $cartService;
    }

    public function determineAction(User $user, int $newPlanLevel): string
    {
        $subscription = $this->subscriptionService->getActiveSubscription($user);

        if (!$subscription) {
            return 'purchase';
        }

        $currentPlanLevel = $subscription->plan->level;

        if ($newPlanLevel > $currentPlanLevel) {
            return 'upgrade';
        }

        if ($newPlanLevel < $currentPlanLevel) {
            return 'downgrade';
        }

        return 'renew';
    }

    public function completeCheckout(Cart $cart): array
    {
        return DB::transaction(function () use ($cart) {

            $cart = Cart::where('id', $cart->id)
                ->lockForUpdate()
                ->first();

            if ($cart->status !== Cart::STATUS_PENDING) {
                throw new RuntimeException('Cart already processed.');
            }

            $user = $cart->user;
            $plan = $cart->plan;
            $planPrice = $cart->planPrice;

            $durationMonths = $planPrice->duration_months;

            $action = $this->determineAction($user, $plan->level);

            $subscription = $this->subscriptionService->getActiveSubscription($user);

            if ($action === 'purchase') {

                $subscription = $this->subscriptionService->createSubscription(
                    $user,
                    $plan,
                    $durationMonths
                );

                $this->licenseService->createLicense($subscription);

            } elseif ($action === 'renew') {

                $this->subscriptionService->renewSubscription(
                    $subscription,
                    $durationMonths
                );

            } elseif ($action === 'upgrade') {

                $this->subscriptionService->upgradeSubscription(
                    $subscription,
                    $plan,
                    $durationMonths
                );

            } elseif ($action === 'downgrade') {

                $this->subscriptionService->downgradeSubscription(
                    $subscription,
                    $plan,
                    $durationMonths
                );

            }

            $cart->update([
                'status' => Cart::STATUS_COMPLETED,
            ]);

            return [
                'message' => 'checkout completed',
                'action' => $action,
            ];
        });
    }

}
