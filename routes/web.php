<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;

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

    // RELASI KATEGORI
    $recent = \App\Models\Buku::with('kategori')
                ->latest()
                ->take(5)
                ->get();

    return view('anggota.dashboard', compact(
        'totalBuku',
        'totalStok',
        'recent'
    ));

})->middleware('auth')->name('dashboard');


// ======================
// DAFTAR BUKU ANGGOTA
// ======================

Route::get('/daftar-buku', function () {

    $query = Buku::with('kategori');

    // SEARCH
    if(request('search')){

        $query->where('judul', 'like', '%' . request('search') . '%');

    }

    // FILTER KATEGORI
    if(request('kategori')){

        $query->whereHas('kategori', function($q){

            $q->where('id', request('kategori'));

        });

    }

    $bukus = $query->latest()->get();

    $kategoris = \App\Models\Kategori::all();

    return view('anggota.daftar-buku', compact(
        'bukus',
        'kategoris'
    ));

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

    Route::resource('kategori', KategoriController::class);

});


// ======================
// PINJAM BUKU
// ======================

Route::get('/pinjam', function () {

    return view('anggota.pinjam');

})->middleware('auth');


// ======================
// PEMINJAMAN SAYA
// ======================

Route::get('/peminjaman', [PeminjamanController::class, 'index'])
    ->middleware('auth');


// ======================
// PROSES PINJAM
// ======================

Route::post('/pinjam/{id}', [PeminjamanController::class, 'store'])
    ->middleware('auth');


// ======================
// KELOLA PEMINJAMAN ADMIN
// ======================

Route::get('/kelola-peminjaman', [PeminjamanController::class, 'kelola'])
    ->middleware('auth');


// ======================
// KEMBALIKAN BUKU
// ======================

Route::post('/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])
    ->middleware('auth');


require __DIR__.'/auth.php';