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
     * API اعتبارسنجی و فعال‌سازی لایسنس (بار اول در برنامه پایتونی)
     */
    public function validateLicense(ValidateLicenseRequest $request): JsonResponse
    {
        $result = $this->validator->validate(
            $request->input('license_key'),
            $request->input('machine_fingerprint')
        );

        return response()->json($result);
    }

    /**
     * API دریافت وضعیت پشتیبانی لایسنس
     * (آیا پشتیبانی فعال دارد؟ تاریخ انقضای آن؟ در صورت انقضا، پاسخ منقضی برمی‌گردد)
     */
    public function supportStatus(Request $request): JsonResponse
    {
        $request->validate([
            'license_key'         => ['required', 'string'],
            'machine_fingerprint' => ['required', 'string'],
        ]);

        $result = $this->validator->getSupportStatus(
            $request->input('license_key'),
            $request->input('machine_fingerprint')
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
            'license_key'         => ['required', 'string'],
            'machine_fingerprint' => ['required', 'string'],
        ]);

        $result = $this->validator->deactivateDevice(
            $request->input('license_key'),
            $request->input('machine_fingerprint')
        );

        return response()->json($result);
    }

    /**
     * API دریافت کامل اطلاعات لایسنس (شامل بلوک اطلاعات پشتیبانی)
     */
    public function licenseInfo(Request $request): JsonResponse
    {
        $request->validate([
            'license_key'         => ['required', 'string'],
            'machine_fingerprint' => ['required', 'string'],
        ]);

        $result = $this->validator->licenseInfo(
            $request->input('license_key'),
            $request->input('machine_fingerprint')
        );

        return response()->json($result);
    }
}
