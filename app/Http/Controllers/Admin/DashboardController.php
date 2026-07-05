<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\License;
use App\Models\Subscription;

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
        | Subscriptions
        |--------------------------------------------------------------------------
        */

        $totalSubscriptions = Subscription::count();

        $activeSubscriptions = Subscription::where('status', 'active')
            ->where('expires_at', '>', now())
            ->count();

        $expiredSubscriptions = Subscription::where(
            'expires_at',
            '<',
            now()
        )->count();

        $newSubscriptionsLast7Days = Subscription::where(
            'created_at',
            '>=',
            now()->subDays(7)
        )->count();

        $expiringSoonSubscriptions = Subscription::whereBetween(
            'expires_at',
            [
                now(),
                now()->addDays(7)
            ]
        )->count();

        $latestSubscriptions = Subscription::with('user')
            ->latest()
            ->take(5)
            ->get();





        /*
        |--------------------------------------------------------------------------
        | Conversion Rate
        |--------------------------------------------------------------------------
        */

        $conversionRate = $totalUsers > 0
            ? round(($activeSubscriptions / $totalUsers) * 100, 2)
            : 0;


        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'newUsersLast7Days',
                'latestUsers',

                'totalSubscriptions',
                'activeSubscriptions',
                'expiredSubscriptions',
                'newSubscriptionsLast7Days',
                'expiringSoonSubscriptions',
                'latestSubscriptions',


                'conversionRate'
            )
        );
    }

}
