<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    //نمایش صفحه ی ثبت نام
 
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * هندل کردن درخواست ثبت نام
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => [
                'required',
                'digits:11',
                'regex:/^09[0-9]{9}$/',
                'unique:users,phone_number',
            ],
            'password' => [
                'required', 
                'confirmed', 
                Rules\Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ], [
            // پیام‌های اعتبارسنجی نام و ایمیل
            'name.required' => 'وارد کردن نام و نام خانوادگی الزامی است.',
            'email.required' => 'آدرس ایمیل الزامی است.',
            'email.email' => 'لطفاً یک آدرس ایمیل معتبر وارد کنید.',
            'email.unique' => 'این ایمیل قبلاً در سیستم ثبت شده است.',
            
            // پیام‌های اعتبارسنجی شماره موبایل
            'phone_number.required' => 'وارد کردن شماره موبایل الزامی است.',
            'phone_number.digits' => 'شماره موبایل باید دقیقاً 11 رقم باشد.',
            'phone_number.regex' => 'فرمت شماره موبایل نامعتبر است (مثال: 09123456789).',
            'phone_number.unique' => 'این شماره موبایل قبلاً ثبت شده است.',

            // پیام‌های اعتبارسنجی رمز عبور 
            'password.required' => 'وارد کردن رمز عبور الزامی است.',
            'password.confirmed' => 'تکرار رمز عبور با رمز عبور وارد شده مطابقت ندارد.',
            'password.min' => 'رمز عبور باید حداقل 8 کاراکتر باشد.',
            'password.letters' => 'رمز عبور باید حداقل شامل یک حرف باشد.',
            'password.mixed' => 'رمز عبور باید شامل هر دو نوع حروف کوچک و بزرگ باشد.',
            'password.numbers' => 'رمز عبور باید حداقل شامل یک عدد باشد.',
            'password.symbols' => 'رمز عبور باید شامل حداقل یک کاراکتر خاص (مانند @، #، $، % و...) باشد.',
            'password.uncompromised' => 'این رمز عبور در پایگاه داده‌های لو رفته جهانی پیدا شده است؛ برای امنیت بیشتر رمز دیگری انتخاب کنید.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => 'user', 
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
