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
        $status = $request->query('status');

        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->with([
                'user',          // برای نمایش نام/ایمیل/شماره تلفن بدون N+1
                'items',
                'latestPayment',
            ])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
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
        // جلوگیری از دسترسی کاربر به فاکتورهای دیگران (IDOR protection)
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load([
            'user', // برای phone_number
            'items',
            'payments' => function ($query) {
                $query->latest();
            },
        ]);

        return view('user.invoices.show', compact('order'));
    }
}
