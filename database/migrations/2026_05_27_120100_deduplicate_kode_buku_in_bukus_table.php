<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ambil semua buku, urutkan berdasarkan id (yang id kecil dipertahankan)
        $bukus = DB::table('bukus')
            ->select('id', 'kode_buku')
            ->orderBy('id', 'asc')
            ->get();

        // Hitung semua nomor maks yang sudah ada
        $maxNumber = DB::table('bukus')
            ->selectRaw("MAX(CAST(SUBSTRING(kode_buku, 3) AS UNSIGNED)) AS max_num")
            ->value('max_num');

        $nextNumber = ($maxNumber ?? 0) + 1;

        $seen = [];

        DB::transaction(function () use (&$seen, $bukus, &$nextNumber) {
            foreach ($bukus as $buku) {
                $kode = $buku->kode_buku;

                if (!isset($seen[$kode])) {
                    $seen[$kode] = true;
                    continue;
                }

                // Duplikat: ganti dengan kode baru
                $newKode = 'BK' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                $nextNumber++;

                DB::table('bukus')
                    ->where('id', $buku->id)
                    ->update(['kode_buku' => $newKode]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak bisa di-revert secara aman karena kode buku sudah terlanjur diubah.
    }
};

