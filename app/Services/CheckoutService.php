<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class CheckoutService
{
    protected SubscriptionService $subscriptionService;
    protected LicenseService $licenseService;

    public function __construct(
        SubscriptionService $subscriptionService,
        LicenseService $licenseService
    ) {
        $this->subscriptionService = $subscriptionService;
        $this->licenseService = $licenseService;
    }

    /**
     * تشخیص نوع اکشن کاربر بر اساس پلن جدید و اشتراک فعلی
     */
    public function determineAction(User $user, int $newPlanLevel): string
    {
        $activeSub = $this->subscriptionService->getActiveSubscription($user);

        if (!$activeSub) {
            return Cart::TYPE_PURCHASE; // خرید اول
        }

        $currentPlanLevel = $activeSub->plan->level;

        if ($newPlanLevel > $currentPlanLevel) {
            return Cart::TYPE_UPGRADE; // ارتقا
        }

        if ($newPlanLevel < $currentPlanLevel) {
            return Cart::TYPE_DOWNGRADE; // تنزل
        }

        return Cart::TYPE_RENEW; // تمدید
    }

    /**
     * نهایی‌سازی خرید به صورت کاملاً امن و تراکنشی
     */
    public function completeCheckout(Cart $cart): array
    {
        return DB::transaction(function () use ($cart) {
            // قفل کردن ردیف سبد خرید برای جلوگیری از Race Conditions
            $cart = Cart::with(['user', 'plan', 'planPrice'])
                ->lockForUpdate()
                ->findOrFail($cart->id);

            if ($cart->status !== Cart::STATUS_PENDING) {
                throw new Exception('این سبد خرید قبلاً تعیین تکلیف شده است.');
            }

            if (!$cart->planPrice) {
                throw new Exception('قیمت پلن برای این سبد خرید یافت نشد.');
            }

            $user = $cart->user;
            $newPlan = $cart->plan;
            $planPriceId = $cart->plan_price_id;
            $durationMonths = (int) $cart->planPrice->duration_months;

            if (!$planPriceId) {
                throw new Exception('شناسه قیمت پلن برای این خرید نامعتبر است.');
            }

            // تشخیص اکشن واقعی
            $action = $this->determineAction($user, (int) $newPlan->level);

            // گرفتن اشتراک فعال فعلی (در صورت وجود)
            $activeSub = $this->subscriptionService->getActiveSubscription($user);

            switch ($action) {
                case Cart::TYPE_PURCHASE:
                    // ایجاد اشتراک جدید همراه با plan_price_id خرید
                    $subscription = $this->subscriptionService->createSubscription(
                        $user,
                        $newPlan,
                        $planPriceId,
                        $durationMonths
                    );

                    // ایجاد لایسنس جدید متصل به اشتراک
                    $this->licenseService->createLicense($subscription);
                    break;

                case Cart::TYPE_RENEW:
                    if (!$activeSub) {
                        throw new Exception('اشتراک فعالی برای تمدید یافت نشد.');
                    }

                    // اگر لازم داری plan_price_id جدید تمدید هم ذخیره شود،
                    // باید امضای renewSubscription را هم مشابه همین تغییر بدهی.
                    $this->subscriptionService->renewSubscription($activeSub, $durationMonths);
                    break;

                case Cart::TYPE_UPGRADE:
                    if (!$activeSub) {
                        throw new Exception('اشتراک فعالی برای ارتقا یافت نشد.');
                    }

                    // اگر لازم داری plan_price_id جدید ارتقا هم ذخیره شود،
                    // باید امضای upgradeSubscription را هم مشابه همین تغییر بدهی.
                    $this->subscriptionService->upgradeSubscription($activeSub, $newPlan, $durationMonths);
                    break;

                case Cart::TYPE_DOWNGRADE:
                    if (!$activeSub) {
                        throw new Exception('اشتراک فعالی برای تنزل یافت نشد.');
                    }

                    // اگر لازم داری plan_price_id جدید تنزل هم ذخیره شود،
                    // باید امضای downgradeSubscription را هم مشابه همین تغییر بدهی.
                    $this->subscriptionService->downgradeSubscription($activeSub, $newPlan, $durationMonths);

                    $deviceLimit = (int) ($newPlan->device_limit ?? $newPlan->max_devices ?? 0);

                    // اجرای قانون محدودیت دستگاه‌ها پس از تنزل پلن
                    $this->enforceDeviceLimitAfterDowngrade($user, $deviceLimit);
                    break;

                default:
                    throw new Exception('نوع عملیات نامعتبر است.');
            }

            // ثبت اتمام موفقیت‌آمیز سبد خرید
            $cart->update([
                'status' => Cart::STATUS_COMPLETED,
                'type' => $action,
            ]);

            return [
                'success' => true,
                'action' => $action,
                'message' => 'پرداخت با موفقیت انجام و تغییرات اشتراک اعمال گردید.',
            ];
        });
    }

    /**
     * حذف دستگاه‌های مازاد متصل به لایسنس‌های کاربر پس از تنزل پلن
     */
    protected function enforceDeviceLimitAfterDowngrade(User $user, int $allowedDevices): void
    {
        if ($allowedDevices <= 0) {
            return;
        }

        $licenseIds = DB::table('licenses')
            ->where('user_id', $user->id)
            ->pluck('id');

        if ($licenseIds->isEmpty()) {
            return;
        }

        $connectedDevices = DB::table('license_devices')
            ->whereIn('license_id', $licenseIds)
            ->orderByDesc('activated_at')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $connectedCount = $connectedDevices->count();

        if ($connectedCount > $allowedDevices) {
            $excessCount = $connectedCount - $allowedDevices;
            $deviceIdsToDelete = $connectedDevices->take($excessCount)->pluck('id');

            DB::table('license_devices')
                ->whereIn('id', $deviceIdsToDelete)
                ->delete();
        }
    }
}
