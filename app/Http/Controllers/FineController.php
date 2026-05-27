<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    // =========================
    // ADMIN
    // =========================

    public function adminIndex()
    {
        $peminjamans = Peminjaman::with([
            'user',
            'buku'
        ])
            ->whereDate('tanggal_kembali', '<', now())
            ->get();

        return view(
            'admin.kelola-denda',
            compact('peminjamans')
        );
    }

    // =========================
    // USER
    // =========================

    public function userIndex()
    {
        $peminjamans = Peminjaman::with([
            'buku'
        ])
            ->where('user_id', Auth::id())
            ->whereDate('tanggal_kembali', '<', now())
            ->get();

        return view(
            'anggota.denda',
            compact('peminjamans')
        );
    }
}

