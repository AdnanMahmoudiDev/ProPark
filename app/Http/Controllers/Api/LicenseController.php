<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateLicenseRequest;
use App\Services\LicenseValidatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    protected LicenseValidatorService $validator;

    public function __construct(LicenseValidatorService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * API اعتبارسنجی لایسنس
     */
    public function validateLicense(ValidateLicenseRequest $request): JsonResponse
    {
        $licenseKey = $request->input('license_key');
        $machineFingerprint = $request->input('machine_fingerprint');

        $result = $this->validator->validate($licenseKey, $machineFingerprint);

        return response()->json($result);
    }

    /**
     * API دریافت زمان باقیمانده لایسنس
     */
    public function remainingValidity(Request $request): JsonResponse
    {
        $request->validate([
            'license_key' => ['required', 'string'],
            'machine_fingerprint' => ['required', 'string'],
        ]);

        $result = $this->validator->getRemainingValidity(
            $request->license_key,
            $request->machine_fingerprint
        );

        return response()->json($result);
    }

    /**
     * API خروج دستگاه از لایسنس (Logout)
     * دستگاه از جدول license_devices حذف می‌شود
     */
    public function deactivateDevice(Request $request): JsonResponse
    {
        $request->validate([
            'license_key' => ['required', 'string'],
            'machine_fingerprint' => ['required', 'string'],
        ]);

        $result = $this->validator->deactivateDevice(
            $request->license_key,
            $request->machine_fingerprint
        );

        return response()->json($result);
    }
    // API دریافت کامل اطلاعات لایسنس
        public function licenseInfo(Request $request): JsonResponse
    {
        $request->validate([
            'license_key' => ['required', 'string'],
            'machine_fingerprint' => ['required', 'string'],
        ]);

        $result = $this->validator->licenseInfo(
            $request->license_key,
            $request->machine_fingerprint
        );

        return response()->json($result);
    }
}
