<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GarageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;

Auth::routes();

// Home route (garage listing)
Route::get('/', [GarageController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    // Home route (after login)
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Service routes
    Route::prefix('services')->group(function () {
        Route::get('/create', [App\Http\Controllers\ServiceController::class, 'create'])->name('services.create');
        Route::get('/history', [App\Http\Controllers\ServiceController::class, 'history'])->name('services.history');
        Route::get('/track', [App\Http\Controllers\ServiceController::class, 'track'])->name('tracking.current');
    });
    
    // Payment routes
    Route::get('/payment-methods', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment.methods');
});

// Garage routes
Route::resource('garages', GarageController::class)->except(['index']);
Route::get('/garages', [GarageController::class, 'index'])->name('garages.index');

// Inquiry routes
Route::resource('inquiries', InquiryController::class)->only(['create', 'store', 'show']);

// Garage owner dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('my-garage')->group(function () {
        // Garage management
        Route::get('/', [GarageController::class, 'manage'])->name('garages.manage');
        
        // Inquiry management
        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
        Route::post('/inquiries/{inquiry}/accept', [InquiryController::class, 'accept'])->name('inquiries.accept');
        Route::post('/inquiries/{inquiry}/complete', [InquiryController::class, 'complete'])->name('inquiries.complete');
    });
});