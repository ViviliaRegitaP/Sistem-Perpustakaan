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
        $dendas = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->where(function ($query) {

                $query->where('status', 'Dipinjam')
                    ->orWhere('status', 'Dikembalikan');

            })
            ->get()
            ->filter(function ($item) {

                return now()->gt($item->tanggal_kembali);

            });

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

        $tanggalPinjam = Carbon::today();

        $tanggalKembali = Carbon::today()
                                ->addDays(7);




        // =====================================
        // SIMPAN PEMINJAMAN
        // =====================================

        Peminjaman::create([

            'user_id' => Auth::id(),

            'buku_id' => $buku->id,

            'tanggal_pinjam' => $tanggalPinjam,

            'tanggal_kembali' => $tanggalKembali,

            'status' => 'Pending',

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

        if ($pinjam->status !== 'Pending') {

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
            $pinjam->status = 'Dipinjam';

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




        if ($pinjam->status !== 'Pending') {

            return redirect('/kelola-peminjaman')
                ->with(
                    'error',
                    'Peminjaman tidak valid.'
                );

        }




        // STATUS DITOLAK
        $pinjam->status = 'Ditolak';

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
        $query = Peminjaman::with([
                    'user',
                    'buku'
                ])->latest();




        // =====================================
        // FILTER STATUS
        // =====================================

        if(request('status')){

            $query->where(
                'status',
                request('status')
            );

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
        // HANYA STATUS DIPINJAM
        // =====================================

        if ($pinjam->status !== 'Dipinjam') {

            return redirect('/kelola-peminjaman')
                ->with(
                    'error',
                    'Buku tidak bisa dikembalikan.'
                );

        }




        // =====================================
        // STATUS DIKEMBALIKAN
        // =====================================

        $pinjam->status = 'Dikembalikan';

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
            $pinjam->status != 'Dikembalikan' &&
            $pinjam->status != 'Ditolak'
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

}