<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpirePendingOrdersCommand extends Command
{
    /**
     * نام و امضای دستور در آرتیسان
     * امکان ارسال آرگومان اختیاری برای تعیین دقیقه منقضی شدن (پیش‌فرض: ۳۰ دقیقه)
     */
    protected $signature = 'orders:expire-pending {--minutes=30 : The number of minutes after which a pending order is expired}';

    /**
     * توضیحات دستور
     */
    protected $description = 'Expire pending orders that have passed the allowed payment timeout';

    /**
     * اجرای لاجیک دستور
     */
    public function handle(): int
    {
        $minutes = (int) $this->option('minutes');
        $thresholdTime = Carbon::now()->subMinutes($minutes);

        $this->info("Checking for pending orders older than {$minutes} minutes (created before {$thresholdTime->toDateTimeString()})...");

        // پیدا کردن سفارش‌های pending قدیمی‌تر از حد مجاز
        $pendingOrders = Order::query()
            ->where('status', Order::STATUS_PENDING)
            ->where('created_at', '<=', $thresholdTime)
            ->get();

        if ($pendingOrders->isEmpty()) {
            $this->line('No expired pending orders found.');
            return Command::SUCCESS;
        }

        $count = 0;

        foreach ($pendingOrders as $order) {
            DB::transaction(function () use ($order, &$count) {
                // ۱. به‌روزرسانی وضعیت سفارش به expired
                $order->update([
                    'status' => Order::STATUS_EXPIRED,
                ]);

                // ۲. به‌روزرسانی وضعیت تراکنش‌های معلق مرتبط
                $order->payments()
                    ->whereIn('status', ['pending', 'initiated', 'waiting'])
                    ->update([
                        'status' => 'failed',
                    ]);

                $count++;
            });

            Log::info("Order #{$order->order_number} (ID: {$order->id}) was expired automatically after {$minutes} minutes.");
        }

        $this->info("Successfully expired {$count} pending order(s).");

        return Command::SUCCESS;
    }
}
