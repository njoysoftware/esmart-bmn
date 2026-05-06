<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VercelBlobService
{
    public static function upload(string $filePath, string $filename): string
    {
        $token = env('BLOB_READ_WRITE_TOKEN');
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'x-content-type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->withBody(
            file_get_contents($filePath),
            'application/octet-stream'
        )->put("https://blob.vercel-storage.com/{$filename}");

        return $response->json('url');
    }
}