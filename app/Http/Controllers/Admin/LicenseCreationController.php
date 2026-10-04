<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionSupport;
use App\Models\User;
use App\Services\LicenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LicenseCreationController extends Controller
{
    public function __construct(
        private readonly LicenseService $licenseService
    ) {}

    /**
     * لیست کاربران بدون اشتراک/لایسنس (در صورت نیاز شما)
     */
    public function index(): View
    {
        $users = User::query()
            ->whereDoesntHave('subscriptions')
            ->where('role', '!=', 'admin')
            ->orderBy('id')
            ->get();

        return view('admin.new-licenses.index', compact('users'));
    }

    /**
     * فرم صدور لایسنس برای یک کاربر
     */
    public function create(User $user): View
    {
        $plans = Plan::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.new-licenses.create', compact('user', 'plans'));
    }

    /**
     * ساخت اشتراک lifetime + ساخت رکورد پشتیبانی + ساخت لایسنس
     */
    public function store(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'plan_id'        => ['required', 'exists:plans,id'],
            'support_months' => ['required', 'integer', 'in:6,12'],
        ]);

        $supportMonths = (int) $validated['support_months'];

        DB::transaction(function () use ($validated, $supportMonths, $user) {

            // 1) ایجاد اشتراک مادام‌العمر
            $subscription = Subscription::create([
                'user_id'    => $user->id,
                'plan_id'    => (int) $validated['plan_id'],
                'status'     => Subscription::STATUS_ACTIVE,
                'started_at' => now(),
            ]);

            // 2) ایجاد رکورد پشتیبانی (طبق ساختار شما در subscription_supports)
            $subscription->supports()->create([
                'status'     => SubscriptionSupport::STATUS_ACTIVE,
                'starts_at'  => now(),
                'expires_at' => now()->addMonths($supportMonths),
            ]);

            // 3) ساخت لایسنس
            $this->licenseService->createLicense($subscription);
        });

        return redirect()
            ->route('admin.licenses.create')
            ->with('success', 'لایسنس مادام‌العمر و دوره پشتیبانی با موفقیت برای کاربر ثبت شد.');
    }
}
