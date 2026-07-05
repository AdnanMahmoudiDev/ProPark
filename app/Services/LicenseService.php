<?php

namespace App\Services;

use App\Models\License;
use App\Models\Subscription;
use Illuminate\Support\Str;

class LicenseService
{
    
    //  تولید کلید لایسنس با فرمت PRPK-XXXX-XXXX-XXXX-XXXX
    //  حروف بزرگ و اعداد برای خوانایی بهتر
     
    private function generateFormattedKey(): string
    {
        return sprintf(
            'PRPK-%s-%s-%s-%s',
            strtoupper(Str::random(4)),
            strtoupper(Str::random(4)),
            strtoupper(Str::random(4)),
            strtoupper(Str::random(4))
        );
    }
    // تولید کد لایسنس یکتا با فرمت مشخص و اطمینان از تکرار نشدن در پایگاه داده

    public function generateUniqueLicenseKey(): string
    {
        do {
            $key = $this->generateFormattedKey();
        } while (License::where('license_key', $key)->exists());

        return $key;
    }

    public function createLicense(Subscription $subscription): License
    {
        return License::create([
            'user_id'         => $subscription->user_id,
            'subscription_id' => $subscription->id,
            'license_key'     => $this->generateUniqueLicenseKey(),
            'is_active'       => true,
        ]);
    }

    public function findByKey(string $licenseKey): ?License
    {
        return License::where('license_key', $licenseKey)->first();
    }

    public function deactivateLicense(License $license): bool
    {
        return $license->update([
            'is_active' => false,
        ]);
    }

    public function activateLicense(License $license): bool
    {
        return $license->update([
            'is_active' => true,
        ]);
    }
}
