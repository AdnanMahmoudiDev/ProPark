<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DatabaseBackupService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Exception;

class DatabaseBackupController extends Controller
{
    protected DatabaseBackupService $backupService;

    public function __construct(DatabaseBackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    /**
     * نمایش صفحه مدیریت بک‌آپ دیتابیس
     */
    public function index()
    {
        $stats = $this->backupService->getStats();

        return view('admin.database.index', compact('stats'));
    }

    /**
     * دانلود فایل خروجی بک‌آپ دیتابیس
     */
    public function export(): StreamedResponse
    {
        $fileName = 'backup-' . config('database.connections.mysql.database', 'avapark') . '-' . now()->format('Y-m-d_H-i-s') . '.sql';

        return response()->streamDownload(function () {
            echo $this->backupService->export();
        }, $fileName, [
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * دریافت فایل و بازگردانی دیتابیس
     */
    public function import(Request $request)
    {
        $request->validate([
            'backup_file' => ['required', 'file', 'mimes:txt,sql', 'max:51200'], // حداکثر 50 مگابایت
        ], [
            'backup_file.required' => 'لطفاً فایل بک‌آپ دیتابیس را انتخاب کنید.',
            'backup_file.mimes' => 'فرمت فایل انتخابی باید sql یا txt باشد.',
            'backup_file.max' => 'حجم فایل بک‌آپ نمی‌تواند بیشتر از 50 مگابایت باشد.',
        ]);

        try {
            $fileContent = file_get_contents($request->file('backup_file')->getRealPath());
            $this->backupService->import($fileContent);

            return redirect()->route('admin.database.index')->with('success', 'دیتابیس با موفقیت بازگردانی (Restore) شد.');
        } catch (Exception $e) {
            return redirect()->route('admin.database.index')->with('error', 'خطا در بازگردانی دیتابیس: ' . $e->getMessage());
        }
    }
}
