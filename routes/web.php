<?php

use Illuminate\Support\Facades\Route;

// User Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\User\SubscriptionDetailsController;
use App\Http\Controllers\User\UserDeviceController;
use App\Http\Controllers\User\CartController; // کنترلر سبد خرید

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\LicenseCreationController;


// صفحه اصلی
Route::get('/', function () {
    return view('welcome');
})->name('home');

// فروشگاه
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

// مسیر های کاربر عادی 
Route::middleware(['auth', 'verified'])->group(function () {

    // داشبرد کاربری
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])
        ->name('dashboard');

    // اطلاعات بیشتر اشتراک
    Route::get('/subscription/details', [SubscriptionDetailsController::class, 'index'])
        ->name('subscription.details');

    // مدیریت دستگاه
    Route::get('/devices', [UserDeviceController::class, 'index'])
        ->name('user.devices.index');

    Route::delete('/devices/{licenseDevice}', [UserDeviceController::class, 'destroy'])
        ->name('user.devices.destroy');

    // مدیریت سبد خرید 
    Route::prefix('cart')->name('user.cart.')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('index');             // نمایش سبد خرید
        Route::post('/store', 'store')->name('store');       // افزودن محصول به سبد خرید
        Route::delete('/cancel', 'destroy')->name('cancel'); // لغو و خالی کردن سبد خرید
        Route::post('/checkout', 'checkout')->name('checkout'); // پرداخت و نهایی‌سازی خرید
    });

    // مدیریت پروفایل
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

// مسیر های مربوط به ادمین و داشبرد ادمین
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // داشبرد ادمین
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // مدیریت کاربران
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
            ->name('users.update-role');

        // مدیریت اشتراک ها
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])
            ->name('subscriptions.index');

        Route::patch('/subscriptions/{subscription}/status', [SubscriptionController::class, 'updateStatus'])
            ->name('subscriptions.update-status');

        Route::post('/subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew'])
            ->name('subscriptions.renew');

        Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])
            ->name('subscriptions.destroy');

        // مدیریت فروشگاه
        Route::get('/store', [StoreController::class, 'index'])
            ->name('store.index');

        Route::put('/store/prices/{price}', [StoreController::class, 'updatePrice'])
            ->name('store.prices.update');

        Route::put('/store/prices', [StoreController::class, 'bulkUpdate'])
            ->name('store.prices.bulk-update');

        // ساخت مجوز 
        Route::get('/new-license', [LicenseCreationController::class, 'index'])
            ->name('licenses.create');

        Route::get('/new-license/{user}', [LicenseCreationController::class, 'create'])
            ->name('new-licenses.create');

        Route::post('/new-license/{user}', [LicenseCreationController::class, 'store'])
            ->name('new-licenses.store');
    });

require __DIR__ . '/auth.php';
