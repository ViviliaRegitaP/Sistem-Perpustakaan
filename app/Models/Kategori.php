<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id_kategori';
    protected $fillable = [
        'nama_kategori',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
