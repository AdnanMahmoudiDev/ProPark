<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionSupport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));

        $subscriptions = Subscription::query()
            ->with([
                'user',
                'plan',
                'license',
                'activeSupport',  // فقط پشتیبانی فعال
                'latestSupport',  // آخرین پشتیبانی (حتی منقضی) جهت استخراج دقیق وضعیت و تاریخ
            ])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->appends(['search' => $search]); // جایگزین ایمن و بدون خطای withQueryString

        $plans = Plan::all();

        return view('admin.subscriptions.index', compact('subscriptions', 'plans', 'search'));
    }

    public function updateStatus(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,expired,cancelled,suspended'],
        ]);

        $subscription->update([
            'status' => $data['status'],
        ]);

        return back()->with('success', 'وضعیت اشتراک بروزرسانی شد.');
    }

    /**
     * تغییر پلن اشتراک توسط ادمین
     */
    public function updatePlan(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $subscription->update([
            'plan_id' => $validated['plan_id'],
        ]);

        return back()->with('success', 'پلن اشتراک با موفقیت تغییر کرد.');
    }

    /**
     * تمدید پشتیبانی اشتراک مادام‌العمر بدون ایجاد رکورد تکراری
     */
    public function renew(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'months' => ['required', 'integer', 'min:1', 'max:120'],
        ]);

        $months = (int) $validated['months'];

        DB::transaction(function () use ($subscription, $months) {
            $support = $subscription->latestSupport;

            if ($support) {
                // اگر پشتیبانی فعال باشد ماه‌ها به انتهای انقضا اضافه می‌شود، در غیر این صورت از تاریخ جاری
                $baseDate = ($support->expires_at && Carbon::parse($support->expires_at)->isFuture())
                    ? Carbon::parse($support->expires_at)
                    : now();

                $support->update([
                    'expires_at' => $baseDate->copy()->addMonths($months),
                    'status'     => SubscriptionSupport::STATUS_ACTIVE,
                ]);
            } else {
                // ایجاد اولین رکورد پشتیبانی در صورت نبود رکورد قبلی
                $subscription->supports()->create([
                    'starts_at'  => now(),
                    'expires_at' => now()->addMonths($months),
                    'status'     => SubscriptionSupport::STATUS_ACTIVE,
                ]);
            }

            // تضمین فعال بودن اشتراک و لایسنس
            $subscription->update([
                'status' => 'active',
            ]);

            if ($subscription->license) {
                $subscription->license->update([
                    'is_active' => true,
                ]);
            }
        });

        return back()->with('success', "پشتیبانی اشتراک با موفقیت به مدت {$months} ماه تمدید شد.");
    }

    public function destroy(Subscription $subscription)
    {
        DB::transaction(function () use ($subscription) {
            if ($subscription->license) {
                $subscription->license->devices()->delete();
                $subscription->license->delete();
            }

            $subscription->supports()->delete();
            $subscription->delete();
        });

        return back()->with('success', 'اشتراک، لایسنس مرتبط و دستگاه‌های متصل با موفقیت حذف شدند.');
    }
}
