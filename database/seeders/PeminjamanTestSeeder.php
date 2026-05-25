<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Fine;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PeminjamanTestSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'user@perpus.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('password'),
            ]
        );

        Peminjaman::where('user_id', $user->id)->delete();

        Fine::whereHas('peminjaman', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->delete();

        // ======================
        // Categories
        // ======================

        $kategori1 = Kategori::firstOrCreate([
            'nama_kategori' => 'Novel'
        ]);

        $kategori2 = Kategori::firstOrCreate([
            'nama_kategori' => 'Filsafat'
        ]);

        // ======================
        // BOOKS
        // ======================
        $buku1 = Buku::firstOrCreate(
            ['judul' => 'Laskar Pelangi'],
            [
                'kode_buku' => 'BK001',
                'stok' => 5,
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang',
                'tahun_terbit' => 2005,
                'kategori_id' => $kategori1->id
            ]
        );

        $buku2 = Buku::firstOrCreate(
            ['judul' => 'Bumi Manusia'],
            [
                'kode_buku' => 'BK002',
                'stok' => 3,
                'penulis' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Hasta Mitra',
                'tahun_terbit' => 2005,
                'kategori_id' => $kategori2->id
            ]
        );

        $buku3 = Buku::firstOrCreate(
            ['judul' => 'Negeri 5 Menara'],
            [
                'kode_buku' => 'BK003',
                'stok' => 2,
                'penulis' => 'A. Fuadi',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2005,
                'kategori_id' => $kategori1->id
            ]
        );

        // ======================
        // OVERDUE PEMINJAMAN 1 (PAID)
        // ======================
        $pinjam1 = Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku1->id,
            'tanggal_pinjam' => now()->subDays(10),
            'tanggal_kembali' => now()->subDays(5), // overdue
            'status' => 'Dikembalikan',
        ]);

        $buku1->decrement('stok');

        Fine::create([
            'peminjaman_id' => $pinjam1->id,
            'jumlah_denda' => 10000,
            'dibayar' => 10000,
            'sisa_denda' => 0,
            'status' => 'PAID',
        ]);

        // ======================
        // OVERDUE PEMINJAMAN 2 (PARTIAL PAYMENT)
        // ======================
        $pinjam2 = Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku2->id,
            'tanggal_pinjam' => now()->subDays(15),
            'tanggal_kembali' => now()->subDays(7), // overdue
            'status' => 'Dikembalikan',
        ]);

        $buku2->decrement('stok');

        Fine::create([
            'peminjaman_id' => $pinjam2->id,
            'jumlah_denda' => 20000,
            'dibayar' => 5000,
            'sisa_denda' => 15000,
            'status' => 'PARTIALLY_PAID',
        ]);

        // ======================
        // OVERDUE PEMINJAMAN 3 (NOT PAID)
        // ======================
        $pinjam3 = Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku3->id,
            'tanggal_pinjam' => now()->subDays(20),
            'tanggal_kembali' => now()->subDays(10), // overdue
            'status' => 'Dikembalikan',
        ]);
                
        $buku3->decrement('stok');

        Fine::create([
            'peminjaman_id' => $pinjam3->id,
            'jumlah_denda' => 30000,
            'dibayar' => 0,
            'sisa_denda' => 30000,
            'status' => 'UNPAID',
        ]);
    }
}