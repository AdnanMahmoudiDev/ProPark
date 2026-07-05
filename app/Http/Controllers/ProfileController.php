<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * داشبرد کاربری
     */
    public function dashboard(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $activeSubscription = $user->subscriptions()
            ->where('status', 'active')
            ->where('expires_at', '>=', now())
            ->latest()
            ->first();

        $license = $activeSubscription?->license;

        return view('dashboard', compact(
            'activeSubscription',
            'license'
        ));
    }

    // نمایش فرم اطلاعات کاربری
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * بروزرسانی اطلاعات کاربری
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var User $user 
        $user = $request->user();

        $validated = $request->validated();
        $formType = $request->input('form_type');

        $user->fill($validated);

        if (array_key_exists('email', $validated) && $user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $status = match ($formType) {
            'phone_number' => 'phone-number-updated',
            'profile_information' => 'profile-information-updated',
            default => 'profile-updated',
        };

        return Redirect::route('profile.edit')
            ->with('status', $status);
    }

    // حذف حساب کاربری
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        /** @var User $user */
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
