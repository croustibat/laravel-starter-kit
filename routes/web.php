<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DigestController;
use App\Http\Controllers\PublicDigestController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing page (public)
Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

// Public digest page
Route::get('/d/{digest:slug}', [PublicDigestController::class, 'show'])->name('public.digest.show');

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Digests
    Route::resource('digests', DigestController::class);
    Route::post('/digests/{digest}/publish', [DigestController::class, 'publish'])->name('digests.publish');
    Route::post('/digests/{digest}/unpublish', [DigestController::class, 'unpublish'])->name('digests.unpublish');

    // Items
    Route::resource('items', \App\Http\Controllers\ItemController::class);

    // Tags
    Route::resource('tags', TagController::class)->except(['create', 'show', 'edit']);

    // Settings
    Route::get('/settings/account', function () {
        return view('pages/settings/account');
    })->name('account');

    Route::get('/profile', function () {
        return redirect()->route('account');
    })->name('profile');
    Route::get('/settings/notifications', function () {
        return view('pages/settings/notifications');
    })->name('notifications');
    Route::get('/settings/apps', function () {
        return view('pages/settings/apps');
    })->name('apps');
    Route::get('/settings/plans', function () {
        return view('pages/settings/plans');
    })->name('plans');
    Route::get('/settings/billing', function () {
        return view('pages/settings/billing');
    })->name('billing');
    Route::get('/settings/feedback', function () {
        return view('pages/settings/feedback');
    })->name('feedback');

    Route::fallback(function () {
        return view('pages/utility/404');
    });
});
