<?php

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return "ini adalah dashboard, nanti akan diganti dengan halaman dashboard yang sebenarnya";
    })->name('dashboard');
});
