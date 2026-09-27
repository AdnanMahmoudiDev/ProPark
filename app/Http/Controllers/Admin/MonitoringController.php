<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        $startTime = microtime(true);

        // 1. مصرف رم سرور
        $ram = [
            'total' => null,
            'used'  => null,
            'free'  => null,
            'percentage' => 0,
        ];

        if (PHP_OS_FAMILY === 'Linux' && is_readable('/proc/meminfo')) {
            $meminfo = file_get_contents('/proc/meminfo');
            preg_match('/MemTotal:\s+(\d+)\s+kB/', $meminfo, $totalMatch);
            preg_match('/MemAvailable:\s+(\d+)\s+kB/', $meminfo, $availableMatch);

            if (isset($totalMatch[1], $availableMatch[1])) {
                $totalKb = (int)$totalMatch[1];
                $availableKb = (int)$availableMatch[1];
                $usedKb = $totalKb - $availableKb;

                $ram['total'] = round($totalKb / 1024 / 1024, 2); 
                $ram['free']  = round($availableKb / 1024 / 1024, 2);
                $ram['used']  = round($usedKb / 1024 / 1024, 2);
                $ram['percentage'] = round(($usedKb / $totalKb) * 100, 1);
            }
        } else {
            $usedMb = memory_get_usage(true) / 1024 / 1024;
            $ram['total'] = 8.0; 
            $ram['used'] = round($usedMb / 1024, 2);
            $ram['free'] = round($ram['total'] - $ram['used'], 2);
            $ram['percentage'] = round(($ram['used'] / $ram['total']) * 100, 1);
        }

        // 2. فضای دیسک سرور
        $diskPath = base_path();
        $diskFree = @disk_free_space($diskPath);
        $diskTotal = @disk_total_space($diskPath);
        $disk = [
            'free' => $diskFree ? round($diskFree / (1024 ** 3), 2) : 0,
            'total' => $diskTotal ? round($diskTotal / (1024 ** 3), 2) : 0,
            'used' => ($diskTotal && $diskFree) ? round(($diskTotal - $diskFree) / (1024 ** 3), 2) : 0,
            'percentage' => ($diskTotal && $diskFree) ? round((($diskTotal - $diskFree) / $diskTotal) * 100, 1) : 0,
        ];

        // 3. سلامت دیتابیس
        $dbStatus = 'ok';
        $dbLatency = 0;
        try {
            $dbStart = microtime(true);
            DB::connection()->getPdo();
            DB::select('SELECT 1');
            $dbLatency = round((microtime(true) - $dbStart) * 1000, 2);
        } catch (\Throwable $e) {
            $dbStatus = 'error';
        }

        // 4. زمان پاسخگویی سرور
        $responseTime = round((microtime(true) - $startTime) * 1000, 2);

        // 5. دریافت آمار کلی بازدیدها و کاربران یکتا
        $totalVisits = DB::table('page_visits')->count();
        $uniqueVisitors = DB::table('page_visits')->distinct('ip_address')->count('ip_address');

        // 6. دریافت آمار تفکیکی ۶ ماه اخیر از دیتابیس
        $monthlyVisits = $this->getMonthlyVisitsData();

        return view('admin.monitoring.index', compact(
            'ram',
            'disk',
            'dbStatus',
            'dbLatency',
            'responseTime',
            'totalVisits',
            'uniqueVisitors',
            'monthlyVisits'
        ));
    }

    /**
     * محاسبه آمار بازدیدهای ۶ ماه اخیر از دیتابیس (تفکیک Page Views و Unique Visitors)
     */
    protected function getMonthlyVisitsData(): array
    {
        $persianMonths = [
            1 => 'فروردین', 2 => 'اردیبهشت', 3 => 'خرداد',
            4 => 'تیر', 5 => 'مرداد', 6 => 'شهریور',
            7 => 'مهر', 8 => 'آبان', 9 => 'آذر',
            10 => 'دی', 11 => 'بهمن', 12 => 'اسفند'
        ];

        $labels = [];
        $views = [];
        $uniques = [];

        for ($i = 5; $i >= 0; $i--) {
            $targetDate = now()->subMonths($i);
            $startOfMonth = $targetDate->copy()->startOfMonth()->toDateString();
            $endOfMonth = $targetDate->copy()->endOfMonth()->toDateString();

            // کل صفحات بازدیدشده در ماه
            $viewCount = DB::table('page_visits')
                ->whereBetween('visited_date', [$startOfMonth, $endOfMonth])
                ->count();

            // بازدیدکنندگان منحصر‌به‌فرد بر اساس IP در ماه
            $uniqueCount = DB::table('page_visits')
                ->whereBetween('visited_date', [$startOfMonth, $endOfMonth])
                ->distinct('ip_address')
                ->count('ip_address');

            // نگاشت ماه میلادی به شمسی
            $m = (int)$targetDate->format('n');
            $monthIndex = ($m >= 4) ? ($m - 3) : ($m + 9);
            
            $labels[] = $persianMonths[$monthIndex] ?? $targetDate->format('M');
            $views[] = $viewCount;
            $uniques[] = $uniqueCount;
        }

        return [
            'labels'  => $labels,
            'views'   => $views,
            'uniques' => $uniques,
            'data'    => $views, // حفظ سازگاری با کدهای قبلی
        ];
    }
}
