<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * نمایش لیست فاکتورهای کاربر
     */
    public function index(Request $request): View
    {
        // status از QueryString: /user/invoices?status=cancelled
        $status = $request->query('status');

        // فقط وضعیت‌های مجاز را قبول می‌کنیم
        $allowedStatuses = [
            Order::STATUS_PENDING,
            Order::STATUS_PAID,
            Order::STATUS_CANCELLED,
            Order::STATUS_FAILED,
        ];

        // اگر status نامعتبر بود، فیلتر را حذف می‌کنیم
        if (!is_null($status) && !in_array($status, $allowedStatuses, true)) {
            $status = null;
        }

        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->with([
                'user',
                'items',
                'latestPayment',
            ])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('user.invoices.index', compact('orders', 'status'));
    }

    /**
     * نمایش جزئیات یک فاکتور خاص
     */
    public function show(Order $order): View
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load([
            'user',
            'items',
            'payments' => fn ($query) => $query->latest(),
        ]);

        return view('user.invoices.show', compact('order'));
    }
}
