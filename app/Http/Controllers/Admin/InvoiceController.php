<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InvoiceController extends Controller
{
    /**
     * نمایش لیست فاکتورها به همراه فیلترها و آمار سریع
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // فیلتر جستجو بر اساس شماره سفارش یا مشخصات خریدار
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('id', $search)
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone_number', 'like', "%{$search}%");
                  });
            });
        }

        // فیلتر وضعیت فاکتور
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // استفاده از appends برای جلوگیری از خطای P1013 اینتلی‌سنس VSCode
        $invoices = $query->paginate(15)->appends($request->query());

        // شمارنده‌ها و خلاصه درآمد کل
        $totalRevenue  = Order::where('status', 'paid')->sum('payable_amount');
        $paidCount     = Order::where('status', 'paid')->count();
        $pendingCount  = Order::where('status', 'pending')->count();
        $expiredCount  = Order::where('status', 'expired')->count();
        $failedCount   = Order::where('status', 'failed')->count();
        $canceledCount = Order::where('status', 'canceled')->count();
        $totalCount    = Order::count();

        return view('admin.invoices.index', compact(
            'invoices',
            'totalRevenue',
            'paidCount',
            'pendingCount',
            'expiredCount',
            'failedCount',
            'canceledCount',
            'totalCount'
        ));
    }

    /**
     * صفحه اختصاصی تحلیلی و گزارش حساب‌کتاب مالی
     */
    public function analytics()
    {
        $now = Carbon::now();

        // ۱. محاسبات درآمد در بازه‌های زمانی مختلف (فقط فاکتورهای پرداخت‌شده)
        $paidOrdersQuery = Order::where('status', 'paid');

        $totalRevenue   = (clone $paidOrdersQuery)->sum('payable_amount');
        $totalPaidCount = (clone $paidOrdersQuery)->count();

        // ۱۲ ماه اخیر (سال اخیر)
        $yearRevenue = (clone $paidOrdersQuery)
            ->where('created_at', '>=', $now->copy()->subYear())
            ->sum('payable_amount');

        // ۶ ماه اخیر
        $sixMonthsRevenue = (clone $paidOrdersQuery)
            ->where('created_at', '>=', $now->copy()->subMonths(6))
            ->sum('payable_amount');

        // ماه جاری (۳۰ روز اخیر)
        $monthRevenue = (clone $paidOrdersQuery)
            ->where('created_at', '>=', $now->copy()->subDays(30))
            ->sum('payable_amount');

        // میانگین ارزش هر فاکتور وصول‌شده (AOV)
        $averageOrderValue = $totalPaidCount > 0 ? round($totalRevenue / $totalPaidCount) : 0;

        // ۲. آماده‌سازی روند ماهانه ۱۲ ماه گذشته (یک سال کامل) برای نمودار
        $chartLabels = [];
        $chartData   = [];

        for ($i = 11; $i >= 0; $i--) {
            $startOfMonth = $now->copy()->subMonths($i)->startOfMonth();
            $endOfMonth   = $now->copy()->subMonths($i)->endOfMonth();

            $label = function_exists('jdate') 
                ? jdate($startOfMonth)->format('%B %Y') 
                : $startOfMonth->format('M Y');

            $amount = Order::where('status', 'paid')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('payable_amount');

            $chartLabels[] = $label;
            $chartData[]   = (int) $amount;
        }

        // ۳. بررسی هوشمند و ایمن ستون قیمت جدول order_items جهت جلوگیری از خطای Unknown column
        $itemPriceColumn = 'price';
        if (Schema::hasColumn('order_items', 'unit_price')) {
            $itemPriceColumn = 'unit_price';
        } elseif (Schema::hasColumn('order_items', 'total_price')) {
            $itemPriceColumn = 'total_price';
        } elseif (Schema::hasColumn('order_items', 'amount')) {
            $itemPriceColumn = 'amount';
        }

        $packageBreakdown = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->select(
                'order_items.title',
                DB::raw('COUNT(order_items.id) as total_sold'),
                DB::raw("SUM(order_items.{$itemPriceColumn}) as total_amount")
            )
            ->groupBy('order_items.title')
            ->orderByDesc('total_amount')
            ->take(5)
            ->get();

        // ۴. آخرین فاکتورهای وصول‌شده
        $recentPaidInvoices = Order::with('user')
            ->where('status', 'paid')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.invoices.analytics', compact(
            'totalRevenue',
            'yearRevenue',
            'sixMonthsRevenue',
            'monthRevenue',
            'totalPaidCount',
            'averageOrderValue',
            'chartLabels',
            'chartData',
            'packageBreakdown',
            'recentPaidInvoices'
        ));
    }

    /**
     * نمایش جزییات فاکتور جهت مشاهده و چاپ رسمی
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items', 'payments']);
        $invoice = $order;

        return view('admin.invoices.show', compact('order', 'invoice'));
    }
}
