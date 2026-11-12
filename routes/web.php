<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RepairController;
use App\Http\Controllers\Auto\AboutController;
use App\Http\Controllers\Auto\BookingController;
use App\Http\Controllers\Auto\ContactController;
use App\Http\Controllers\Auto\HomeController;
use App\Http\Controllers\Auto\PageController;
use App\Http\Controllers\HomeController as AccountHomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::redirect('/', '/AutoStyle');

/*
|--------------------------------------------------------------------------
| Public website
|--------------------------------------------------------------------------
*/
Route::prefix('AutoStyle')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home_auto');

    Route::prefix('About')->group(function () {
        Route::get('News', [AboutController::class, 'index'])->name('vision');
        Route::get('History', [AboutController::class, 'history'])->name('history');
    });

    Route::prefix('Pages')->group(function () {
        Route::get('Offer', [PageController::class, 'index'])->name('offer');
        Route::get('Pricing/Plan', [PageController::class, 'plan'])->name('plan');
        Route::get('Partners', [PageController::class, 'partners'])->name('partners');
    });

    Route::get('Contacts/Detailed', [ContactController::class, 'index'])->name('contacts');

    // Public forms (rate limited)
    Route::post('Booking', [BookingController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('repair.store');
    Route::post('Contacts/Detailed', [ContactController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('contact.store');
});

/*
|--------------------------------------------------------------------------
| Account area / admin panel
|--------------------------------------------------------------------------
*/
Route::get('AdminPanel', [AccountHomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:Admin'])->prefix('Admin/Panel')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin-home');

    Route::resource('post', PostController::class)->except('show');
    Route::resource('client', ClientController::class)->except('show');
    Route::resource('members', MembersController::class)->parameters(['members' => 'member']);
    Route::resource('contact', AdminContactController::class)->only(['index', 'destroy']);
    Route::resource('repair', RepairController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
});
