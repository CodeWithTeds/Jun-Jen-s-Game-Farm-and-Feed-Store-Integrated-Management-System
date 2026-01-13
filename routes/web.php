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
use App\Http\Controllers\FeedUsageController;
use App\Http\Controllers\ScheduleController;

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
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('game-fowls', GameFowlController::class);
    Route::resource('breedings', BreedingController::class);
    Route::resource('medical-records', MedicalRecordController::class);
    Route::resource('egg-collections', EggCollectionController::class);
    Route::resource('hatchery-records', HatcheryRecordController::class);
    Route::resource('chick-rearings', ChickRearingController::class);
    Route::resource('feeds', FeedController::class);
    Route::resource('feed-usages', FeedUsageController::class)->only(['index', 'create', 'store']);
});

require __DIR__.'/settings.php';
