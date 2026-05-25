<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [

        'user_id',
        'buku_id',
        'tanggal_pinjam',

        // TAMBAHAN BATAS PENGEMBALIAN
        'tanggal_kembali',

        'status',

    ];

    // RELASI USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RELASI BUKU
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    //RELASI DENDA
    public function fine()
    {
        return $this->hasOne(Fine::class);
    }
}