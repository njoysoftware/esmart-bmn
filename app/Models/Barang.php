<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'id',
        'kode_barang',
        'nup',
        'nama_barang',
        'merk',
        'kode_register',
        'status_bmn',
        'lokasi_id',
        'pegawai_id',
        'kondisi',
    ];
    public function lokasi()
    {
        return $this->belongsTo(\App\Models\Lokasi::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(\App\Models\Pegawai::class);
    }
    public function maintenance()
    {
        return $this->hasMany(\App\Models\Maintenance::class);
    }
}
