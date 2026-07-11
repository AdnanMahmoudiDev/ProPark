<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Plan;
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
            $cart = Cart::lockForUpdate()->findOrFail($cart->id);

            if ($cart->status !== Cart::STATUS_PENDING) {
                throw new Exception('این سبد خرید قبلاً تعیین تکلیف شده است.');
            }

            $user = $cart->user;
            $newPlan = $cart->plan;
            $durationMonths = $cart->planPrice->duration_months;

            // تشخیص اکشن واقعی
            $action = $this->determineAction($user, $newPlan->level);

            // گرفتن اشتراک فعال فعلی (در صورت وجود)
            $activeSub = $this->subscriptionService->getActiveSubscription($user);

            switch ($action) {
                case Cart::TYPE_PURCHASE:
                    // ایجاد اشتراک جدید
                    $subscription = $this->subscriptionService->createSubscription(
                        $user,
                        $newPlan,
                        $durationMonths
                    );
                    
                    // ایجاد لایسنس جدید متصل به اشتراک
                    $this->licenseService->createLicense($subscription);
                    break;

                case Cart::TYPE_RENEW:
                    if (!$activeSub) {
                        throw new Exception('اشتراک فعالی برای تمدید یافت نشد.');
                    }
                    // تمدید اشتراک فعلی
                    $this->subscriptionService->renewSubscription($activeSub, $durationMonths);
                    break;

                case Cart::TYPE_UPGRADE:
                    if (!$activeSub) {
                        throw new Exception('اشتراک فعالی برای ارتقا یافت نشد.');
                    }
                    // ارتقای اشتراک فعلی (نصف زمان باقی‌مانده به عنوان بونوس منتقل می‌شود)
                    $this->subscriptionService->upgradeSubscription($activeSub, $newPlan, $durationMonths);
                    break;

                case Cart::TYPE_DOWNGRADE:
                    if (!$activeSub) {
                        throw new Exception('اشتراک فعالی برای تنزل یافت نشد.');
                    }
                    // تنزل اشتراک فعلی (کل زمان باقی‌مانده منتقل می‌شود)
                    $this->subscriptionService->downgradeSubscription($activeSub, $newPlan, $durationMonths);

                    // دریافت ظرفیت دستگاه جدید (استفاده از مقدار پیش‌فرض در صورت null بودن)
                    // عدنان، نام ستون را با ساختار دیتابیس خودت (مثلاً max_devices یا device_limit) هماهنگ کن
                    $deviceLimit = $newPlan->device_limit ?? $newPlan->max_devices ?? 0;

                    // اجرای قانون محدودیت دستگاه‌ها پس از تنزل پلن
                    $this->enforceDeviceLimitAfterDowngrade($user, (int) $deviceLimit);
                    break;

                default:
                    throw new Exception('نوع عملیات نامعتبر است.');
            }

            // ثبت اتمام موفقیت‌آمیز سبد خرید
            $cart->update([
                'status' => Cart::STATUS_COMPLETED,
                'type' => $action
            ]);

            return [
                'success' => true,
                'action' => $action,
                'message' => 'پرداخت با موفقیت انجام و تغییرات اشتراک اعمال گردید.'
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

        // ۱. پیدا کردن تمام لایسنس‌های متعلق به کاربر (یا لایسنس متصل به اشتراک فعال او)
        // معمولاً کاربر یک لایسنس فعال دارد. شناسه آن را می‌گیریم.
        $licenseIds = DB::table('licenses')
            ->where('user_id', $user->id)
            ->pluck('id');

        if ($licenseIds->isEmpty()) {
            return;
        }

        // ۲. دریافت دستگاه‌های متصل به این لایسنس‌ها، مرتب‌شده بر اساس جدیدترین‌ها
        // اولویت مرتب‌سازی با activated_at و سپس created_at است.
        $connectedDevices = DB::table('license_devices')
            ->whereIn('license_id', $licenseIds)
            ->orderByDesc('activated_at')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $connectedCount = $connectedDevices->count();

        // ۳. اگر تعداد دستگاه‌ها بیشتر از ظرفیت مجاز جدید بود، جدیدترین‌ها را حذف کن
        if ($connectedCount > $allowedDevices) {
            $excessCount = $connectedCount - $allowedDevices;

            // گرفتن ID جدیدترین دستگاه‌ها جهت حذف
            $deviceIdsToDelete = $connectedDevices->take($excessCount)->pluck('id');

            DB::table('license_devices')
                ->whereIn('id', $deviceIdsToDelete)
                ->delete();
        }
    }
}
