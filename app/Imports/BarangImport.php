<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Lokasi;
use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BarangImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            // skip header
            if ($index == 0) continue;

            // ✅ skip row kosong total
            if ($row->filter()->isEmpty()) continue;

            // ambil data dengan aman (hindari undefined index)
            $kode_barang   = $row[0] ?? null;
            $nup           = $row[1] ?? null;
            $nama_barang   = $row[2] ?? null;
            $merk          = $row[3] ?? null;
            $status        = $row[4] ?? 'Aktif';
            $lokasi_kode   = $row[5] ?? null;
            $lokasi_nama   = $row[6] ?? null;
            $kondisi       = $row[7] ?? 'Baik';
            $pegawai_nama  = $row[8] ?? null;

            // ✅ skip jika data utama kosong
            if (!$kode_barang || !$nup || !$nama_barang) continue;

            $lokasi = null;

            if ($lokasi_kode || $lokasi_nama) {
                // fallback kalau nama kosong
                $nama_ruang = $lokasi_nama ?: 'Pribadi';

                $lokasi = Lokasi::updateOrCreate(
                    ['kode_ruang' => $lokasi_kode],
                    ['nama_ruang' => $nama_ruang]
                );
            }

            // pegawai
            $pegawai = null;
            if ($pegawai_nama) {
                $pegawai = Pegawai::firstOrCreate([
                    'nama' => $pegawai_nama
                ]);
            }

            // barang
            Barang::updateOrCreate(
                [
                    'kode_barang' => $kode_barang,
                    'nup' => $nup,
                ],
                [
                    'nama_barang' => $nama_barang,
                    'merk' => $merk,
                    'status_bmn' => $status,
                    'lokasi_id' => $lokasi?->id,
                    'pegawai_id' => $pegawai?->id,
                    'kondisi' => $kondisi,
                ]
            );
        }
    }
}
