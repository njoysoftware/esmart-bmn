<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rkbmn extends Model
{
    protected $fillable = [
        'barang_id',
        'jenis_rekomendasi',
        'alasan',
        'prioritas',
        'tahun',
    ];

    public function barang()
    {
        return $this->belongsTo(\App\Models\Barang::class);
    }
}
