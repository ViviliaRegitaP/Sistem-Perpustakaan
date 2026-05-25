<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $table = 'fines';
    protected $primaryKey = 'fines_id';
    protected $fillable = [
        'peminjaman_id',
        'jumlah_denda',
        'dibayar',
        'sisa_denda',
        'status',
    ];

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'UNPAID' => 'Belum Dibayar',
            'PARTIALLY_PAID' => 'Dicicil',
            'PAID' => 'Lunas',
            default => '-',
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'UNPAID' => 'danger',
            'PARTIALLY_PAID' => 'warning',
            'PAID' => 'success',
            default => 'secondary',
        };
    }

    // RELASI KE PEMINJAMAN
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
