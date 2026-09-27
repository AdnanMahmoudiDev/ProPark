<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {
        $plans = Plan::query()
            ->with(['prices' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            }])
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.store.index', compact('plans'));
    }

    public function updatePrice(Request $request, PlanPrice $price)
    {
        // دریافت و اعتبارسنجی مقادیر
        $validated = $request->validate([
            'duration_months'   => 'required|integer|min:1|max:600', // تا 50 سال
            'price'             => 'required|numeric|min:0',
            'discount_percent'  => 'required|numeric|between:0,100',
            'is_active'         => 'required|boolean',
        ]);

        // جلوگیری از تکراری شدن duration_months در همان پلن
        $duplicateExists = PlanPrice::query()
            ->where('plan_id', $price->plan_id)
            ->where('duration_months', $validated['duration_months'])
            ->where('id', '!=', $price->id)
            ->exists();

        if ($duplicateExists) {
            return redirect()->back()->withErrors([
                'duration_months' => 'برای این پلن، بازه زمانی ' . $validated['duration_months'] . ' ماهه از قبل وجود دارد.',
            ])->withInput();
        }

        // ذخیره در دیتابیس
        $price->update($validated);

        return redirect()->back()->with('success', 'بازه زمانی، قیمت و وضعیت با موفقیت بروزرسانی شد.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'prices' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            // برای جلوگیری از مدت‌های تکراری داخل یک پلن در همین درخواست
            // ساختار: [plan_id => [duration1, duration2, ...]]
            $durationsByPlan = [];

            foreach ($request->prices as $id => $data) {

                $validated = validator($data, [
                    'duration_months'  => 'required|integer|min:1|max:600',
                    'price'            => 'required|numeric|min:0',
                    'discount_percent' => 'required|numeric|between:0,100',
                    'is_active'        => 'required|boolean',
                ])->validate();

                $planPrice = PlanPrice::query()->select(['id', 'plan_id'])->findOrFail($id);
                $planId = (int) $planPrice->plan_id;
                $duration = (int) $validated['duration_months'];

                // چک تکراری بودن در خود فرم (درون همین submit)
                $durationsByPlan[$planId] ??= [];
                if (in_array($duration, $durationsByPlan[$planId], true)) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], []),
                        response()->json([
                            'message' => "برای پلن #{$planId} در همین ثبت گروهی، مدت {$duration} ماهه دوبار ارسال شده است.",
                        ], 422)
                    );
                }
                $durationsByPlan[$planId][] = $duration;

                // چک تکراری بودن در دیتابیس (به جز همین ردیف)
                $duplicateExists = PlanPrice::query()
                    ->where('plan_id', $planId)
                    ->where('duration_months', $duration)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($duplicateExists) {
                    // اگر تکراری باشد، کل transaction rollback می‌شود
                    throw new \RuntimeException("برای پلن #{$planId} بازه {$duration} ماهه از قبل وجود دارد. لطفاً مدت‌ها را یکتا کنید.");
                }

                PlanPrice::where('id', $id)->update($validated);
            }
        });

        return redirect()->back()->with('success', 'تمامی تغییرات (شامل بازه زمانی) با موفقیت اعمال شد.');
    }
}
