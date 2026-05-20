<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;

Route::get('/', function () {

    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect('/login');

});


// ======================
// DASHBOARD
// ======================

Route::get('/dashboard', function () {

    // ADMIN
    if (Auth::user()->email == 'admin@perpus.com') {
        return view('admin.dashboard');
    }

    // ANGGOTA
    $totalBuku = \App\Models\Buku::count();
    $totalStok = \App\Models\Buku::sum('stok');
    $recent = \App\Models\Buku::latest()->take(5)->get();

    return view('anggota.dashboard', compact('totalBuku', 'totalStok', 'recent'));

})->middleware('auth')->name('dashboard');


// ======================
// DAFTAR BUKU ANGGOTA
// ======================

Route::get('/daftar-buku', function () {

    $bukus = Buku::latest()->get();

    return view('anggota.daftar-buku', compact('bukus'));

})->middleware('auth');


// ======================
// PROFILE
// ======================

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// ======================
// ADMIN ONLY
// ======================

Route::middleware(['auth'])->group(function () {

    Route::resource('bukus', BukuController::class);

});

require __DIR__.'/auth.php';