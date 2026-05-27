<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    // =========================
    // ADMIN
    // =========================

    public function adminIndex()
    {
        // Ambil semua peminjaman, lalu filter "Terlambat" dengan logic dari tanggal_kembali
        $peminjamans = Peminjaman::with([
            'user',
            'buku',
            'fine'
        ])->get();

        $telatPeminjamans = $peminjamans->filter(function ($pinjam) {
            return now()->gt($pinjam->tanggal_kembali) && $pinjam->status == 'Dipinjam';
        })->values();

        // Auto-create/auto-update denda untuk peminjaman yang terlambat
        foreach ($telatPeminjamans as $pinjam) {
            $telat = now()->diffInDays($pinjam->tanggal_kembali);
            $telat = max(0, $telat);
            $jumlahDenda = $telat * 2000;

            if (!$pinjam->fine) {
                Fine::create([
                    'peminjaman_id' => $pinjam->id,
                    'jumlah_denda' => $jumlahDenda,
                    'dibayar' => 0,
                    'sisa_denda' => $jumlahDenda,
                    'status' => 'UNPAID',
                ]);
            } else {
                // update jumlah denda & sisa bila belum lunas
                $pinjam->fine->jumlah_denda = $jumlahDenda;
                if ($pinjam->fine->status !== 'PAID') {
                    $pinjam->fine->sisa_denda = max(0, $jumlahDenda - (int) $pinjam->fine->dibayar);
                    if ($pinjam->fine->status === 'UNPAID' && $pinjam->fine->dibayar > 0) {
                        $pinjam->fine->status = 'PARTIALLY_PAID';
                    }
                }
                $pinjam->fine->save();
            }
        }

        // Reload relasi fine setelah auto-create/update
        $peminjamans = Peminjaman::with([
            'user',
            'buku',
            'fine'
        ])->get();

        $telatPeminjamans = $peminjamans->filter(function ($pinjam) {
            return now()->gt($pinjam->tanggal_kembali) && $pinjam->status == 'Dipinjam';
        })->values();

        return view('admin.kelola-denda', compact('peminjamans'));

    }


    // =========================
    // USER
    // =========================

    public function userIndex()
    {
        // Ambil semua peminjaman milik user login, lalu filter terlambat berdasarkan tanggal_kembali
        $peminjamans = Peminjaman::with([
            'buku',
            'fine'
        ])
        ->where('user_id', Auth::id())
        ->get();

        $telatPeminjamans = $peminjamans->filter(function ($pinjam) {
            return now()->gt($pinjam->tanggal_kembali) && $pinjam->status == 'Dipinjam';
        })->values();

        // Auto-create/auto-update denda untuk user yang terlambat
        foreach ($telatPeminjamans as $pinjam) {
            $telat = now()->diffInDays($pinjam->tanggal_kembali);
            $telat = max(0, $telat);
            $jumlahDenda = $telat * 2000;

            if (!$pinjam->fine) {
                Fine::create([
                    'peminjaman_id' => $pinjam->id,
                    'jumlah_denda' => $jumlahDenda,
                    'dibayar' => 0,
                    'sisa_denda' => $jumlahDenda,
                    'status' => 'UNPAID',
                ]);
            } else {
                $pinjam->fine->jumlah_denda = $jumlahDenda;
                if ($pinjam->fine->status !== 'PAID') {
                    $pinjam->fine->sisa_denda = max(0, $jumlahDenda - (int) $pinjam->fine->dibayar);
                    if ($pinjam->fine->status === 'UNPAID' && $pinjam->fine->dibayar > 0) {
                        $pinjam->fine->status = 'PARTIALLY_PAID';
                    }
                }
                $pinjam->fine->save();
            }
        }

        // Reload supaya relasi fine terbaru kebaca
        $peminjamans = Peminjaman::with(['buku', 'fine'])
            ->where('user_id', Auth::id())
            ->get();

        $telatPeminjamans = $peminjamans->filter(function ($pinjam) {
            return now()->gt($pinjam->tanggal_kembali) && $pinjam->status == 'Dipinjam';
        })->values();

        return view('anggota.denda', compact('telatPeminjamans'));
    }


    // =========================
    // UPDATE DENDA
    // =========================

    public function update(Request $request, $fines_id)
    {
        $validated = $request->validate([
            'status' => 'required|in:UNPAID,PARTIALLY_PAID,PAID',
            'dibayar' => 'nullable|integer|min:0',
        ]);

        $fine = Fine::where('fines_id', $fines_id)
            ->firstOrFail();

        // =========================
        // TOTAL DENDA
        // =========================

        $jumlahDenda = (int) $fine->jumlah_denda;

        // =========================
        // STATUS
        // =========================

        $status = $validated['status'];

        // =========================
        // BELUM BAYAR
        // =========================

        if ($status === 'UNPAID') {

            $fine->status = 'UNPAID';

            $fine->dibayar = 0;

            $fine->sisa_denda = $jumlahDenda;
        }

        // =========================
        // LUNAS
        // =========================

        elseif ($status === 'PAID') {

            $fine->status = 'PAID';

            $fine->dibayar = $jumlahDenda;

            $fine->sisa_denda = 0;
        }

        // =========================
        // CICIL
        // =========================

        elseif ($status === 'PARTIALLY_PAID') {

            $dibayar = isset($validated['dibayar'])
                ? (int) $validated['dibayar']
                : 0;

            // jangan melebihi total denda
            if ($dibayar > $jumlahDenda) {
                $dibayar = $jumlahDenda;
            }

            // kalau 0 -> unpaid
            if ($dibayar <= 0) {

                $fine->status = 'UNPAID';

                $fine->dibayar = 0;

                $fine->sisa_denda = $jumlahDenda;
            }

            // kalau lunas -> paid
            elseif ($dibayar >= $jumlahDenda) {

                $fine->status = 'PAID';

                $fine->dibayar = $jumlahDenda;

                $fine->sisa_denda = 0;
            }

            // cicilan biasa
            else {

                $fine->status = 'PARTIALLY_PAID';

                $fine->dibayar = $dibayar;

                $fine->sisa_denda = $jumlahDenda - $dibayar;
            }
        }

        // =========================
        // SAVE
        // =========================

        $fine->save();

        return redirect()
            ->back()
            ->with(
                'success',
                'Status denda berhasil diperbarui'
            );
    }
}
