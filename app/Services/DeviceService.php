<?php

namespace App\Services;

use App\Models\License;
use App\Models\LicenseDevice;
use Illuminate\Support\Facades\DB;

class DeviceService
{
    // پیدا کردن دستگاه ثبت شده
    public function findDevice(License $license, string $machineId): ?LicenseDevice
    {
        return $license->devices()
            ->where('machine_fingerprint', $machineId)
            ->first();
    }

    // بررسی اینکه دستگاه قبلاً ثبت شده یا نه
    public function isDeviceRegistered(License $license, string $machineId): bool
    {
        return $this->findDevice($license, $machineId) !== null;
    }

    // تعداد دستگاه‌های ثبت شده
    public function countDevices(License $license): int
    {
        return $license->devices()->count();
    }

    // بررسی امکان ثبت دستگاه جدید
    public function canRegisterNewDevice(License $license): bool
    {
        $maxDevices = $license->subscription->plan->max_devices;
        $currentCount = $this->countDevices($license);

        return $currentCount < $maxDevices;
    }

    // پیدا کردن اولین seat آزاد
    public function getNextAvailableSeat(License $license, int $maxDevices): int
    {
        $usedSeats = $license->devices()
            ->pluck('seat_number')
            ->filter()
            ->map(fn ($seat) => (int) $seat)
            ->toArray();

        for ($seat = 1; $seat <= $maxDevices; $seat++) {
            if (!in_array($seat, $usedSeats, true)) {
                return $seat;
            }
        }

        throw new \RuntimeException('No available seat for this license.');
    }

    // ثبت دستگاه
    public function registerDevice(License $license, string $machineId): LicenseDevice
    {
        return DB::transaction(function () use ($license, $machineId) {

            // اگر دستگاه قبلاً ثبت شده باشد
            $existingDevice = $this->findDevice($license, $machineId);

            if ($existingDevice) {
                $existingDevice->update([
                    'activated_at' => now(),
                ]);

                return $existingDevice;
            }

            if (! $this->canRegisterNewDevice($license)) {
                throw new \RuntimeException('Maximum device limit reached for this license.');
            }

            $maxDevices = $license->subscription->plan->max_devices;

            $seatNumber = $this->getNextAvailableSeat($license, $maxDevices);

            return LicenseDevice::create([
                'license_id' => $license->id,
                'seat_number' => $seatNumber,
                'machine_fingerprint' => $machineId,
                'activated_at' => now(),
            ]);
        });
    }

    // حذف دستگاه
    public function removeDevice(License $license, string $machineId): bool
    {
        return (bool) LicenseDevice::where('license_id', $license->id)
            ->where('machine_fingerprint', $machineId)
            ->delete();
    }
}
