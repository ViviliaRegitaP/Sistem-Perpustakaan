<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Normalisasi status peminjaman lama (huruf besar) menjadi lowercase
        DB::table('peminjamans')->where('status', 'Pending')->update(['status' => 'pending']);
        DB::table('peminjamans')->where('status', 'Dipinjam')->update(['status' => 'dipinjam']);
        DB::table('peminjamans')->where('status', 'Ditolak')->update(['status' => 'ditolak']);
        DB::table('peminjamans')->where('status', 'Dikembalikan')->update(['status' => 'dikembalikan']);

        // Jika sebelumnya sudah terlanjur ada nilai "Terlambat", biarkan (atau tetap normalisasi)
        DB::table('peminjamans')->where('status', 'Terlambat')->update(['status' => 'terlambat']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Membalikkan normalisasi tidak dijamin 1:1 karena data bisa sudah berubah,
        // jadi untuk aman migration ini tidak mengubah balik.
    }
};
