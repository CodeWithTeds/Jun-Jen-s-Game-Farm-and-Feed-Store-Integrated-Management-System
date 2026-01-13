<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameFowlController;
use App\Http\Controllers\BreedingController;
use App\Http\Controllers\MedicalRecordController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'verified'])->prefix('staff')->name('staff.')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('game-fowls', GameFowlController::class);
    Route::resource('breedings', BreedingController::class);
    Route::resource('medical-records', MedicalRecordController::class);
    Route::resource('egg-collections', \App\Http\Controllers\EggCollectionController::class);
    Route::resource('hatchery-records', \App\Http\Controllers\HatcheryRecordController::class);
});

require __DIR__.'/settings.php';
