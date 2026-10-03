<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use App\Models\SubscriptionSupport; 

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */
        $totalUsers = User::count();

        $newUsersLast7Days = User::where(
            'created_at',
            '>=',
            now()->subDays(7)
        )->count();

        $latestUsers = User::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Subscriptions (Lifetime Licenses)
        |--------------------------------------------------------------------------
        */
        $totalSubscriptions = Subscription::count();

        $activeSubscriptions = Subscription::where('status', 'active')->count();

        $newSubscriptionsLast7Days = Subscription::where(
            'created_at',
            '>=',
            now()->subDays(7)
        )->count();

        $latestSubscriptions = Subscription::with('user')
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Support Packages
        |--------------------------------------------------------------------------
        */
        $totalSupports = SubscriptionSupport::count();

        $activeSupports = SubscriptionSupport::where('status', 'active')
            ->where('expires_at', '>', now())
            ->count();

        $expiredSupports = SubscriptionSupport::where(function ($query) {
            $query->where('status', 'expired')
                ->orWhere('expires_at', '<=', now());
        })->count();

        $expiringSoonSupports = SubscriptionSupport::where('status', 'active')
            ->whereBetween('expires_at', [
                now(),
                now()->addDays(7)
            ])->count();

        $newSupportsLast7Days = SubscriptionSupport::where(
            'created_at',
            '>=',
            now()->subDays(7)
        )->count();

        $latestSupports = SubscriptionSupport::with('user')
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Conversion Rates
        |--------------------------------------------------------------------------
        */
        // نرخ تبدیل کاربر به خریدار اشتراک (لایسنس)
        $conversionRate = $totalUsers > 0
            ? round(($activeSubscriptions / $totalUsers) * 100, 2)
            : 0;

        // تعداد یکتای لایسنس‌هایی که پشتیبانی فعال دارند
        $subscriptionsWithActiveSupportCount = SubscriptionSupport::where('status', 'active')
            ->where('expires_at', '>', now())
            ->distinct('subscription_id')
            ->count('subscription_id');

        // نرخ تبدیل اشتراک‌ها به پشتیبانی فعال
        $supportConversionRate = $totalSubscriptions > 0
            ? round(($subscriptionsWithActiveSupportCount / $totalSubscriptions) * 100, 2)
            : 0;

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'newUsersLast7Days',
                'latestUsers',

                'totalSubscriptions',
                'activeSubscriptions',
                'newSubscriptionsLast7Days',
                'latestSubscriptions',

                'totalSupports',
                'activeSupports',
                'expiredSupports',
                'expiringSoonSupports',
                'newSupportsLast7Days',
                'latestSupports',

                'conversionRate',
                'supportConversionRate'
            )
        );
    }
}
