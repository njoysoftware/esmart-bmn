<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/laporan/barang', [LaporanController::class, 'barang']);
Route::get('/laporan/maintenance', [LaporanController::class, 'maintenance']);
Route::get('/laporan/rkbmn', [LaporanController::class, 'rkbmn']);
Route::get('/laporan/semua', [LaporanController::class, 'semua']);


Route::get('/template/template-bmn.xlsx', function () {
    $file = public_path('template/template-bmn.xlsx');

    return Response::download($file);
})->name('template.download');


Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

Route::get('/debug-time', function () {
    return [
        'server_time' => now()->toDateTimeString(),
        'utc_time' => now('UTC')->toDateTimeString(),
        'timestamp' => time(),
        'timezone' => config('app.timezone'),
    ];
});
