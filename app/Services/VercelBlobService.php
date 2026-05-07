<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Exception;
use VercelBlobPhp\Client;
use VercelBlobPhp\CommonCreateBlobOptions;

class VercelBlobService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function upload(UploadedFile $file, string $folder = 'uploads')
    {
        $cleanFolder = trim($folder, '/');
        $path = $cleanFolder . '/' . time() . '-' . $file->getClientOriginalName();

        try {
            // Baca isi file
            $content = file_get_contents($file->getRealPath());
            // Konfigurasi sesuai spesifikasi package
            $options = new CommonCreateBlobOptions(
                addRandomSuffix: true,
                contentType: $file->getMimeType(), // Otomatis deteksi (misal: application/vnd.ms-excel)
                cacheControlMaxAge: 3600,
                allowOverwrite: true
            );

            // Upload ke Vercel Blob
            // Eksekusi put sesuai struktur package
            return $this->client->put(
                path: $path,
                content: $content,
                options: $options
            );
        } catch (Exception $e) {
            throw new Exception("Gagal unggah ke Vercel Blob: " . $e->getMessage());
        }
    }
}
