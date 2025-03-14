<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';



Route::middleware(['auth'])->group(function () {
    Route::resource('url', UrlController::class)->only(['create', 'store']);
    Route::get('url/view', [UrlController::class, 'index'])->name('url.index');
});


/* customize redirecting behavior. In case url key not found in database, redirect to target url */
Route::prefix(Config::get('short-url.prefix'))->group(function () {
    Route::get('/{shortURLKey}', [UrlController::class, 'handleRedirect']);
});