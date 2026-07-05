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
                'planPrice',
                'license.devices',
            ])
            ->latest('id')
            ->first();

        if (!$subscription) {
            return redirect()->route('dashboard')
                ->with('error', 'هیچ اشتراکی برای شما یافت نشد.');
        }

        $planTitle = $subscription->plan->title ?? 'نامشخص';

        // مقداردهی مدت زمان پلن
        $planPeriodMonths = $subscription->planPrice->duration_months ?? null;

        // تعداد دستگاه‌های متصل فعلی
        $connectedDevicesCount = $subscription->license
            ? $subscription->license->devices->count()
            : 0;

        // حداکثر دستگاه‌های مجاز از جدول plans
        $maxAllowedDevices = $subscription->plan->max_devices ?? null;

        $subscriptionDurationDays = null;
        if ($subscription->started_at && $subscription->expires_at) {
            $subscriptionDurationDays = round(Carbon::parse($subscription->started_at)
                ->diffInDays(Carbon::parse($subscription->expires_at)));
        }

        $remainingDays = null;
        if ($subscription->expires_at) {
            // استفاده از round برای حذف کامل بخش اعشاری تفاضل روزها
            $remainingDays = round(now()->diffInDays(Carbon::parse($subscription->expires_at), false));
        }

        $licenseKey = $subscription->license->license_key ?? 'صادر نشده';
        $price = $subscription->planPrice->price ?? 0;

        return view('user.subscription-details', compact(
            'subscription',
            'planTitle',
            'planPeriodMonths',
            'connectedDevicesCount',
            'maxAllowedDevices',
            'subscriptionDurationDays',
            'remainingDays',
            'licenseKey',
            'price'
        ));
    }
}
