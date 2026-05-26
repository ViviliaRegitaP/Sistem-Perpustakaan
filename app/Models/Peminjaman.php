<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;



    // =====================================
    // TABLE
    // =====================================

    protected $table = 'peminjamans';



    // =====================================
    // FILLABLE
    // =====================================

    protected $fillable = [

        'user_id',

        'buku_id',

        'tanggal_pinjam',

        'tanggal_kembali',

        'status',

    ];



    // =====================================
    // CAST DATE
    // =====================================

    protected $casts = [

        'tanggal_pinjam' => 'date',

        'tanggal_kembali' => 'date',

    ];



    // =====================================
    // DEFAULT STATUS
    // =====================================

    protected $attributes = [

        'status' => 'Pending',

    ];



    // =====================================
    // RELASI USER
    // =====================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // =====================================
    // RELASI BUKU
    // =====================================

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }



    // =====================================
    // RELASI DENDA
    // =====================================

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }



    // =====================================
    // STATUS BADGE COLOR
    // =====================================

    public function getStatusColorAttribute()
    {
        return match($this->status){

            'Pending' => '#F59E0B',

            'Dipinjam' => '#A56A3D',

            'Dikembalikan' => '#16A34A',

            'Ditolak' => '#DC2626',

            default => '#6B7280',

        };
    }



    // =====================================
    // STATUS LABEL
    // =====================================

    public function getStatusLabelAttribute()
    {
        return match($this->status){

            'Pending' => 'Pending',

            'Dipinjam' => 'Dipinjam',

            'Dikembalikan' => 'Dikembalikan',

            'Ditolak' => 'Ditolak',

            default => 'Unknown',

        };
    }



    // =====================================
    // CEK TERLAMBAT
    // =====================================

    public function getIsLateAttribute()
    {
        return now()->gt($this->tanggal_kembali)
            && $this->status == 'Dipinjam';
    }



    // =====================================
    // HITUNG DENDA
    // =====================================

    public function getDendaAttribute()
    {
        if(!$this->is_late){

            return 0;

        }

        $hari = now()->diffInDays(
            $this->tanggal_kembali
        );

        return $hari * 2000;
    }
}