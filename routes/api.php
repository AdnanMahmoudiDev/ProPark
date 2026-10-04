<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LicenseController;

// وارد کردن لایسنس برای بار اول در برنامه پایتونی
Route::post('/license/validate', [LicenseController::class, 'validateLicense']);

// دریافت وضعیت پشتیبانی لایسنس (فعال/منقضی + تاریخ انقضا) برای اپ پایتونی
Route::post('/license/support-status', [LicenseController::class, 'supportStatus']);

// حذف یک دستگاه فعال روی لایسنس
Route::post('/license/deactivate-device', [LicenseController::class, 'deactivateDevice']);

// دریافت اطلاعات لایسنس (شامل بلوک اطلاعات پشتیبانی)
Route::post('/license/info', [LicenseController::class, 'licenseInfo']);
