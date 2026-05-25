<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    // ======================
    // ADMIN
    // ======================

    public function adminIndex()
    {
        $fines = Fine::with([
            'peminjaman.user',
            'peminjaman.buku'
        ])->latest()->get();

        return view('admin.kelola-denda', compact('fines'));
    }

    public function update($fines_id)
    {
            $fine = Fine::where('fines_id', $fines_id)->firstOrFail();

        $bayar = request('bayar');

        if (!is_numeric($bayar) || $bayar <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nominal tidak valid'
            ], 422);
        }

        if ($bayar % 1000 !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Harus kelipatan 1000'
            ], 422);
        }

        if ($bayar > $fine->sisa_denda) {
            $bayar = $fine->sisa_denda;
        }

        $fine->dibayar = $fine->dibayar + $bayar;

        $fine->dibayar = min($fine->dibayar, $fine->jumlah_denda);

        $fine->sisa_denda = max(0, $fine->jumlah_denda - $fine->dibayar);

        $fine->status = match (true) {
            $fine->sisa_denda === 0 => 'PAID',
            $fine->dibayar > 0 => 'PARTIALLY_PAID',
            default => 'UNPAID',
        };

        $fine->save();

        return response()->json([
            'status' => 'success',
            'fines_id' => $fine->fines_id,
            'dibayar' => number_format($fine->dibayar),
            'sisa_denda' => number_format($fine->sisa_denda),
            'status_label' => $fine->status_label,
            'status_color' => $fine->status_color,
        ]);
    }

    // ======================
    // USER
    // ======================

    public function userIndex()
    {
        $fines = Fine::with([
            'peminjaman.buku'
        ])
        ->whereHas('peminjaman', function ($query) {

            $query->where('user_id', Auth::id());

        })
        ->latest()
        ->get();

        return view('anggota.denda', compact('fines'));
    }
}
