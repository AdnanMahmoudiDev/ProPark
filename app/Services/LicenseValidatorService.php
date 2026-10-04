<?php

namespace App\Services;

use App\Models\License;
use App\Models\Subscription;
use App\Models\SubscriptionSupport;
use App\Services\DeviceService;
use App\Services\License\SignatureService;
use Carbon\Carbon;

/**
 * این کلاس مسئولیت اعتبارسنجی لایسنس‌های مادام‌العمر،
 * مدیریت دستگاه‌ها و محاسبه زمان باقیمانده پشتیبانی را بر عهده دارد.
 */
class LicenseValidatorService
{
    protected DeviceService $deviceService;
    protected SignatureService $signatureService;

    public function __construct(DeviceService $deviceService, SignatureService $signatureService)
    {
        $this->deviceService = $deviceService;
        $this->signatureService = $signatureService;
    }

    /**
     * ساخت امضای پاسخ فقط بر اساس data
     * برای جلوگیری از مشکل Canonical JSON در سمت کلاینت، فقط payload اصلی امضا می‌شود نه کل response
     */
    private function signResponse(array $response): array
    {
        if (!array_key_exists('data', $response)) {
            $response['data'] = [];
        }

        $response['signature'] = $this->signatureService->sign($response['data']);

        return $response;
    }

    /**
     * تبدیل زمان باقیمانده به متن خوانا برای برنامه پایتونی
     */
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

    /**
     * نرمال‌سازی مقدار expires_at به شیء Carbon
     */
    private function normalizeDate($date): ?Carbon
    {
        if (!$date) {
            return null;
        }

        return $date instanceof Carbon ? $date : Carbon::parse($date);
    }

    /**
     * محاسبه دقیق زمان باقیمانده برای یک تاریخ انقضا
     */
    private function calculateRemainingTime(?Carbon $expiresAt): array
    {
        if (!$expiresAt || $expiresAt->isPast()) {
            return [
                'total_seconds' => 0,
                'days'          => 0,
                'hours'         => 0,
                'minutes'       => 0,
                'seconds'       => 0,
                'text'          => 'Expired',
            ];
        }

        $remainingSeconds = (int) max(0, floor(now()->diffInSeconds($expiresAt, false)));

        $days    = intdiv($remainingSeconds, 86400);
        $hours   = intdiv($remainingSeconds % 86400, 3600);
        $minutes = intdiv($remainingSeconds % 3600, 60);
        $seconds = $remainingSeconds % 60;

        return [
            'total_seconds' => $remainingSeconds,
            'days'          => $days,
            'hours'         => $hours,
            'minutes'       => $minutes,
            'seconds'       => $seconds,
            'text'          => $this->formatRemainingTimeText($days, $hours, $minutes, $seconds),
        ];
    }

    /**
     * استخراج و فرمت اطلاعات پشتیبانی برای اشتراک
     */
    private function buildSupportData(Subscription $subscription): array
    {
        /** @var SubscriptionSupport|null $activeSupport */
        $activeSupport = $subscription->activeSupport;

        if ($activeSupport && $activeSupport->expires_at && $activeSupport->expires_at->isFuture()) {
            $expiresAt = $this->normalizeDate($activeSupport->expires_at);
            $remaining = $this->calculateRemainingTime($expiresAt);

            return [
                'has_support'    => true,
                'status'         => SubscriptionSupport::STATUS_ACTIVE,
                'starts_at'      => $activeSupport->starts_at ? $this->normalizeDate($activeSupport->starts_at)->toIso8601String() : null,
                'expires_at'     => $expiresAt->toIso8601String(),
                'expires_at_raw' => $expiresAt->format('Y-m-d H:i:s'),
                'is_expired'     => false,
                'remaining'      => $remaining,
                'remaining_days' => $remaining['days'],
            ];
        }

        // در صورتی که پشتیبانی فعال ندارد یا منقضی شده است
        /** @var SubscriptionSupport|null $latestSupport */
        $latestSupport = $subscription->latestSupport;

        if ($latestSupport) {
            $expiresAt = $this->normalizeDate($latestSupport->expires_at);
            return [
                'has_support'    => false,
                'status'         => SubscriptionSupport::STATUS_EXPIRED,
                'starts_at'      => $latestSupport->starts_at ? $this->normalizeDate($latestSupport->starts_at)->toIso8601String() : null,
                'expires_at'     => $expiresAt ? $expiresAt->toIso8601String() : null,
                'expires_at_raw' => $expiresAt ? $expiresAt->format('Y-m-d H:i:s') : null,
                'is_expired'     => true,
                'remaining'      => $this->calculateRemainingTime(null),
                'remaining_days' => 0,
            ];
        }

        return [
            'has_support'    => false,
            'status'         => 'none',
            'starts_at'      => null,
            'expires_at'     => null,
            'expires_at_raw' => null,
            'is_expired'     => false,
            'remaining'      => $this->calculateRemainingTime(null),
            'remaining_days' => 0,
        ];
    }

