<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::query()
            ->with(['user', 'plan', 'planPrice', 'license'])
            ->latest()
            ->paginate(20);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function updateStatus(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,expired,cancelled,suspended']
        ]);

        $subscription->update([
            'status' => $data['status']
        ]);

        return back()->with('success', 'وضعیت اشتراک بروزرسانی شد');
    }

    public function renew(Request $request, Subscription $subscription)
    {
        $request->validate([
            'months' => ['required', 'integer', 'min:1', 'max:120']
        ]);

        $months = (int) $request->months;

        if ($subscription->expires_at && $subscription->expires_at->isFuture()) {
            $newExpire = $subscription->expires_at->copy()->addMonths($months);
        } else {
            $newExpire = now()->addMonths($months);
        }

        $subscription->update([
            'expires_at' => $newExpire,
            'status' => 'active',
        ]);

        if ($subscription->license) {
            $subscription->license->update([
                'is_active' => true
            ]);
        }

        return back()->with('success', "اشتراک برای مدت  {$months} ماه تمدید شد.");
    }

    public function destroy(Subscription $subscription)
    {
        DB::transaction(function () use ($subscription) {

            // اگر لایسنس وجود دارد
            if ($subscription->license) {

                // حذف دستگاه‌های متصل به لایسنس
                $subscription->license->devices()->delete();

                // حذف لایسنس
                $subscription->license->delete();
            }

            // حذف اشتراک
            $subscription->delete();
        });

        return back()->with('success', 'اشتراک و همچنین لایسنس مرتبط و دستگاه های متصل به آن با موفقت حذف شدند');
    }
}
