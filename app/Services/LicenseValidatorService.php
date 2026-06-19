<?php

namespace App\Services;

use App\Models\License;
use App\Services\DeviceService;
use App\Services\License\SignatureService;
use Carbon\Carbon;

// این کلاس مسئولیت اهتبار سنجی لایسنس ها و محاسبه ی زمان باقیمانده اشتراک ها است
class LicenseValidatorService
{
    protected DeviceService $deviceService;
    protected SignatureService $signatureService;

    public function __construct(DeviceService $deviceService, SignatureService $signatureService)
    {
        $this->deviceService = $deviceService;
        $this->signatureService = $signatureService;
    }

    // ساخت امضای پاسخ فقط بر اساس data
    // برای جلوگیری از مشکل Canonical JSON در سمت کلاینت، فقط payload اصلی امضا میشود نه کل response
    private function signResponse(array $response): array
    {
        if (!array_key_exists('data', $response)) {
            $response['data'] = [];
        }

        $response['signature'] = $this->signatureService->sign($response['data']);

        return $response;
    }

    // تبدیل زمان باقیمانده به متن خوانا و دیتای قابل استفاده برای برنامه ی پایتونی
    private function formatRemainingTimeText(
        int $days,
        int $hours,
        int $minutes,
        int $seconds
    ): string {
        if ($days > 0) {
            if ($hours > 0) {
                return "{$days} days and {$hours} hours";
            }
            return "{$days} days";
        }

        if ($hours > 0) {
            if ($minutes > 0) {
                return "{$hours} hours and {$minutes} minutes";
            }
            return "{$hours} hours";
        }

        if ($minutes > 0) {
            if ($seconds > 0) {
                return "{$minutes} minutes and {$seconds} seconds";
            }
            return "{$minutes} minutes";
        }

        if ($seconds > 0) {
            return "{$seconds} seconds";
        }

        return 'Expired';
    }

    // نرمالسازی مقدار xpires_at
    // اگر متن باشد ان را به carbon تبدیل میکند
    private function normalizeExpiresAt($expiresAt): Carbon
    {
        return $expiresAt instanceof Carbon
            ? $expiresAt
            : Carbon::parse($expiresAt);
    }

    // محاسبه ی دقیق زمان باقیمانده اشتراک ها 
    private function calculateRemainingValidity(Carbon $expiresAt): array
    {
        // اختلاف زمانی به ثانیه 
        // تبدیل اختلاف زمانی منفی به صفر مثلا اگر اعتبار لایسنس تمام شده بود این باعث میشود بجای تاریخ اعتبار مانده را منفی برگرداند صفر برمیگرداند
        $remainingSeconds = (int) max(0, floor(now()->diffInSeconds($expiresAt, false)));

        $days = intdiv($remainingSeconds, 86400);
        $hours = intdiv($remainingSeconds % 86400, 3600);
        $minutes = intdiv($remainingSeconds % 3600, 60);
        $seconds = $remainingSeconds % 60;

        return [
            'total_seconds' => $remainingSeconds,
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
            'text' => $this->formatRemainingTimeText($days, $hours, $minutes, $seconds),
        ];
    }

    // API اصلی اعتبار سنجی لایسنس که برای استفاده از از برنامه پایتونی استفاده میشود
    public function validate(string $licenseKey, string $deviceId): array
    {

        $license = License::where('license_key', $licenseKey)
            ->with(['subscription.plan', 'devices'])
            ->first();

        // برسی وجود و فعال بودن لایسنس 
        if (!$license || !$license->is_active) {
            $response = [
                'valid' => false,
                'message' => 'Invalid or inactive license',
            ];

            return $this->signResponse($response);
        }

        $subscription = $license->subscription;

        // برسی وجود اشتراک
        if (!$subscription) {
            $response = [
                'valid' => false,
                'message' => 'Subscription data missing',
            ];

            return $this->signResponse($response);
        }

        // برسی داشتن تاریخ انقضا
        if (!$subscription->expires_at) {
            $response = [
                'valid' => false,
                'message' => 'Subscription expiration date missing',
            ];

            return $this->signResponse($response);
        }

        $expiresAt = $this->normalizeExpiresAt($subscription->expires_at);
        $remaining = $this->calculateRemainingValidity($expiresAt);

        // برسی منقضی بودن اشتراک
        if ($remaining['total_seconds'] <= 0) {
            $response = [
                'valid' => false,
                'message' => 'Subscription expired',
                'data' => [
                    'license_key' => $license->license_key,
                    'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                    'remaining' => $remaining,
                    'plan' => [
                        'slug' => optional($subscription->plan)->slug,
                    ],
                ],
            ];

            return $this->signResponse($response);
        }

        $plan = $subscription->plan;

        //  کنترل محدودیت دستگاه ها
        $maxDevices = $plan->max_devices;
        $currentDevices = $this->deviceService->countDevices($license);

        if (
            !$this->deviceService->isDeviceRegistered($license, $deviceId)
            && $currentDevices >= $maxDevices
        ) {
            $response = [
                'valid' => false,
                'message' => 'Device limit reached',
            ];

            return $this->signResponse($response);
        }

        //  ثبت دستگاه
        // اگر قبلا ثبت نشده باشد
        $device = $this->deviceService->registerDevice($license, $deviceId);

        // پاسخ موفق بودن
        $response = [
            'valid' => true,
            'message' => 'Access granted',
            'data' => [
                'license_key' => $license->license_key,
                'plan' => [
                    'slug' => $plan->slug,
                ],
                'device' => [
                    'seat_number' => $device->seat_number,
                ],
                'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                'remaining' => $remaining,

                'remaining_days' => $remaining['days'],
            ],
        ];

        return $this->signResponse($response);
    }

