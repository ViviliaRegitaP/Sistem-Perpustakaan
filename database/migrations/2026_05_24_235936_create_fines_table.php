<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fines', function (Blueprint $table) {

            $table->id('fines_id');

            $table->foreignId('peminjaman_id')
                ->constrained('peminjamans')
                ->onDelete('cascade');

            $table->integer('jumlah_denda');
            $table->integer('dibayar')->default(0);
            $table->integer('sisa_denda')->default(0);

            $table->enum('status', [
                'UNPAID',
                'PARTIALLY_PAID',
                'PAID'
            ])->default('UNPAID');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
