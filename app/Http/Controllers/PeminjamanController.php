<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Fine;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{

    // =====================================
    // PEMINJAMAN SAYA
    // =====================================

    public function index()
    {
        // Pastikan status "terlambat" sudah konsisten di DB
        $this->syncTerlambatStatus();

        $peminjamans = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view(
            'anggota.peminjaman',
            compact('peminjamans')
        );
    }




    // =====================================
    // DENDA SAYA
    // =====================================

    public function denda()
    {
        // Pastikan status "terlambat" sudah konsisten di DB
        $this->syncTerlambatStatus();

        $dendas = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->where('status', 'terlambat')
            ->latest()
            ->get();

        return view(
            'anggota.denda',
            compact('dendas')
        );
    }




    // =====================================
    // PINJAM BUKU
    // =====================================

    public function storeModal(Request $request)
    {

        $request->validate([

            'buku_id' => 'required|exists:bukus,id',

            'tanggal_pinjam' => 'required|date',

            'lama_pinjam' => 'required|integer|min:1|max:7',

        ]);





        // =====================================
        // AMBIL BUKU
        // =====================================

        $buku = Buku::findOrFail(
            $request->buku_id
        );




        // =====================================
        // VALIDASI STOK
        // =====================================

        if ($buku->stok <= 0) {

            return redirect('/daftar-buku')
                ->with(
                    'error',
                    'Stok buku habis.'
                );

        }




        // =====================================
        // TANGGAL
        // =====================================

        // Ambil tanggal dari form user (dan normalisasi ke awal hari)
        $tanggalPinjam = Carbon::parse($request->input('tanggal_pinjam'))->startOfDay();

        if ($tanggalPinjam->lt(Carbon::today())) {

            return redirect('/daftar-buku')
                ->with('error', 'Tanggal pinjam tidak boleh ke belakang.');

        }

        $lamaPinjam = (int) $request->input('lama_pinjam', 1);

        // sinkron tanggal_kembali melalui lama_pinjam
        $tanggalKembali = $tanggalPinjam->copy()->addDays($lamaPinjam)->startOfDay();

        // Validasi rentang maksimal 7 hari (tambahan pengaman)
        if ($lamaPinjam < 1 || $lamaPinjam > 7) {

            return redirect('/daftar-buku')
                ->with('error', 'Lama pinjam harus antara 1 sampai 7 hari.');

        }






        // =====================================
        // SIMPAN PEMINJAMAN
        // =====================================

        Peminjaman::create([

            'user_id' => Auth::id(),

            'buku_id' => $buku->id,

            'tanggal_pinjam' => $tanggalPinjam,

            'tanggal_kembali' => $tanggalKembali,

            'status' => 'pending',

        ]);




        return redirect('/peminjaman')
            ->with(
                'success',
                'Pengajuan peminjaman berhasil. Menunggu persetujuan admin.'
            );
    }




    // =====================================
    // APPROVE ADMIN
    // =====================================

    public function approve($id)
    {
        $pinjam = Peminjaman::with('buku')
            ->findOrFail($id);




        // =====================================
        // VALIDASI STATUS
        // =====================================

        if ($pinjam->status !== 'pending') {

            return redirect('/kelola-peminjaman')
                ->with(
                    'error',
                    'Peminjaman tidak valid.'
                );

        }




        // =====================================
        // VALIDASI STOK
        // =====================================

        if ($pinjam->buku->stok <= 0) {

            return redirect('/kelola-peminjaman')
                ->with(
                    'error',
                    'Stok buku habis.'
                );

        }




        DB::transaction(function () use ($pinjam) {

            // STATUS DIPINJAM
            $pinjam->status = 'dipinjam';

            $pinjam->save();


            // KURANGI STOK
            $pinjam->buku->decrement('stok', 1);

        });




        return redirect('/kelola-peminjaman')
            ->with(
                'success',
                'Peminjaman berhasil disetujui.'
            );
    }




    // =====================================
    // TOLAK ADMIN
    // =====================================

    public function reject($id)
    {
        $pinjam = Peminjaman::findOrFail($id);




        if ($pinjam->status !== 'pending') {

            return redirect('/kelola-peminjaman')
                ->with(
                    'error',
                    'Peminjaman tidak valid.'
                );

        }




        // STATUS DITOLAK
        $pinjam->status = 'ditolak';

        $pinjam->save();




        return redirect('/kelola-peminjaman')
            ->with(
                'success',
                'Peminjaman berhasil ditolak.'
            );
    }




    // =====================================
    // KELOLA PEMINJAMAN ADMIN
    // =====================================

    public function kelola()
    {
        // Pastikan status "terlambat" sudah konsisten di DB sebelum difilter
        $this->syncTerlambatStatus();

        $query = Peminjaman::with([
            'user',
            'buku'
        ])->latest();

        // =====================================
        // FILTER STATUS
        // =====================================

        if (request('status')) {

            $status = request('status');

            // Normalisasi parameter query (dari blade yang masih pakai label kapital)
            $status = match ($status) {
                'Pending' => 'pending',
                'Dipinjam' => 'dipinjam',
                'Dikembalikan' => 'dikembalikan',
                'Ditolak' => 'ditolak',
                'Terlambat' => 'terlambat',
                default => strtolower($status),
            };

            $query->where('status', $status);
        }

        $peminjamans = $query->get();

        return view(
            'admin.kelola-peminjaman',
            compact('peminjamans')
        );
    }




    // =====================================
    // KEMBALIKAN BUKU
    // =====================================

    public function kembalikan($id)
    {
        $pinjam = Peminjaman::findOrFail($id);




        // =====================================
        // HANYA STATUS DIPINJAM / TERLAMBAT
        // =====================================

        if (!in_array($pinjam->status, ['dipinjam', 'terlambat'], true)) {

            return redirect('/kelola-peminjaman')
                ->with(
                    'error',
                    'Buku tidak bisa dikembalikan.'
                );

        }




        // =====================================
        // STATUS DIKEMBALIKAN
        // =====================================

        $pinjam->status = 'dikembalikan';

        $pinjam->save();




        // =====================================
        // TAMBAH STOK
        // =====================================

        $buku = Buku::findOrFail(
            $pinjam->buku_id
        );

        $buku->increment('stok', 1);




        // =====================================
        // CEK DENDA
        // =====================================

        if (
            now()->gt($pinjam->tanggal_kembali)
            && $pinjam->fine()->doesntExist()
        ) {

            $hariTerlambat = now()->diffInDays(
                $pinjam->tanggal_kembali
            );

            $jumlahDenda = $hariTerlambat * 2000;




            Fine::create([

                'peminjaman_id' => $pinjam->id,

                'jumlah_denda' => $jumlahDenda,

                'dibayar' => 0,

                'sisa_denda' => $jumlahDenda,

                'status' => 'UNPAID',

            ]);
        }




        return redirect('/kelola-peminjaman')
            ->with(
                'success',
                'Buku berhasil dikembalikan.'
            );
    }




    // =====================================
    // HAPUS DATA
    // =====================================

    public function destroy($id)
    {
        $pinjam = Peminjaman::findOrFail($id);




        // =====================================
        // HANYA STATUS SELESAI
        // =====================================

        if (
            $pinjam->status != 'dikembalikan' &&
            $pinjam->status != 'ditolak'
        ) {

            return redirect('/kelola-peminjaman')
                ->with(
                    'error',
                    'Data aktif tidak bisa dihapus.'
                );

        }




        $pinjam->delete();




        return redirect('/kelola-peminjaman')
            ->with(
                'success',
                'Data berhasil dihapus.'
            );
    }

    /**
     * Sync otomatis status peminjaman menjadi "terlambat"
     * ketika status masih dipinjam dan tanggal_kembali sudah lewat.
     */
    private function syncTerlambatStatus(): void
    {
        Peminjaman::query()
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', now()->toDateString())
            ->update(['status' => 'terlambat']);
    }

}