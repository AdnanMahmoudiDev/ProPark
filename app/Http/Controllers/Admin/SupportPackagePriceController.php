<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportPackagePriceController extends Controller
{
    /**
     * نمایش صفحه مدیریت قیمت بسته‌های پشتیبانی
     */
    public function index()
    {
        $packages = SupportPackage::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.support-packages.prices', compact('packages'));
    }

    /**
     * به‌روزرسانی گروهی قیمت‌ها و تخفیف‌های بسته‌های پشتیبانی
     */
    public function bulkUpdate(Request $request)
    {
        // ۱. پاک‌سازی کاراکترهای جداکننده (کاما و فاصله‌ها) از فیلد قیمت قبل از ولیدیشن
        $rawPackages = $request->input('packages', []);

        if (is_array($rawPackages)) {
            foreach ($rawPackages as $id => $data) {
                if (isset($data['price'])) {
                    // حذف هرگونه کاما انگلیسی/فارسی، خط تیره یا فاصله
                    $cleanPrice = preg_replace('/[^\d]/u', '', (string) $data['price']);
                    $rawPackages[$id]['price'] = $cleanPrice !== '' ? (int) $cleanPrice : 0;
                }

                if (isset($data['discount_percent'])) {
                    $cleanDiscount = preg_replace('/[^\d]/u', '', (string) $data['discount_percent']);
                    $rawPackages[$id]['discount_percent'] = $cleanDiscount !== '' ? (int) $cleanDiscount : 0;
                }
            }

            $request->merge(['packages' => $rawPackages]);
        }

        // ۲. اعتبارسنجی داده‌های تمیز شده
        $validated = $request->validate([
            'packages' => ['required', 'array'],
            'packages.*.price' => ['required', 'numeric', 'min:0'],
            'packages.*.discount_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'packages.*.duration_months' => ['required', 'integer', 'min:1'],
            'packages.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'packages.*.is_active' => ['required', 'in:0,1'],
        ]);

        // ۳. ذخیره‌سازی داده‌ها در دیتابیس
        DB::transaction(function () use ($validated) {
            foreach ($validated['packages'] as $id => $data) {
                $package = SupportPackage::find($id);

                if (! $package) {
                    continue;
                }

                $originalPrice = (int) $data['price'];
                $discountPercent = (int) ($data['discount_percent'] ?? 0);

                // محاسبه قیمت نهایی بعد از تخفیف
                if ($discountPercent > 0) {
                    $finalPrice = (int) round($originalPrice * (1 - ($discountPercent / 100)));
                } else {
                    $finalPrice = $originalPrice;
                }

                $package->update([
                    'original_price'   => $originalPrice,
                    'price'            => $finalPrice,
                    'discount_percent' => $discountPercent,
                    'duration_months'  => (int) $data['duration_months'],
                    'sort_order'       => (int) ($data['sort_order'] ?? 0),
                    'is_active'        => (bool) $data['is_active'],
                ]);
            }
        });

        return redirect()
            ->route('admin.store.support-prices.index')
            ->with('success', __('تغییرات بسته‌های پشتیبانی با موفقیت ذخیره شد.'));
    }
}
