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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();

            $table->string('kode_barang');
            $table->string('nup');

            $table->text('nama_barang');
            $table->string('merk')->nullable();
            $table->string('kode_register')->nullable();
            $table->string('status_bmn')->nullable();

            $table->foreignId('lokasi_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pegawai_id')->nullable()->constrained()->nullOnDelete();

            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');

            $table->timestamps();

            $table->unique(['kode_barang', 'nup']); // anti duplikat SIMAN
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
