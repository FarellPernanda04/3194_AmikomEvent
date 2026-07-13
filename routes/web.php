<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;

// User Area Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');


Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/admin/partners', [PartnerController::class, 'index']);
Route::post('/admin/partners', [PartnerController::class, 'store']);
Route::get('/admin/partners/create', [PartnerController::class, 'create']);
Route::get('/admin/partners/{id}/edit', [PartnerController::class, 'edit']);
Route::put('/admin/partners/{id}', [PartnerController::class, 'update']);
Route::delete('/admin/partners/{id}', [PartnerController::class, 'destroy']);

// Admin login/logout routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

// Admin Area Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', AdminEventController::class);
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::resource('categories', CategoryController::class);
});

// Webhook Midtrans (Backend-to-Backend)
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);


