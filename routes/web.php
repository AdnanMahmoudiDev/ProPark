<?php

use Illuminate\Support\Facades\Route;

// User Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController; // کنترلر عمومی وبلاگ
use App\Http\Controllers\LocaleController; // کنترلر تغییر زبان
use App\Http\Controllers\User\SubscriptionDetailsController;
use App\Http\Controllers\User\UserDeviceController;
use App\Http\Controllers\User\CartController; 



// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\LicenseCreationController;
use App\Http\Controllers\Admin\DatabaseBackupController;
use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\Admin\PostController; 
use App\Http\Controllers\Admin\MonitoringController;

// صفحه اصلی
Route::get('/', function () {
    return view('welcome');
})->name('home');

// تغییر زبان سیستم
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// فروشگاه
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

// وبلاگ عمومی
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// درباره ما
Route::get('/about', [PageController::class, 'about'])->name('about');
// پشتیبانی
Route::get('/support', [PageController::class, 'support'])->name('support');
// مسیر صفحه شرایط و قوانین
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
// مسیر صفحه حریم خصوصی
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

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
        Route::get('/', 'index')->name('index');             
        Route::post('/store', 'store')->name('store');       
        Route::delete('/cancel', 'destroy')->name('cancel'); 
        Route::post('/checkout', 'checkout')->name('checkout'); 
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

        Route::patch('/subscriptions/{subscription}/plan', [SubscriptionController::class, 'updatePlan'])
            ->name('subscriptions.update-plan');
        
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

        // مدیریت دیتابیس (بک‌آپ و ریستور)
        Route::prefix('database')->name('database.')->group(function () {
            Route::get('/', [DatabaseBackupController::class, 'index'])->name('index');
            Route::get('/export', [DatabaseBackupController::class, 'export'])->name('export');
            Route::post('/import', [DatabaseBackupController::class, 'import'])->name('import');
        });
        
        //مانیتورینگ سایت و سرور 
        Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

        // مدیریت دسته‌بندی‌های وبلاگ (لیست، ایجاد، ویرایش، بروزرسانی و حذف)
        Route::resource('categories', CategoryController::class)->except(['create', 'show']);

        // مدیریت مقالات وبلاگ
        Route::resource('posts', PostController::class);
        Route::post('posts/upload-image', [PostController::class, 'uploadContentImage'])->name('posts.upload-image');
    });

require __DIR__ . '/auth.php';
