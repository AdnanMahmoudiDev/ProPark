<?php

namespace App\Services;

use App\Models\License;
use App\Models\Subscription;
use App\Services\DeviceService;
use App\Services\License\SignatureService;
use Carbon\Carbon;

// این کلاس مسئولیت اعتبار سنجی لایسنس ها و محاسبه ی زمان باقیمانده اشتراک ها را دارد
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

    // نرمالسازی مقدار expires_at
    // اگر متن باشد آن را به Carbon تبدیل میکند
    private function normalizeExpiresAt($expiresAt): Carbon
    {
        return $expiresAt instanceof Carbon
            ? $expiresAt
            : Carbon::parse($expiresAt);
    }

    // محاسبه ی دقیق زمان باقیمانده اشتراک ها
    private function calculateRemainingValidity(Carbon $expiresAt): array
    {
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

    private function subscriptionData(
        License $license,
        Subscription $subscription,
        ?Carbon $expiresAt = null,
        ?array $remaining = null,
        $device = null
    ): array {
        $expiresAt = $expiresAt ?: (
            $subscription->expires_at
                ? $this->normalizeExpiresAt($subscription->expires_at)
                : null
        );

        $remaining = $remaining ?: (
            $expiresAt
                ? $this->calculateRemainingValidity($expiresAt)
                : null
        );

        $data = [
            'license_key' => $license->license_key,
            'subscription' => [
                'status' => $subscription->status,
                'effective_status' => $subscription->isActive()
                    ? Subscription::STATUS_ACTIVE
                    : Subscription::STATUS_DEACTIVATED,
            ],
            'plan' => [
                'slug' => optional($subscription->plan)->slug,
            ],
        ];

        if ($expiresAt) {
            $data['expires_at'] = $expiresAt->format('Y-m-d H:i:s');
        }

        if ($remaining) {
            $data['remaining'] = $remaining;
            $data['remaining_days'] = $remaining['days'];
        }

        if ($device !== null) {
            $data['device'] = [
                'seat_number' => optional($device)->seat_number,
            ];
        }

        return $data;
    }

    private function inactiveSubscriptionResponse(
        License $license,
        Subscription $subscription,
        string $message,
        ?Carbon $expiresAt = null,
        ?array $remaining = null,
        $device = null
    ): array {
        return $this->signResponse([
            'valid' => false,
            'message' => $message,
            'data' => $this->subscriptionData($license, $subscription, $expiresAt, $remaining, $device),
        ]);
    }

    // API اصلی اعتبار سنجی لایسنس که برای استفاده از برنامه پایتونی استفاده میشود
    public function validate(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['subscription.plan', 'devices'])
            ->first();

        if (!$license || !$license->is_active) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Invalid or inactive license',
            ]);
        }

        $subscription = $license->subscription;

        if (!$subscription) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Subscription data missing',
            ]);
        }

        if (!$subscription->expires_at) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Subscription expiration date missing',
            ]);
        }

        $expiresAt = $this->normalizeExpiresAt($subscription->expires_at);
        $remaining = $this->calculateRemainingValidity($expiresAt);

        if ($subscription->status !== Subscription::STATUS_ACTIVE) {
            return $this->inactiveSubscriptionResponse(
                $license,
                $subscription,
                'Subscription is inactive',
                $expiresAt,
                $remaining
            );
        }

        if (!$subscription->isActive()) {
            return $this->inactiveSubscriptionResponse(
                $license,
                $subscription,
                'Subscription expired',
                $expiresAt,
                $remaining
            );
        }

        $plan = $subscription->plan;

        if (!$plan) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Subscription plan data missing',
            ]);
        }

        $maxDevices = $plan->max_devices;
        $currentDevices = $this->deviceService->countDevices($license);

        if (
            !$this->deviceService->isDeviceRegistered($license, $deviceId)
            && $currentDevices >= $maxDevices
        ) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Device limit reached',
            ]);
        }

        $device = $this->deviceService->registerDevice($license, $deviceId);

        return $this->signResponse([
            'valid' => true,
            'message' => 'Access granted',
            'data' => [
                'license_key' => $license->license_key,
                'subscription' => [
                    'status' => $subscription->status,
                    'effective_status' => Subscription::STATUS_ACTIVE,
                ],
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
        ]);
    }

    // API فقط برای گرفتن زمان باقیمانده اعتبار لایسنس
    public function getRemainingValidity(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['subscription.plan', 'devices'])
            ->first();

        if (!$license) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'License not found',
            ]);
        }

        if (!$license->is_active) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'License is inactive',
            ]);
        }

        $subscription = $license->subscription;

        if (!$subscription) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'No subscription found for this license',
            ]);
        }

        if (!$subscription->expires_at) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Subscription expiration date is not set',
            ]);
        }

        if (!$this->deviceService->isDeviceRegistered($license, $deviceId)) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'This device is not registered for this license',
            ]);
        }

        $device = $this->deviceService->findDevice($license, $deviceId);

        $expiresAt = $this->normalizeExpiresAt($subscription->expires_at);
        $remaining = $this->calculateRemainingValidity($expiresAt);

        if ($subscription->status !== Subscription::STATUS_ACTIVE) {
            return $this->inactiveSubscriptionResponse(
                $license,
                $subscription,
                'Subscription is inactive',
                $expiresAt,
                $remaining,
                $device
            );
        }

        if (!$subscription->isActive()) {
            return $this->inactiveSubscriptionResponse(
                $license,
                $subscription,
                'Subscription has expired',
                $expiresAt,
                $remaining,
                $device
            );
        }

        return $this->signResponse([
            'valid' => true,
            'message' => 'License validity fetched successfully',
            'data' => [
                'license_key' => $license->license_key,
                'subscription' => [
                    'status' => $subscription->status,
                    'effective_status' => Subscription::STATUS_ACTIVE,
                ],
                'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                'remaining' => $remaining,
                'remaining_days' => $remaining['days'],
                'plan' => [
                    'slug' => optional($subscription->plan)->slug,
                ],
                'device' => [
                    'seat_number' => optional($device)->seat_number,
                ],
            ],
        ]);
    }

    // API خروج دستگاه از لایسنس
    public function deactivateDevice(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['devices'])
            ->first();

        if (!$license) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'License not found',
            ]);
        }

        if (!$license->is_active) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'License is inactive',
            ]);
        }

        $device = $this->deviceService->findDevice($license, $deviceId);

        if (!$device) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Device not found for this license',
            ]);
        }

        $seatNumber = $device->seat_number;

        $this->deviceService->removeDevice($license, $deviceId);

        return $this->signResponse([
            'valid' => true,
            'message' => 'Device successfully deactivated',
            'data' => [
                'license_key' => $license->license_key,
                'device' => [
                    'seat_number' => $seatNumber,
                ],
            ],
        ]);
    }

    // API برای دریافت اطلاعات لایسنس
    public function licenseInfo(string $licenseKey, string $deviceId): array
    {
        $license = License::where('license_key', $licenseKey)
            ->with(['subscription.plan', 'devices'])
            ->first();

        if (!$license) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'License not found',
            ]);
        }

        if (!$license->is_active) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'License is inactive',
            ]);
        }

        $subscription = $license->subscription;

        if (!$subscription || !$subscription->expires_at) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Subscription data missing',
            ]);
        }

        $expiresAt = $this->normalizeExpiresAt($subscription->expires_at);
        $remaining = $this->calculateRemainingValidity($expiresAt);

        $device = $this->deviceService->findDevice($license, $deviceId);
        $plan = $subscription->plan;

        if ($subscription->status !== Subscription::STATUS_ACTIVE) {
            return $this->inactiveSubscriptionResponse(
                $license,
                $subscription,
                'Subscription is inactive',
                $expiresAt,
                $remaining,
                $device
            );
        }

        if (!$subscription->isActive()) {
            return $this->inactiveSubscriptionResponse(
                $license,
                $subscription,
                'Subscription has expired',
                $expiresAt,
                $remaining,
                $device
            );
        }

        return $this->signResponse([
            'valid' => true,
            'message' => 'License info fetched successfully',
            'data' => [
                'license_key' => $license->license_key,
                'subscription' => [
                    'status' => $subscription->status,
                    'effective_status' => Subscription::STATUS_ACTIVE,
                ],
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
        ]);
    }
}
