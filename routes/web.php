<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;

// User Area Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/admin/partners', [PartnerController::class, 'index']);
Route::post('/admin/partners', [PartnerController::class, 'store']);
Route::get('/admin/partners/create', [PartnerController::class, 'create']);
Route::get('/admin/partners/{id}/edit', [PartnerController::class, 'edit']);
Route::put('/admin/partners/{id}', [PartnerController::class, 'update']);
Route::delete('/admin/partners/{id}', [PartnerController::class, 'destroy']);

// Admin Area Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (public access)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes (require auth + admin role)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', AdminEventController::class);
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::resource('categories', CategoryController::class);
    });
});

