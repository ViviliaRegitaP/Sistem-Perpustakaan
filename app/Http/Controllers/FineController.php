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
        $peminjamans = Peminjaman::with([
            'user',
            'buku',
            'fine'
        ])
        ->whereDate('tanggal_kembali', '<', now())
        ->get();

        // =========================
        // AUTO CREATE DENDA
        // =========================

        foreach ($peminjamans as $pinjam) {

            $telat = now()->diffInDays($pinjam->tanggal_kembali, false);

            // diffInDays bisa negatif/positif tergantung arah; agar konsisten ambil nilai positif
            $telat = abs($telat);


            $jumlahDenda = $telat * 2000;


            // kalau belum ada data denda
            if (!$pinjam->fine) {

                Fine::create([

                    'peminjaman_id' => $pinjam->id,

                    'jumlah_denda' => $jumlahDenda,

                    'dibayar' => 0,

                    'sisa_denda' => $jumlahDenda,

                    'status' => 'UNPAID',

                ]);
            }
        }

        // reload relasi fine
        $peminjamans = Peminjaman::with([
            'user',
            'buku',
            'fine'
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
            'buku',
            'fine'
        ])
        ->where('user_id', Auth::id())
        ->whereDate('tanggal_kembali', '<', now())
        ->get();

        return view(
            'anggota.denda',
            compact('peminjamans')
        );
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
