<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rkbmns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('barang_id')->constrained()->cascadeOnDelete();

            $table->enum('jenis_rekomendasi', ['Pengadaan', 'Penggantian', 'Penghapusan']);
            $table->text('alasan');

            $table->enum('prioritas', ['Tinggi', 'Sedang', 'Rendah']);
            $table->year('tahun');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkbmns');
    }
};
