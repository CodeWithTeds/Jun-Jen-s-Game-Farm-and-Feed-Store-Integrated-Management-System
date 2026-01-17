<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameFowlController;
use App\Http\Controllers\BreedingController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\EggCollectionController;
use App\Http\Controllers\HatcheryRecordController;
use App\Http\Controllers\ChickRearingController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\FeedUsageController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FarmRecordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Livewire\Staff\Dashboard\Dashboard;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('schedules', ScheduleController::class);
});

Route::middleware(['auth', 'verified'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::resource('game-fowls', GameFowlController::class);
    Route::resource('breedings', BreedingController::class);
    Route::resource('medical-records', MedicalRecordController::class);
    Route::resource('egg-collections', EggCollectionController::class);
    Route::resource('hatchery-records', HatcheryRecordController::class);
    Route::resource('chick-rearings', ChickRearingController::class);
    Route::resource('products', FeedController::class);
    Route::resource('feed-usages', FeedUsageController::class)->only(['index', 'create', 'store']);
    Route::resource('farm-records', FarmRecordController::class);
    Route::get('orders', \App\Livewire\Staff\Orders\OrderList::class)->name('orders.index');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', FeedController::class);
    Route::patch('products/{feed}/toggle-display', [FeedController::class, 'toggleDisplay'])->name('products.toggle-display');
    Route::resource('suppliers', SupplierController::class);
    Route::get('sales-transactions', \App\Livewire\Staff\Sales\SalesTransactionList::class)->name('sales-transactions.index');
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
});

Route::middleware(['auth', 'verified'])->prefix('customer')->name('customer.')->group(function () {
    Route::resource('products', FeedController::class)->only(['index', 'show']);
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/settings.php';
