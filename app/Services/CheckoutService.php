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

    public function determineAction(User $user, int $newPlanLevel): string
    {
        $activeSub = $this->subscriptionService->getActiveSubscription($user);

        if (!$activeSub) {
            return Cart::TYPE_PURCHASE;
        }

        $currentPlanLevel = (int) ($activeSub->plan->level ?? 0);

        if ($newPlanLevel > $currentPlanLevel) {
            return Cart::TYPE_UPGRADE;
        }

        if ($newPlanLevel < $currentPlanLevel) {
            return Cart::TYPE_DOWNGRADE;
        }

        return Cart::TYPE_RENEW;
    }

    public function completeCheckout(Cart $cart): array
    {
        return DB::transaction(function () use ($cart) {

            // نکته: برای پشتیبانی هم باید user و supportPackage را لود کنیم
            $cart = Cart::query()
                ->with(['user', 'plan', 'supportPackage'])
                ->lockForUpdate()
                ->findOrFail($cart->id);

            if ($cart->status !== Cart::STATUS_PENDING) {
                throw new Exception('این سبد خرید قبلاً تعیین تکلیف شده است.');
            }

            if (!$cart->user) {
                throw new Exception('کاربر مربوط به این سبد خرید یافت نشد.');
            }

            // تشخیص نوع سبد خرید:
            $isSupportCart = !empty($cart->support_package_id);
            $isPlanCart    = !empty($cart->plan_id);

            // باید دقیقاً یکی از این دو نوع باشد
            if (($isSupportCart && $isPlanCart) || (!$isSupportCart && !$isPlanCart)) {
                throw new Exception('نوع سبد خرید نامعتبر است (plan/support مشخص نیست).');
            }

            if ($isSupportCart) {
                return $this->checkoutSupportPackage($cart);
            }

            // در غیر اینصورت، پلن است
            return $this->checkoutPlan($cart);
        });
    }

    /**
     * Checkout پلن‌ها (منطق قبلی شما، با کمترین تغییر)
     */
    protected function checkoutPlan(Cart $cart): array
    {
        if (!$cart->plan) {
            throw new Exception('پلن مربوط به این سبد خرید یافت نشد.');
        }

        $user = $cart->user;
        $newPlan = $cart->plan;

        $action = $this->determineAction($user, (int) $newPlan->level);
        $activeSub = $this->subscriptionService->getActiveSubscription($user);

        switch ($action) {
            case Cart::TYPE_PURCHASE:
                $subscription = $this->subscriptionService->createSubscription(
                    $user,
                    $newPlan
                );

                $this->licenseService->createLicense($subscription);
                break;

            case Cart::TYPE_RENEW:
                if (!$activeSub) {
                    throw new Exception('اشتراک فعالی برای تمدید یافت نشد.');
                }
                // در سیستم مادام‌العمر، تمدید مربوط به سرویس پشتیبانی است
                $this->subscriptionService->renewSupport($activeSub);
                break;

            case Cart::TYPE_UPGRADE:
                if (!$activeSub) {
                    throw new Exception('اشتراک فعالی برای ارتقا یافت نشد.');
                }

                $this->subscriptionService->upgradeSubscription(
                    $activeSub,
                    $newPlan
                );
                break;

            case Cart::TYPE_DOWNGRADE:
                if (!$activeSub) {
                    throw new Exception('اشتراک فعالی برای تنزل یافت نشد.');
                }

                $this->subscriptionService->downgradeSubscription(
                    $activeSub,
                    $newPlan
                );

                $deviceLimit = (int) ($newPlan->device_limit ?? $newPlan->max_devices ?? 0);
                $this->enforceDeviceLimitAfterDowngrade($user, $deviceLimit);
                break;

            default:
                throw new Exception('نوع عملیات نامعتبر است.');
        }

        $cart->update([
            'status' => Cart::STATUS_COMPLETED,
            'type'   => $action,
        ]);

        return [
            'success' => true,
            'action'  => $action,
            'message' => 'پرداخت با موفقیت انجام و تغییرات اعمال گردید.',
        ];
    }

    /**
     * Checkout پکیج پشتیبانی
     *
     * نکته: چون هنوز معماری دقیق پکیج‌های پشتیبانی شما (مدت/قیمت/ذخیره در DB) را ندارم،
     * اینجا حداقل مسیر صحیح را پیاده می‌کنیم:
     * - وجود پکیج چک می‌شود
     * - اگر اشتراک فعال وجود داشت -> renewSupport فراخوانی می‌شود (معمولاً یعنی تمدید پشتیبانی)
     * - سبد خرید completed می‌شود
     */
    protected function checkoutSupportPackage(Cart $cart): array
    {
        // اگر رابطه supportPackage را ساختی، بهتر است وجودش را چک کنیم
        if (!$cart->supportPackage) {
            throw new Exception('پکیج پشتیبانی مربوط به این سبد خرید یافت نشد.');
        }

        $user = $cart->user;

        // در سیستم شما تمدید پشتیبانی روی اشتراک فعال انجام می‌شود
        $activeSub = $this->subscriptionService->getActiveSubscription($user);

        if (!$activeSub) {
            // بسته به بیزینس شما ممکن است اجازه خرید پشتیبانی بدون اشتراک فعال ندهی
            throw new Exception('برای خرید پشتیبانی، ابتدا باید یک اشتراک فعال داشته باشید.');
        }

        // فعلاً پکیج پشتیبانی را معادل تمدید/فعال‌سازی پشتیبانی در نظر می‌گیریم
        // اگر duration_months داری، مرحله بعدی اینجا دقیقش می‌کنیم.
        $this->subscriptionService->renewSupport($activeSub);

        $cart->update([
            'status' => Cart::STATUS_COMPLETED,
            'type'   => Cart::TYPE_SUPPORT, // در مدل Cart اضافه کردیم
        ]);

        return [
            'success' => true,
            'action'  => Cart::TYPE_SUPPORT,
            'message' => 'پکیج پشتیبانی با موفقیت فعال شد.',
        ];
    }

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