    /**
     * API اصلی اعتبارسنجی و فعال‌سازی لایسنس مادام‌العمر (برای استفاده در برنامه پایتونی)
     */
    public function validate(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['subscription.plan', 'subscription.activeSupport', 'subscription.latestSupport', 'devices'])
            ->first();

        if (!$license || !$license->is_active) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'Invalid or inactive license',
            ]);
        }

        $subscription = $license->subscription;

        if (!$subscription) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'Subscription data missing',
            ]);
        }

        if ($subscription->status !== Subscription::STATUS_ACTIVE) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'Subscription is inactive',
                'data'    => [
                    'license_key'  => $license->license_key,
                    'subscription' => [
                        'status'           => $subscription->status,
                        'effective_status' => Subscription::STATUS_DEACTIVATED,
                        'is_lifetime'      => true,
                    ],
                ],
            ]);
        }

        $plan = $subscription->plan;

        if (!$plan) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'Subscription plan data missing',
            ]);
        }

        $maxDevices = (int) $plan->max_devices;
        $currentDevices = $this->deviceService->countDevices($license);

        if (
            !$this->deviceService->isDeviceRegistered($license, $deviceId)
            && $currentDevices >= $maxDevices
        ) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'Device limit reached',
            ]);
        }

        $device = $this->deviceService->registerDevice($license, $deviceId);
        $supportData = $this->buildSupportData($subscription);

        return $this->signResponse([
            'valid'   => true,
            'message' => 'Access granted',
            'data'    => [
                'license_key'  => $license->license_key,
                'subscription' => [
                    'status'           => $subscription->status,
                    'effective_status' => Subscription::STATUS_ACTIVE,
                    'is_lifetime'      => true,
                ],
                'plan' => [
                    'slug'        => $plan->slug,
                    'max_devices' => $maxDevices,
                ],
                'device' => [
                    'seat_number' => $device->seat_number,
                ],
                'support' => $supportData,
            ],
        ]);
    }

    /**
     * API اختصاصی دریافت وضعیت پشتیبانی لایسنس
     */
    public function getSupportStatus(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['subscription.plan', 'subscription.activeSupport', 'subscription.latestSupport', 'devices'])
            ->first();

        if (!$license) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'License not found',
            ]);
        }

        if (!$license->is_active) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'License is inactive',
            ]);
        }

        $subscription = $license->subscription;

        if (!$subscription) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'No subscription found for this license',
            ]);
        }

        if (!$this->deviceService->isDeviceRegistered($license, $deviceId)) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'This device is not registered for this license',
            ]);
        }

        $device = $this->deviceService->findDevice($license, $deviceId);
        $supportData = $this->buildSupportData($subscription);

        return $this->signResponse([
            'valid'   => true,
            'message' => 'Support status fetched successfully',
            'data'    => [
                'license_key'  => $license->license_key,
                'subscription' => [
                    'status'      => $subscription->status,
                    'is_lifetime' => true,
                ],
                'device' => [
                    'seat_number' => optional($device)->seat_number,
                ],
                'support' => $supportData,
            ],
        ]);
    }

    /**
     * API خروج دستگاه از لایسنس (Logout)
     */
    public function deactivateDevice(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['devices'])
            ->first();

        if (!$license) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'License not found',
            ]);
        }

        if (!$license->is_active) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'License is inactive',
            ]);
        }

        $device = $this->deviceService->findDevice($license, $deviceId);

        if (!$device) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'Device not found for this license',
            ]);
        }

        $seatNumber = $device->seat_number;
        $this->deviceService->removeDevice($license, $deviceId);

        return $this->signResponse([
            'valid'   => true,
            'message' => 'Device successfully deactivated',
            'data'    => [
                'license_key' => $license->license_key,
                'device'      => [
                    'seat_number' => $seatNumber,
                ],
            ],
        ]);
    }

    /**
     * API دریافت اطلاعات کامل لایسنس
     */
    public function licenseInfo(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['subscription.plan', 'subscription.activeSupport', 'subscription.latestSupport', 'devices'])
            ->first();

        if (!$license) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'License not found',
            ]);
        }

        if (!$license->is_active) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'License is inactive',
            ]);
        }

        $subscription = $license->subscription;

        if (!$subscription) {
            return $this->signResponse([
                'valid'   => false,
                'message' => 'Subscription data missing',
            ]);
        }

        $device = $this->deviceService->findDevice($license, $deviceId);
        $plan = $subscription->plan;
        $supportData = $this->buildSupportData($subscription);

        return $this->signResponse([
            'valid'   => true,
            'message' => 'License info fetched successfully',
            'data'    => [
                'license_key'  => $license->license_key,
                'subscription' => [
                    'status'           => $subscription->status,
                    'effective_status' => $subscription->isActive() ? Subscription::STATUS_ACTIVE : Subscription::STATUS_DEACTIVATED,
                    'is_lifetime'      => true,
                ],
                'plan' => [
                    'slug'        => optional($plan)->slug,
                    'max_devices' => optional($plan)->max_devices,
                ],
                'devices' => [
                    'active_devices' => $this->deviceService->countDevices($license),
                    'seat_number'    => optional($device)->seat_number,
                ],
                'support' => $supportData,
            ],
        ]);
    }
}
