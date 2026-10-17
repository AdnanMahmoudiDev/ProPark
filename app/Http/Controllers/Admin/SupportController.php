<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionSupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class SupportController extends Controller
{
    /**
     * نمایش لیست سوابق و وضعیت پشتیبانی‌ها با قابلیت سرچ و صفحه‌بندی
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $supportsQuery = SubscriptionSupport::with([
            'user',
            'subscription.plan',
            'subscription.license'
        ])->latest('id');

        if ($search !== '') {
            $supportsQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%");
                })
                ->orWhereHas('subscription.license', function ($q) use ($search) {
                    $q->where('license_key', 'like', "%{$search}%");
                })
                ->orWhere('id', $search);
            });
        }

        /** @var LengthAwarePaginator $supports */
        $supports = $supportsQuery->paginate(15);
        $supports->withQueryString();

        return view('admin.supports.index', compact('supports'));
    }

    /**
     * تغییر وضعیت پشتیبانی
     */
    public function updateStatus(Request $request, SubscriptionSupport $support): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:' . SubscriptionSupport::STATUS_ACTIVE . ',' . SubscriptionSupport::STATUS_EXPIRED . ',' . SubscriptionSupport::STATUS_CANCELLED
            ],
        ]);

        $support->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', __('وضعیت پشتیبانی با موفقیت به‌روزرسانی شد.'));
    }

    /**
     * تمدید مستقیم مدت پشتیبانی بر اساس ماه با استفاده از متد درون مدل
     */
    public function renew(Request $request, SubscriptionSupport $support): RedirectResponse
    {
        $validated = $request->validate([
            'months' => ['required', 'integer', 'min:1', 'max:120'],
        ]);

        $months = (int) $validated['months'];

        // استفاده مستقیم از متد extend تعریف شده در مدل SubscriptionSupport
        $support->extend($months);

        return back()->with('success', __('پشتیبانی با موفقیت به مدت :months ماه تمدید شد.', ['months' => $months]));
    }

    /**
     * حذف رکورد پشتیبانی
     */
    public function destroy(SubscriptionSupport $support): RedirectResponse
    {
        $support->delete();

        return back()->with('success', __('سند پشتیبانی مورد نظر با موفقیت حذف شد.'));
    }
}
