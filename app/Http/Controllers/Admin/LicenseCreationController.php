<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plan;
use App\Models\PlanPrice;
use App\Models\Subscription;

use App\Services\LicenseService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LicenseCreationController extends Controller
{
    private LicenseService $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    public function index()
    {
        $users = User::whereDoesntHave('subscriptions')
            ->where('role', '!=', 'admin')
            ->orderBy('id')
            ->get();

        return view('admin.new-licenses.index', compact('users'));
    }

    public function create(User $user)
    {
        $plans = Plan::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.new-licenses.create', compact('user', 'plans'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'duration_months' => 'required|integer'
        ]);

        DB::transaction(function () use ($request, $user) {

            $planPrice = PlanPrice::where('plan_id', $request->plan_id)
                ->where('duration_months', $request->duration_months)
                ->where('is_active', true)
                ->firstOrFail();


            // محاسبه تاریخ انقضا بر اساس duration_months
            $expiresAt = now()->addMonths((int) $planPrice->duration_months);


            $subscription = Subscription::create([
                'user_id'       => $user->id,
                'plan_id'       => $request->plan_id,
                'plan_price_id' => $planPrice->id,
                'status'        => 'active',
                'expires_at'    => $expiresAt
            ]);


            // ساخت لایسنس
            $this->licenseService->createLicense($subscription);

        });

        return redirect()
            ->route('admin.licenses.create')
            ->with('success', 'اشتراک و کد لایسنس با موفقیت ساخته شد.');
    }
}
