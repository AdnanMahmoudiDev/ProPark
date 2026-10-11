<?php

namespace App\Services;

use App\Models\DemoLicenseDevice;
use App\Models\License;
use App\Models\Subscription;
use App\Models\SubscriptionSupport;
use App\Services\License\SignatureService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class LicenseValidatorService
{
    protected DeviceService $deviceService;

    protected SignatureService $signatureService;

    public function __construct(
        DeviceService $deviceService,
        SignatureService $signatureService
    ) {
        $this->deviceService = $deviceService;
        $this->signatureService = $signatureService;
    }

    /**
     * کلید ثابت لایسنس دمو.
     *
     * مقدار اصلی از فایل .env خوانده می‌شود.
     */
    private function demoLicenseKey(): string
    {
        return strtoupper(trim((string) env(
            'PROPARK_DEMO_LICENSE_KEY',
            'PROPARK-DEMO-TRIAL'
        )));
    }

    /**
     * بررسی می‌کند که کلید واردشده، کلید دمو است یا خیر.
     */
    private function isDemoLicense(string $licenseKey): bool
    {
        return strtoupper(trim($licenseKey)) === $this->demoLicenseKey();
    }

    /**
     * ساخت امضای پاسخ فقط بر اساس data.
     */
    private function signResponse(array $response): array
    {
        if (!array_key_exists('data', $response)) {
            $response['data'] = [];
        }

        $response['signature'] = $this->signatureService->sign(
            $response['data']
        );

        return $response;
    }

    /**
     * تبدیل زمان باقی‌مانده به متن خوانا.
     */
    private function formatRemainingTimeText(
        int $days,
        int $hours,
        int $minutes,
        int $seconds
    ): string {
        if ($days > 0) {
            return $hours > 0
                ? "{$days} days and {$hours} hours"
                : "{$days} days";
        }

        if ($hours > 0) {
            return $minutes > 0
                ? "{$hours} hours and {$minutes} minutes"
                : "{$hours} hours";
        }

        if ($minutes > 0) {
            return $seconds > 0
                ? "{$minutes} minutes and {$seconds} seconds"
                : "{$minutes} minutes";
        }

        if ($seconds > 0) {
            return "{$seconds} seconds";
        }

        return 'Expired';
    }

    /**
     * تبدیل مقدار تاریخ به Carbon.
     */
    private function normalizeDate($date): ?Carbon
    {
        if (!$date) {
            return null;
        }

        return $date instanceof Carbon
            ? $date
            : Carbon::parse($date);
    }

    /**
     * محاسبه دقیق زمان باقی‌مانده.
     */
    private function calculateRemainingTime(?Carbon $expiresAt): array
    {
        if (!$expiresAt || $expiresAt->isPast()) {
            return [
                'total_seconds' => 0,
                'days' => 0,
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0,
                'text' => 'Expired',
            ];
        }

        $remainingSeconds = max(
            0,
            (int) now()->diffInSeconds($expiresAt, false)
        );

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
            'text' => $this->formatRemainingTimeText(
                $days,
                $hours,
                $minutes,
                $seconds
            ),
        ];
    }

    /**
     * ساخت اطلاعات پشتیبانی برای لایسنس واقعی.
     */
    private function buildSupportData(Subscription $subscription): array
    {
        /** @var SubscriptionSupport|null $activeSupport */
        $activeSupport = $subscription->activeSupport;

        if (
            $activeSupport &&
            $activeSupport->expires_at &&
            $activeSupport->expires_at->isFuture()
        ) {
            $expiresAt = $this->normalizeDate(
                $activeSupport->expires_at
            );

            $remaining = $this->calculateRemainingTime($expiresAt);

            return [
                'has_support' => true,
                'status' => SubscriptionSupport::STATUS_ACTIVE,
                'starts_at' => $activeSupport->starts_at
                    ? $this->normalizeDate(
                        $activeSupport->starts_at
                    )->toIso8601String()
                    : null,
                'expires_at' => $expiresAt?->toIso8601String(),
                'expires_at_raw' => $expiresAt?->format(
                    'Y-m-d H:i:s'
                ),
                'is_expired' => false,
                'remaining' => $remaining,
                'remaining_days' => $remaining['days'],
            ];
        }

        /** @var SubscriptionSupport|null $latestSupport */
        $latestSupport = $subscription->latestSupport;

        if ($latestSupport) {
            $expiresAt = $this->normalizeDate(
                $latestSupport->expires_at
            );

            return [
                'has_support' => false,
                'status' => SubscriptionSupport::STATUS_EXPIRED,
                'starts_at' => $latestSupport->starts_at
                    ? $this->normalizeDate(
                        $latestSupport->starts_at
                    )->toIso8601String()
                    : null,
                'expires_at' => $expiresAt?->toIso8601String(),
                'expires_at_raw' => $expiresAt?->format(
                    'Y-m-d H:i:s'
                ),
                'is_expired' => true,
                'remaining' => $this->calculateRemainingTime(null),
                'remaining_days' => 0,
            ];
        }

        return [
            'has_support' => false,
            'status' => 'none',
            'starts_at' => null,
            'expires_at' => null,
            'expires_at_raw' => null,
            'is_expired' => false,
            'remaining' => $this->calculateRemainingTime(null),
            'remaining_days' => 0,
        ];
    }

    /**
     * ساخت پاسخ منقضی‌شدن لایسنس دمو.
     */
    private function expiredDemoResponse(
        DemoLicenseDevice $device
    ): array {
        return $this->signResponse([
            'valid' => false,
            'message' => 'Trial period has expired. Please purchase a full license.',
            'data' => [
                'license_key' => $this->demoLicenseKey(),
                'subscription' => [
                    'status' => 'expired',
                    'effective_status' => Subscription::STATUS_DEACTIVATED,
                    'is_lifetime' => false,
                ],
                'device' => [
                    'machine_fingerprint' => $device->machine_fingerprint,
                ],
                'trial' => [
                    'is_trial' => true,
                    'is_expired' => true,
                    'started_at' => $device->trial_started_at
                        ->toIso8601String(),
                    'expires_at' => $device->trial_expires_at
                        ->toIso8601String(),
                    'remaining' => $this->calculateRemainingTime(
                        $device->trial_expires_at
                    ),
                    'remaining_days' => 0,
                ],
            ],
        ]);
    }

    /**
     * اعتبارسنجی لایسنس دمو و ثبت دائمی دستگاه.
     *
     * نکته:
     * رکورد دستگاه دمو هیچ‌وقت حذف یا به‌روزرسانی نمی‌شود.
     */
    private function validateDemoDevice(string $deviceId): array
    {
        $deviceId = trim($deviceId);

        $device = DemoLicenseDevice::query()
            ->where('machine_fingerprint', $deviceId)
            ->first();

        if (!$device) {
            try {
                $startedAt = now();
                $expiresAt = $startedAt->copy()->addDays(15);

                $device = DemoLicenseDevice::create([
                    'machine_fingerprint' => $deviceId,
                    'trial_started_at' => $startedAt,
                    'trial_expires_at' => $expiresAt,
                ]);
            } catch (QueryException $exception) {
                /*
                 * برای جلوگیری از خطای race condition:
                 * اگر دو درخواست هم‌زمان دستگاه را ثبت کردند،
                 * رکورد قبلی را دوباره دریافت می‌کنیم.
                 */
                $device = DemoLicenseDevice::query()
                    ->where('machine_fingerprint', $deviceId)
                    ->first();

                if (!$device) {
                    throw $exception;
                }
            }
        }

        if (now()->greaterThanOrEqualTo($device->trial_expires_at)) {
            return $this->expiredDemoResponse($device);
        }

        $remaining = $this->calculateRemainingTime(
            $device->trial_expires_at
        );

        return $this->signResponse([
            'valid' => true,
            'message' => 'Demo trial access granted',
            'data' => [
                'license_key' => $this->demoLicenseKey(),
                'subscription' => [
                    'status' => Subscription::STATUS_ACTIVE,
                    'effective_status' => Subscription::STATUS_ACTIVE,
                    'is_lifetime' => false,
                ],
                'plan' => [
                    'slug' => 'demo-trial',
                    'max_devices' => 1,
                ],
                'device' => [
                    'machine_fingerprint' => $device->machine_fingerprint,
                    'seat_number' => 1,
                ],
                'trial' => [
                    'is_trial' => true,
                    'is_expired' => false,
                    'started_at' => $device->trial_started_at
                        ->toIso8601String(),
                    'expires_at' => $device->trial_expires_at
                        ->toIso8601String(),
                    'remaining' => $remaining,
                    'remaining_days' => $remaining['days'],
                ],
                'support' => [
                    'has_support' => true,
                    'status' => SubscriptionSupport::STATUS_ACTIVE,
                    'starts_at' => $device->trial_started_at
                        ->toIso8601String(),
                    'expires_at' => $device->trial_expires_at
                        ->toIso8601String(),
                    'expires_at_raw' => $device->trial_expires_at
                        ->format('Y-m-d H:i:s'),
                    'is_expired' => false,
                    'remaining' => $remaining,
                    'remaining_days' => $remaining['days'],
                ],
            ],
        ]);
    }

    /**
     * API اصلی اعتبارسنجی و فعال‌سازی لایسنس.
     */
    public function validate(
        string $licenseKey,
        string $deviceId
    ): array {
        if ($this->isDemoLicense($licenseKey)) {
            return $this->validateDemoDevice($deviceId);
        }

        $license = License::query()
            ->where('license_key', $licenseKey)
            ->with([
                'subscription.plan',
                'subscription.activeSupport',
                'subscription.latestSupport',
                'devices',
            ])
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

        if ($subscription->status !== Subscription::STATUS_ACTIVE) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Subscription is inactive',
                'data' => [
                    'license_key' => $license->license_key,
                    'subscription' => [
                        'status' => $subscription->status,
                        'effective_status' =>
                            Subscription::STATUS_DEACTIVATED,
                        'is_lifetime' => true,
                    ],
                ],
            ]);
        }

        $plan = $subscription->plan;

        if (!$plan) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Subscription plan data missing',
            ]);
        }

        $maxDevices = (int) $plan->max_devices;
        $currentDevices = $this->deviceService->countDevices($license);

        if (
            !$this->deviceService->isDeviceRegistered(
                $license,
                $deviceId
            ) &&
            $currentDevices >= $maxDevices
        ) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Device limit reached',
            ]);
        }

        $device = $this->deviceService->registerDevice(
            $license,
            $deviceId
        );

        $supportData = $this->buildSupportData($subscription);

        return $this->signResponse([
            'valid' => true,
            'message' => 'Access granted',
            'data' => [
                'license_key' => $license->license_key,
                'subscription' => [
                    'status' => $subscription->status,
                    'effective_status' => Subscription::STATUS_ACTIVE,
                    'is_lifetime' => true,
                ],
                'plan' => [
                    'slug' => $plan->slug,
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
     * دریافت وضعیت پشتیبانی.
     */
    public function getSupportStatus(
        string $licenseKey,
        string $deviceId
    ): array {
        if ($this->isDemoLicense($licenseKey)) {
            return $this->validateDemoDevice($deviceId);
        }

        $license = License::query()
            ->where('license_key', $licenseKey)
            ->with([
                'subscription.plan',
                'subscription.activeSupport',
                'subscription.latestSupport',
                'devices',
            ])
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

        if (!$this->deviceService->isDeviceRegistered($license, $deviceId)) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'This device is not registered for this license',
            ]);
        }

        $device = $this->deviceService->findDevice(
            $license,
            $deviceId
        );

        $supportData = $this->buildSupportData($subscription);

        return $this->signResponse([
            'valid' => true,
            'message' => 'Support status fetched successfully',
            'data' => [
                'license_key' => $license->license_key,
                'subscription' => [
                    'status' => $subscription->status,
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
     * خروج دستگاه از لایسنس واقعی.
     *
     * دستگاه دمو عمداً قابل حذف نیست؛
     * در غیر این صورت کاربر می‌توانست Trial را مجدداً شروع کند.
     */
    public function deactivateDevice(
        string $licenseKey,
        string $deviceId
    ): array {
        if ($this->isDemoLicense($licenseKey)) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Demo trial devices cannot be deactivated.',
                'data' => [
                    'license_key' => $this->demoLicenseKey(),
                    'is_lifetime' => false,
                ],
            ]);
        }

        $license = License::query()
            ->where('license_key', $licenseKey)
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

        $device = $this->deviceService->findDevice(
            $license,
            $deviceId
        );

        if (!$device) {
            return $this->signResponse([
                'valid' => false,
                'message' => 'Device not found for this license',
            ]);
        }

        $seatNumber = $device->seat_number;

        $this->deviceService->removeDevice(
            $license,
            $deviceId
        );

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

    /**
     * دریافت اطلاعات کامل لایسنس.
     */
    public function licenseInfo(
        string $licenseKey,
        string $deviceId
    ): array {
        if ($this->isDemoLicense($licenseKey)) {
            return $this->validateDemoDevice($deviceId);
        }

        $license = License::query()
            ->where('license_key', $licenseKey)
            ->with([
                'subscription.plan',
                'subscription.activeSupport',
                'subscription.latestSupport',
                'devices',
            ])
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
                'message' => 'Subscription data missing',
            ]);
        }

        $device = $this->deviceService->findDevice(
            $license,
            $deviceId
        );

        $plan = $subscription->plan;
        $supportData = $this->buildSupportData($subscription);

        return $this->signResponse([
            'valid' => true,
            'message' => 'License info fetched successfully',
            'data' => [
                'license_key' => $license->license_key,
                'subscription' => [
                    'status' => $subscription->status,
                    'effective_status' => $subscription->isActive()
                        ? Subscription::STATUS_ACTIVE
                        : Subscription::STATUS_DEACTIVATED,
                    'is_lifetime' => true,
                ],
                'plan' => [
                    'slug' => optional($plan)->slug,
                    'max_devices' => optional($plan)->max_devices,
                ],
                'devices' => [
                    'active_devices' =>
                        $this->deviceService->countDevices($license),
                    'seat_number' => optional($device)->seat_number,
                ],
                'support' => $supportData,
            ],
        ]);
    }
}
