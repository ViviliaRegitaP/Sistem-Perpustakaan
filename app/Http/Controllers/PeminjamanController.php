<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // ======================
    // PEMINJAMAN SAYA
    // ======================

    public function index()
    {
        $peminjamans = Peminjaman::with('buku')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('anggota.peminjaman', compact('peminjamans'));
    }


    // ======================
    // PROSES PINJAM BUKU
    // ======================

    public function store($id)
    {
        $buku = Buku::findOrFail($id);

        // CEK STOK
        if ($buku->stok <= 0) {

            return redirect('/daftar-buku')
                ->with('error', 'Stok buku habis.');
        }

        // SIMPAN PEMINJAMAN
        Peminjaman::create([

            'user_id' => Auth::id(),

            'buku_id' => $buku->id,

            'tanggal_pinjam' => now(),

            'tanggal_kembali' => now()->addDays(7),

            'status' => 'Dipinjam',

        ]);

        // KURANGI STOK
        $buku->stok -= 1;

        $buku->save();

        return redirect('/daftar-buku')
            ->with('success', 'Buku berhasil dipinjam!');
    }


    // ======================
    // KELOLA PEMINJAMAN ADMIN
    // ======================

    public function kelola()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
                        ->latest()
                        ->get();

        return view('admin.kelola-peminjaman', compact('peminjamans'));
    }


    // ======================
    // KEMBALIKAN BUKU
    // ======================

    public function kembalikan($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // UBAH STATUS
        $pinjam->status = 'Dikembalikan';

        $pinjam->save();

        // TAMBAH STOK
        $buku = Buku::findOrFail($pinjam->buku_id);

        $buku->stok += 1;

        $buku->save();

        return redirect('/kelola-peminjaman')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}