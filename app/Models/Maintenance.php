<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'barang_id',
        'tanggal',
        'jenis',
        'deskripsi',
        'biaya',
        'kondisi_setelah',
    ];

    public function barang()
    {
        return $this->belongsTo(\App\Models\Barang::class);
    }
}
