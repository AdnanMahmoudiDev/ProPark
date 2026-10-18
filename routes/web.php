<?php

use Illuminate\Support\Facades\Route;

// User Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\User\SubscriptionDetailsController;
use App\Http\Controllers\User\UserDeviceController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\InvoiceController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\LicenseCreationController;
use App\Http\Controllers\Admin\DatabaseBackupController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\SupportPackagePriceController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;

// صفحه اصلی
Route::get('/', function () {
    return view('welcome');
})->name('home');

// تغییر زبان سیستم
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->name('locale.switch');

// فروشگاه
Route::get('/shop', [ShopController::class, 'index'])
    ->name('shop');

// وبلاگ عمومی
Route::get('/blog', [BlogController::class, 'index'])
    ->name('blog.index');

Route::get('/blog/{slug}', [BlogController::class, 'show'])
    ->name('blog.show');

// درباره ما
Route::get('/about', [PageController::class, 'about'])
    ->name('about');

// پشتیبانی
Route::get('/support', [PageController::class, 'support'])
    ->name('support');

// شرایط و قوانین
Route::get('/terms', [PageController::class, 'terms'])
    ->name('terms');

// حریم خصوصی
Route::get('/privacy', [PageController::class, 'privacy'])
    ->name('privacy');

// کال‌بک بازگشت از درگاه پرداخت (پذیرش GET و POST و خارج از احراز هویت برای جلوگیری از خطای سشن شاپرک)
Route::match(['get', 'post'], '/payment/callback/{order}', [PaymentController::class, 'callback'])
    ->name('payment.callback');

// مسیرهای کاربر عادی
Route::middleware(['auth', 'verified'])->group(function () {

    // داشبورد کاربری
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])
        ->name('dashboard');

    // فاکتورها و سوابق خرید
    Route::get('/invoices', [InvoiceController::class, 'index'])
        ->name('user.invoices.index');

    Route::get('/invoices/{order}', [InvoiceController::class, 'show'])
        ->name('user.invoices.show');

    // اطلاعات بیشتر اشتراک
    Route::get('/subscription/details', [SubscriptionDetailsController::class, 'index'])
        ->name('subscription.details');

    // مدیریت دستگاه
    Route::get('/devices', [UserDeviceController::class, 'index'])
        ->name('user.devices.index');

    Route::delete('/devices/{licenseDevice}', [UserDeviceController::class, 'destroy'])
        ->name('user.devices.destroy');

    // مدیریت سبد خرید
    Route::prefix('cart')
        ->name('user.cart.')
        ->controller(CartController::class)
        ->group(function () {
            Route::get('/', 'index')
                ->name('index');

            Route::post('/store', 'store')
                ->name('store');

            Route::delete('/cancel', 'destroy')
                ->name('cancel');

            Route::post('/checkout', 'checkout')
                ->name('checkout');
        });

    // شروع فرآیند پرداخت
    Route::prefix('payment')
        ->name('payment.')
        ->controller(PaymentController::class)
        ->group(function () {
            Route::post('/checkout', 'checkout')
                ->name('checkout');
        });

    // مدیریت پروفایل
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')
            ->name('profile.edit');

        Route::patch('/profile', 'update')
            ->name('profile.update');

        Route::delete('/profile', 'destroy')
            ->name('profile.destroy');
    });
});

// مسیرهای ادمین
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // داشبورد ادمین
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // مدیریت کاربران
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
            ->name('users.update-role');

        // امور مالی و مدیریت فاکتورها
        Route::prefix('invoices')
            ->name('invoices.')
            ->controller(AdminInvoiceController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/analytics', 'analytics')->name('analytics');
                Route::get('/{order}', 'show')->name('show');
            });

        // مدیریت اشتراک‌ها
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

        // مدیریت پشتیبانی‌ها (جدید)
        Route::prefix('supports')
            ->name('supports.')
            ->controller(SupportController::class)
            ->group(function () {
                Route::get('/', 'index')
                    ->name('index');

                Route::patch('/{support}/status', 'updateStatus')
                    ->name('update-status');

                Route::post('/{support}/renew', 'renew')
                    ->name('renew');

                Route::delete('/{support}', 'destroy')
                    ->name('destroy');
            });

        // مدیریت فروشگاه
        Route::get('/store', [StoreController::class, 'index'])
            ->name('store.index');

        Route::put('/store/prices/{price}', [StoreController::class, 'updatePrice'])
            ->name('store.prices.update');

        Route::put('/store/prices', [StoreController::class, 'bulkUpdate'])
            ->name('store.prices.bulk-update');

        // مدیریت قیمت بسته‌های پشتیبانی
        Route::prefix('store/support-prices')
            ->name('store.support-prices.')
            ->controller(SupportPackagePriceController::class)
            ->group(function () {
                Route::get('/', 'index')
                    ->name('index');

                Route::put('/bulk-update', 'bulkUpdate')
                    ->name('bulk-update');
            });

        // ساخت مجوز
        Route::get('/new-license', [LicenseCreationController::class, 'index'])
            ->name('licenses.create');

        Route::get('/new-license/{user}', [LicenseCreationController::class, 'create'])
            ->name('new-licenses.create');

        Route::post('/new-license/{user}', [LicenseCreationController::class, 'store'])
            ->name('new-licenses.store');

        // مدیریت دیتابیس
        Route::prefix('database')
            ->name('database.')
            ->group(function () {
                Route::get('/', [DatabaseBackupController::class, 'index'])
                    ->name('index');

                Route::get('/export', [DatabaseBackupController::class, 'export'])
                    ->name('export');

                Route::post('/import', [DatabaseBackupController::class, 'import'])
                    ->name('import');
            });

        // مانیتورینگ سایت و سرور
        Route::get('/monitoring', [MonitoringController::class, 'index'])
            ->name('monitoring.index');

        // مدیریت دسته‌بندی‌های وبلاگ
        Route::resource('categories', CategoryController::class)
            ->except(['create', 'show']);

        // مدیریت مقالات وبلاگ
        Route::resource('posts', PostController::class);

        Route::post(
            'posts/upload-image',
            [PostController::class, 'uploadContentImage']
        )->name('posts.upload-image');
    });

require __DIR__ . '/auth.php';
