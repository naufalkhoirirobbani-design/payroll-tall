<?php

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Pastikan semua Livewire component di-import
use App\Livewire\Master\DepartemenIndex;
use App\Livewire\Master\JabatanIndex;
use App\Livewire\Karyawan\KaryawanIndex;
use App\Livewire\Transaksi\PenggajianIndex;

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route ke Livewire component
    Route::get('/departemen', App\Livewire\Master\DepartemenIndex::class)->name('departemen.index');
    Route::get('/jabatan', App\Livewire\Master\JabatanIndex::class)->name('jabatan.index');
    Route::get('/karyawan', App\Livewire\Karyawan\KaryawanIndex::class)->name('karyawan.index');
    Route::get('/penggajian', App\Livewire\Transaksi\PenggajianIndex::class)->name('penggajian.index');
    Route::get('/penggajian/cetak/{id}', App\Livewire\Transaksi\CetakSlip::class)->name('penggajian.cetak-slip');

    // Logout route
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
