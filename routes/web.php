<?php

use App\Http\Controllers\UrlController;
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

Route::get('/test', function(){return 'test';});

