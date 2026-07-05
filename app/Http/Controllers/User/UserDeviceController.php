<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LicenseDevice;
use Illuminate\Http\Request;

class UserDeviceController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $devices = LicenseDevice::whereHas('license.subscription', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('license')
            ->latest()
            ->get();

        return view('user.devices.index', compact('devices'));
    }

    public function destroy(Request $request, LicenseDevice $licenseDevice)
    {
        $userId = $request->user()->id;

        if (
            !$licenseDevice->license ||
            !$licenseDevice->license->subscription ||
            $licenseDevice->license->subscription->user_id !== $userId
        ) {
            abort(403, 'شما اجازه حذف این دستگاه را ندارید.');
        }

        $licenseDevice->delete();

        return redirect()
            ->route('user.devices.index')
            ->with('success', 'دستگاه با موفقیت حذف شد.');
    }
}
