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
            ->with(['prices' => function($query) {
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
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'required|numeric|between:0,100',
            'is_active'        => 'required|boolean',
        ]);

        // ذخیره در دیتابیس
        $price->update($validated);

        return redirect()->back()->with('success', 'قیمت و وضعیت با موفقیت بروزرسانی شد.');
    }
    
    public function bulkUpdate(Request $request)
{
    $request->validate([
        'prices' => 'required|array'
    ]);

    DB::transaction(function () use ($request) {

        foreach ($request->prices as $id => $data) {

            $validated = validator($data, [
                'price'            => 'required|numeric|min:0',
                'discount_percent' => 'required|numeric|between:0,100',
                'is_active'        => 'required|boolean',
            ])->validate();

            PlanPrice::where('id', $id)->update($validated);
        }
    });

    return redirect()->back()->with('success', 'تمامی تغییرات با موفقیت اعمال شد.');
}

}
