<?php

namespace App\Services;

use App\Models\License;
use App\Models\LicenseDevice;

class DeviceService
{
    
    //  پیدا کردن دستگاه ثبت شده
     
    public function findDevice(License $license, string $machineId): ?LicenseDevice
    {
        return $license->devices()
            ->where('machine_fingerprint', $machineId)
            ->first();
    }

    
    //   بررسی اینکه دستگاه قبلاً ثبت شده یا نه

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

    // پیدا کردن اولین جایگاه خالی برای ثبت دستگاه
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

    // ثبت دستگاه جدید
    public function registerDevice(License $license, string $machineId): LicenseDevice
    {
        $existingDevice = $this->findDevice($license, $machineId);

        if ($existingDevice) {
            // به‌روزرسانی زمان آخرین فعال‌سازی
            $existingDevice->update([
                'activated_at' => now(),
            ]);

            return $existingDevice;
        }

        $maxDevices = $license->subscription->plan->max_devices;

        $seatNumber = $this->getNextAvailableSeat($license, $maxDevices);

        $device = LicenseDevice::create([
            'license_id' => $license->id,
            'seat_number' => $seatNumber,
            'machine_fingerprint' => $machineId,
            'activated_at' => now(),
        ]);

        return $device;
    }


    // حذف دستگاه
    public function removeDevice(License $license, string $machineId): bool
    {
        return (bool) LicenseDevice::where('license_id', $license->id)
            ->where('machine_fingerprint', $machineId)
            ->delete();
    }
}
