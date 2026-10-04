<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubscriptionDetailsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $subscription = Subscription::query()
            ->where('user_id', $user->id)
            ->with([
                'plan',
                'license.devices',
                'supports',
            ])
            ->latest('id')
            ->first();

        if (!$subscription) {
            return redirect()->route('dashboard')
                ->with('error', 'هیچ اشتراکی برای شما یافت نشد.');
        }

        $planTitle = $subscription->plan->title ?? 'نامشخص';

        // تعداد دستگاه‌های متصل فعلی
        $connectedDevicesCount = $subscription->license
            ? $subscription->license->devices->count()
            : 0;

        // حداکثر دستگاه‌های مجاز از جدول plans
        $maxAllowedDevices = $subscription->plan->max_devices ?? null;

        // دریافت فعال‌ترین دوره پشتیبانی
        $activeSupport = $subscription->supports()
            ->where('status', 'active')
            ->latest('expires_at')
            ->first() ?? $subscription->supports()->latest('id')->first();

        $supportStartsAt = $activeSupport?->starts_at ?? $subscription->created_at;
        $supportExpiresAt = $activeSupport?->expires_at;
        $supportCreatedAt = $activeSupport?->created_at ?? $supportStartsAt;

        $supportRemainingDays = null;
        if ($supportExpiresAt) {
            $supportRemainingDays = round(now()->diffInDays(Carbon::parse($supportExpiresAt), false));
        }

        $licenseKey = $subscription->license->license_key ?? 'صادر نشده';

        return view('user.subscription-details', compact(
            'subscription',
            'planTitle',
            'connectedDevicesCount',
            'maxAllowedDevices',
            'activeSupport',
            'supportStartsAt',
            'supportExpiresAt',
            'supportCreatedAt',
            'supportRemainingDays',
            'licenseKey'
        ));
    }
}
