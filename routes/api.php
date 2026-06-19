<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LicenseController;


// وارد کردن لایسنس برای بار اول در برنامه پایتونی
Route::post('/license/validate', [LicenseController::class, 'validateLicense']);

// چک کردن تاریخ اعتبار لایسنس برای بروزرسانی اعتبار مانده در اپ پایتونی
Route::post('/license/remaining-validity', [LicenseController::class, 'remainingValidity']);
// حذف یک دستگاه فعال روی لایسنس
Route::post('/license/deactivate-device', [LicenseController::class, 'deactivateDevice']);
// دریافت اطلاعات یک لایسنس
Route::post('/license/info', [LicenseController::class, 'licenseInfo']);
