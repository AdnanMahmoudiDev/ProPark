<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /**
     * نمایش لیست پلن‌های فروشگاه
     */
    public function index()
    {
        $plans = Plan::query()
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.store.index', compact('plans'));
    }

    /**
     * بروزرسانی قیمت و مشخصات یک پلن خاص
     */
    public function updatePrice(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'original_price'   => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|between:0,100',
            'max_devices'      => 'nullable|integer|min:1',
            'is_active'        => 'required|boolean',
            'sort_order'       => 'nullable|integer',
        ]);

        $originalPrice = (float) $validated['original_price'];
        $discountPercent = (float) ($validated['discount_percent'] ?? 0);

        // محاسبه قیمت نهایی فروش بر اساس قیمت اصلی و درصد تخفیف
        $finalPrice = $discountPercent > 0
            ? round($originalPrice * (1 - ($discountPercent / 100)))
            : $originalPrice;

        $validated['price'] = $finalPrice;

        $plan->update($validated);

        return redirect()->back()->with('success', 'قیمت و وضعیت پلن با موفقیت بروزرسانی شد.');
    }

    /**
     * بروزرسانی گروهی قیمت‌ها و وضعیت پلن‌ها
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'plans' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->plans as $id => $data) {
                $validated = validator($data, [
                    'original_price'   => 'required|numeric|min:0',
                    'discount_percent' => 'nullable|numeric|between:0,100',
                    'max_devices'      => 'nullable|integer|min:1',
                    'is_active'        => 'required|boolean',
                    'sort_order'       => 'nullable|integer',
                ])->validate();

                $originalPrice = (float) $validated['original_price'];
                $discountPercent = (float) ($validated['discount_percent'] ?? 0);

                // محاسبه خودکار قیمت فروش سیستمی
                $finalPrice = $discountPercent > 0
                    ? round($originalPrice * (1 - ($discountPercent / 100)))
                    : $originalPrice;

                $validated['price'] = $finalPrice;

                Plan::where('id', $id)->update($validated);
            }
        });

        return redirect()->back()->with('success', 'تمامی تغییرات پلن‌ها با موفقیت اعمال شد.');
    }
}
