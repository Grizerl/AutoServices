<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\CarInquiryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RepairController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Auto\AboutController;
use App\Http\Controllers\Auto\BookingController;
use App\Http\Controllers\Auto\CarController;
use App\Http\Controllers\Auto\ContactController;
use App\Http\Controllers\Auto\HomeController;
use App\Http\Controllers\Auto\PageController;
use App\Http\Controllers\Auto\SubscriptionController;
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
Route::get('/', [HomeController::class, 'index'])->name('home_auto');

Route::prefix('About')->group(function () {
    Route::get('News', [AboutController::class, 'index'])->name('vision');
    Route::get('History', [AboutController::class, 'history'])->name('history');
});

Route::prefix('Pages')->group(function () {
    // Cars for sale
    Route::get('Offer', [CarController::class, 'index'])->name('offer');
    Route::get('Offer/{car}', [CarController::class, 'show'])->whereNumber('car')->name('car.show');
    Route::post('Offer/{car}/inquire', [CarController::class, 'inquire'])
        ->whereNumber('car')->middleware('throttle:10,1')->name('car.inquire');

    // Subscription plans
    Route::get('Pricing/Plan', [SubscriptionController::class, 'plans'])->name('plan');
    Route::get('Pricing/Plan/{plan}/subscribe', [SubscriptionController::class, 'checkout'])->name('plan.checkout');
    Route::post('Pricing/Plan/{plan}/subscribe', [SubscriptionController::class, 'store'])
        ->middleware('throttle:10,1')->name('plan.subscribe');
    Route::get('Pricing/Thanks/{reference}', [SubscriptionController::class, 'thanks'])->name('plan.thanks');

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

/*
|--------------------------------------------------------------------------
| Account area / admin panel
|--------------------------------------------------------------------------
*/
Route::get('AdminPanel', [AccountHomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:Admin'])->prefix('control')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin-home');

    Route::resource('post', PostController::class)->except('show');
    Route::resource('client', ClientController::class)->except('show');
    Route::resource('members', MembersController::class)->parameters(['members' => 'member']);
    Route::resource('contact', AdminContactController::class)->only(['index', 'destroy']);
    Route::resource('repair', RepairController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

    // Cars for sale and the requests they receive
    Route::resource('cars', AdminCarController::class)->parameters(['cars' => 'car'])->except('show');
    Route::resource('car-inquiries', CarInquiryController::class)->only(['index', 'update', 'destroy']);

    // Subscription plans and customer subscriptions
    Route::resource('plans', PlanController::class)->parameters(['plans' => 'plan'])->except('show');
    Route::resource('subscriptions', AdminSubscriptionController::class)->only(['index', 'show', 'update', 'destroy']);
});
