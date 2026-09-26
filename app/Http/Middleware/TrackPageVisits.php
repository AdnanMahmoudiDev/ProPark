<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisits
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // فقط متدهای GET و رکوئست‌های معمولی صفحات وب ثبت شوند
        if ($request->isMethod('GET') && !$request->ajax() && !$request->wantsJson()) {
            $this->logVisit($request);
        }

        return $response;
    }

    protected function logVisit(Request $request): void
    {
        // مسیرهایی که نباید شمرده شوند
        if ($request->is('admin*') || $request->is('api*') || $request->is('up')) {
            return;
        }

        $ip = $request->ip();
        $path = $request->path();
        $cacheKey = 'visit_' . md5($ip . '_' . $path);

        // اگر در ۱۵ دقیقه اخیر از این مسیر و IP بازدید نشده بود
        if (!Cache::has($cacheKey)) {
            try {
                DB::table('page_visits')->insert([
                    'ip_address'   => $ip,
                    'url'          => substr($request->fullUrl(), 0, 500),
                    'method'       => $request->method(),
                    'user_agent'   => substr($request->userAgent() ?? '', 0, 500),
                    'user_id'      => Auth::id(),
                    'visited_date' => now()->toDateString(),
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);

                // فقط پس از درج موفق در دیتابیس، کش فعال شود
                Cache::put($cacheKey, true, now()->addMinutes(15));
            } catch (\Throwable $e) {
                logger()->error('Page visit log failed: ' . $e->getMessage());
            }
        }
    }
}
