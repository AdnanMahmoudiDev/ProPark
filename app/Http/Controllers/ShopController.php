<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\SupportPackage;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * نمایش صفحه فروشگاه لایسنس‌ها و پشتیبانی
     */
    public function index()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // دریافت تمام پلن‌های فعال بر اساس سطح و ترتیب نمایش
        $allPlans = Plan::query()
            ->where('is_active', true)
            ->orderBy('level', 'asc')
            ->orderBy('sort_order', 'asc')
            ->get();

        // دریافت بسته‌های پشتیبانی فعال از دیتابیس
        $supportPackages = SupportPackage::query()
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('duration_months', 'asc')
            ->get();

        $hasSubscription = false;
        $currentPlan = null;
        $currentPlanLevel = 0;

        if ($user) {
            // دریافت آخرین اشتراک کاربر به همراه اطلاعات پلن
            $subscription = $user->subscriptions()
                ->with('plan')
                ->latest('id')
                ->first();

            if ($subscription && $subscription->plan) {
                $hasSubscription = true;
                $currentPlan = $subscription->plan;
                $currentPlanLevel = (int) ($currentPlan->level ?? 0);
            }
        }

        // بالاترین سطح موجود در سیستم
        $maxLevel = (int) ($allPlans->max('level') ?? 0);

        // آیا کاربر هم‌اکنون بالاترین سطح پلن را دارد؟
        $isTopPlan = $hasSubscription && ($currentPlanLevel >= $maxLevel);

        // پلن‌های قابل نمایش برای ارتقا (سطح بیشتر از پلن فعلی)
        $upgradePlans = $allPlans->filter(function ($plan) use ($currentPlanLevel) {
            return (int) ($plan->level ?? 0) > $currentPlanLevel;
        })->values();

        // پلن‌های عمومی برای کاربری که هیچ اشتراکی ندارد
        $plans = $allPlans;

        return view('shop.index', compact(
            'plans',
            'supportPackages',
            'upgradePlans',
            'hasSubscription',
            'currentPlan',
            'currentPlanLevel',
            'isTopPlan'
        ));
    }
}
