<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerNotificationController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SeoController;

/*
|--------------------------------------------------------------------------
| Locale Switch
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->where('locale', 'fr|en|ar')->name('lang.switch');
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/menu', [PublicController::class, 'menu'])->name('menu');
Route::get('/delivery', [PublicController::class, 'delivery'])->name('delivery');
Route::post('/delivery', [PublicController::class, 'storeDeliveryOrder'])->name('delivery.store');
Route::get('/reservations', [PublicController::class, 'reservations'])->name('reservations');
Route::post('/reservations', [PublicController::class, 'storeReservation'])->name('reservations.store');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| SEO: Robots & Sitemap
|--------------------------------------------------------------------------
*/
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');

/*
|--------------------------------------------------------------------------
| Guest Order Tracking
|--------------------------------------------------------------------------
*/
Route::get('/track-order', [CustomerOrderController::class, 'trackForm'])->name('track.order');
Route::post('/track-order', [CustomerOrderController::class, 'trackLookup']);

/*
|--------------------------------------------------------------------------
| Customer Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('customer.login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->middleware('throttle:5,1');
});

Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

Route::post('/login/google', [GoogleAuthController::class, 'login'])->middleware('throttle:20,1')->name('customer.login.google');

/*
|--------------------------------------------------------------------------
| Password Reset Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'reset'])->middleware('throttle:5,1')->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Customer Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('customer.auth')->name('customer.')->prefix('account')->group(function () {
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('order');
    Route::get('/notifications', [CustomerNotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/{notification}/open', [CustomerNotificationController::class, 'open'])->name('notifications.open');
    Route::post('/notifications/read-all', [CustomerNotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

/*
|--------------------------------------------------------------------------
| Payment Callbacks
|--------------------------------------------------------------------------
*/
Route::get('/payment/result/{order}', [PaymentController::class, 'result'])->name('payment.result');
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->middleware('throttle:5,1');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::patch('/orders/{order}', [AdminController::class, 'updateOrderStatus'])->name('orders.update');
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');
    Route::patch('/reservations/{reservation}', [AdminController::class, 'updateReservationStatus'])->name('reservations.update');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::post('/analytics/dine-in', [AnalyticsController::class, 'storeDineIn'])->name('analytics.dine-in');
    Route::get('/menu', [AdminController::class, 'menu'])->name('menu');
    Route::post('/menu', [AdminController::class, 'storeMenuItem'])->name('menu.store');
    Route::put('/menu/{menuItem}', [AdminController::class, 'updateMenuItem'])->name('menu.update');
    Route::delete('/menu/{menuItem}', [AdminController::class, 'destroyMenuItem'])->name('menu.destroy');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
});
