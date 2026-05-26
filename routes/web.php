<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect('/dashboard');
});

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

Route::middleware('auth')->group(function () {

    Route::get('/daftar-buku', function () {

        $bukus = Buku::with('kategori')
            ->orderBy('id', 'asc')
            ->get();

        return view('anggota.daftar-buku', compact('bukus'));

    })->name('daftar.buku');

    Route::post('/pinjam/buku', [PeminjamanController::class, 'storeModal'])
        ->name('pinjam.buku');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman');

    Route::get('/denda', [\App\Http\Controllers\FineController::class, 'userIndex'])
        ->name('denda');

    // CRUD Buku
    Route::resource('bukus', BukuController::class);

    Route::resource('kategori', KategoriController::class);


});

Route::middleware('auth')->group(function () {

    Route::get('/kelola-peminjaman', [PeminjamanController::class, 'kelola'])
        ->name('kelola.peminjaman');

    Route::post('/peminjaman/{id}/setujui', [PeminjamanController::class, 'approve'])
        ->name('peminjaman.setujui');

    Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'reject'])
        ->name('peminjaman.tolak');

    Route::post('/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');

    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])
        ->name('peminjaman.destroy');

    Route::get('/kelola-denda', [\App\Http\Controllers\FineController::class, 'adminIndex'])
        ->name('kelola.denda');

});