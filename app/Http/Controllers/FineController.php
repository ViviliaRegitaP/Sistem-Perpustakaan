<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        ->where('status', 'Dipinjam')
        ->latest()
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
        ->where('status', 'Dipinjam')
        ->latest()
        ->get();

        return view(
            'anggota.denda',
            compact('peminjamans')
        );
    }
}