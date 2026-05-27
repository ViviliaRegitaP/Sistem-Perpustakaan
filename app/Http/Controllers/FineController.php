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
        // Pastikan status "terlambat" tersinkron di DB (idempotent)
        Peminjaman::query()
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', now()->toDateString())
            ->update(['status' => 'terlambat']);

        // Ambil semua peminjaman terlambat (lowercase) untuk auto-create/auto-update denda
        $peminjamans = Peminjaman::with([
            'user',
            'buku',
            'fine'
        ])->get();

        $telatPeminjamans = $peminjamans->filter(function ($pinjam) {
            return $pinjam->status === 'terlambat';
        })->values();

        foreach ($telatPeminjamans as $pinjam) {
            $hariTerlambat = max(
                0,
                floor(
                    now()->diffInDays($pinjam->tanggal_kembali)
                )
            );

            $telat = (int) $hariTerlambat;
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
                    $pinjam->fine->sisa_denda = max(
                        0,
                        $jumlahDenda - (int) $pinjam->fine->dibayar
                    );

                    if (
                        $pinjam->fine->status === 'UNPAID'
                        && (int) $pinjam->fine->dibayar > 0
                    ) {
                        $pinjam->fine->status = 'PARTIALLY_PAID';
                    }
                }

                $pinjam->fine->save();
            }
        }

        // Reload supaya relasi fine terbaru terbaca
        $peminjamans = Peminjaman::with([
            'user',
            'buku',
            'fine'
        ])->get();

        return view('admin.kelola-denda', compact('peminjamans'));

    }


    // =========================
    // USER
    // =========================

    public function userIndex()
    {
        // Pastikan status "terlambat" tersinkron di DB (idempotent)
        Peminjaman::query()
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', now()->toDateString())
            ->update(['status' => 'terlambat']);

        $peminjamans = Peminjaman::with([
            'buku',
            'fine'
        ])
            ->where('user_id', Auth::id())
            ->get();

        $telatPeminjamans = $peminjamans->filter(function ($pinjam) {
            return $pinjam->status === 'terlambat';
        })->values();

        foreach ($telatPeminjamans as $pinjam) {
            $hariTerlambat = max(
                0,
                floor(
                    now()->diffInDays($pinjam->tanggal_kembali)
                )
            );

            $telat = (int) $hariTerlambat;
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
                    $pinjam->fine->sisa_denda = max(
                        0,
                        $jumlahDenda - (int) $pinjam->fine->dibayar
                    );

                    if (
                        $pinjam->fine->status === 'UNPAID'
                        && (int) $pinjam->fine->dibayar > 0
                    ) {
                        $pinjam->fine->status = 'PARTIALLY_PAID';
                    }
                }

                $pinjam->fine->save();
            }
        }

        $peminjamans = Peminjaman::with(['buku', 'fine'])
            ->where('user_id', Auth::id())
            ->get();

        $telatPeminjamans = $peminjamans->filter(function ($pinjam) {
            return $pinjam->status === 'terlambat';
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

