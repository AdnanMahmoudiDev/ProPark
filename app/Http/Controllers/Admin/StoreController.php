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
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|between:0,100',
            'original_price'   => 'nullable|numeric|min:0',
            'max_devices'      => 'nullable|integer|min:1',
            'is_active'        => 'required|boolean',
        ]);

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
                    'price'            => 'required|numeric|min:0',
                    'discount_percent' => 'nullable|numeric|between:0,100',
                    'original_price'   => 'nullable|numeric|min:0',
                    'max_devices'      => 'nullable|integer|min:1',
                    'is_active'        => 'required|boolean',
                    'sort_order'       => 'nullable|integer',
                ])->validate();

                Plan::where('id', $id)->update($validated);
            }
        });

        return redirect()->back()->with('success', 'تمامی تغییرات پلن‌ها با موفقیت اعمال شد.');
    }
}