    // API فقط برای گرفتن زمان باقیمانده اعتبار لایسنس 
    public function getRemainingValidity(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['subscription.plan', 'devices'])
            ->first();

        if (!$license) {
            $response = [
                'valid' => false,
                'message' => 'License not found',
            ];

            return $this->signResponse($response);
        }

        if (!$license->is_active) {
            $response = [
                'valid' => false,
                'message' => 'License is inactive',
            ];

            return $this->signResponse($response);
        }

        $subscription = $license->subscription;

        if (!$subscription) {
            $response = [
                'valid' => false,
                'message' => 'No subscription found for this license',
            ];

            return $this->signResponse($response);
        }

        if (!$subscription->expires_at) {
            $response = [
                'valid' => false,
                'message' => 'Subscription expiration date is not set',
            ];

            return $this->signResponse($response);
        }

        if (!$this->deviceService->isDeviceRegistered($license, $deviceId)) {
            $response = [
                'valid' => false,
                'message' => 'This device is not registered for this license',
            ];

            return $this->signResponse($response);
        }

        $device = $this->deviceService->findDevice($license, $deviceId);

        $expiresAt = $this->normalizeExpiresAt($subscription->expires_at);
        $remaining = $this->calculateRemainingValidity($expiresAt);

        if ($remaining['total_seconds'] <= 0) {
            $response = [
                'valid' => false,
                'message' => 'Subscription has expired',
                'data' => [
                    'license_key' => $license->license_key,
                    'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                    'remaining' => $remaining,
                    'plan' => [
                        'slug' => optional($subscription->plan)->slug,
                    ],
                    'device' => [
                        'seat_number' => optional($device)->seat_number,
                    ],
                ],
            ];

            return $this->signResponse($response);
        }

        $response = [
            'valid' => true,
            'message' => 'License validity fetched successfully',
            'data' => [
                'license_key' => $license->license_key,
                'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                'remaining' => $remaining,
                'plan' => [
                    'slug' => optional($subscription->plan)->slug,
                ],
                'device' => [
                    'seat_number' => optional($device)->seat_number,
                ],
            ],
        ];

        return $this->signResponse($response);
    }

    // API برای حذف یک دستگاه از نشست فعال
    // API خروج دستگاه از لایسنس (Logout / Deactivate Device)
    public function deactivateDevice(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['devices'])
            ->first();

        if (!$license) {
            $response = [
                'valid' => false,
                'message' => 'License not found',
            ];

            return $this->signResponse($response);
        }

        if (!$license->is_active) {
            $response = [
                'valid' => false,
                'message' => 'License is inactive',
            ];

            return $this->signResponse($response);
        }

        $device = $this->deviceService->findDevice($license, $deviceId);

        if (!$device) {
            $response = [
                'valid' => false,
                'message' => 'Device not found for this license',
            ];

            return $this->signResponse($response);
        }

        $seatNumber = $device->seat_number;

        $this->deviceService->removeDevice($license, $deviceId);

        $response = [
            'valid' => true,
            'message' => 'Device successfully deactivated',
            'data' => [
                'license_key' => $license->license_key,
                'device' => [
                    'seat_number' => $seatNumber,
                ],
            ],
        ];

        return $this->signResponse($response);
    }

    // API برای دریافت اطلاعات لایسنس
    public function licenseInfo(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['subscription.plan', 'devices'])
            ->first();

        if (!$license) {
            $response = [
                'valid' => false,
                'message' => 'License not found',
            ];

            return $this->signResponse($response);
        }

        if (!$license->is_active) {
            $response = [
                'valid' => false,
                'message' => 'License is inactive',
            ];

            return $this->signResponse($response);
        }

        $subscription = $license->subscription;

        if (!$subscription || !$subscription->expires_at) {
            $response = [
                'valid' => false,
                'message' => 'Subscription data missing',
            ];

            return $this->signResponse($response);
        }

        $expiresAt = $this->normalizeExpiresAt($subscription->expires_at);
        $remaining = $this->calculateRemainingValidity($expiresAt);

        $device = $this->deviceService->findDevice($license, $deviceId);

        $plan = $subscription->plan;

        $response = [
            'valid' => true,
            'message' => 'License info fetched successfully',
            'data' => [
                'license_key' => $license->license_key,
                'plan' => [
                    'slug' => optional($plan)->slug,
                    'max_devices' => optional($plan)->max_devices,
                ],
                'devices' => [
                    'active_devices' => $this->deviceService->countDevices($license),
                    'seat_number' => optional($device)->seat_number,
                ],
                'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                'remaining' => $remaining,
                'remaining_days' => $remaining['days'],
            ],
        ];

        return $this->signResponse($response);
    }
}
