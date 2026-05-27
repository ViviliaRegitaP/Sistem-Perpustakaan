<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\FineController;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| REDIRECT AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $totalBuku = Buku::count();

    $totalPeminjaman = Peminjaman::count();

    $totalUser = User::count();

    return view('anggota.dashboard', compact(
        'totalBuku',
        'totalPeminjaman',
        'totalUser'
    ));

})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| ROUTE USER / ANGGOTA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DAFTAR BUKU (ANGGOTA)
    |--------------------------------------------------------------------------
    */

    Route::get('/daftar-buku', function () {

        $bukus = Buku::with('kategori')
            ->orderBy('id', 'asc')
            ->get();

        return view('anggota.daftar-buku', compact('bukus'));

    })->name('daftar.buku');

    /*
    |--------------------------------------------------------------------------
    | PINJAM BUKU
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/pinjam/buku',
        [PeminjamanController::class, 'storeModal']
    )->name('pinjam.buku');

    /*
    |--------------------------------------------------------------------------
    | PEMINJAMAN USER
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/peminjaman',
        [PeminjamanController::class, 'index']
    )->name('peminjaman');

    /*
    |--------------------------------------------------------------------------
    | DENDA USER
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/denda',
        [FineController::class, 'userIndex']
    )->name('denda');

});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CRUD BUKU (ADMIN) — bukus.index mengarah ke view admin
    |--------------------------------------------------------------------------
    */

    Route::resource('bukus', BukuController::class);

    /*
    |--------------------------------------------------------------------------
    | CRUD KATEGORI
    |--------------------------------------------------------------------------
    */

    Route::resource('kategori', KategoriController::class);

    /*
    |--------------------------------------------------------------------------
    | KELOLA PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/kelola-peminjaman',
        [PeminjamanController::class, 'kelola']
    )->name('kelola.peminjaman');

    Route::post(
        '/peminjaman/{id}/setujui',
        [PeminjamanController::class, 'approve']
    )->name('peminjaman.setujui');

    Route::post(
        '/peminjaman/{id}/tolak',
        [PeminjamanController::class, 'reject']
    )->name('peminjaman.tolak');

    Route::post(
        '/kembalikan/{id}',
        [PeminjamanController::class, 'kembalikan']
    )->name('peminjaman.kembalikan');

    Route::delete(
        '/peminjaman/{id}',
        [PeminjamanController::class, 'destroy']
    )->name('peminjaman.destroy');

    /*
    |--------------------------------------------------------------------------
    | KELOLA DENDA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/kelola-denda',
        [FineController::class, 'adminIndex']
    )->name('kelola.denda');

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS DENDA
    |--------------------------------------------------------------------------
    */

    Route::put(
        '/denda/{fines_id}',
        [FineController::class, 'update']
    )->name('denda.update');

});