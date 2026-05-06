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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('barang_id')->constrained()->cascadeOnDelete();

            $table->date('tanggal');
            $table->string('jenis');
            $table->text('deskripsi')->nullable();
            $table->integer('biaya')->nullable();

            $table->enum('kondisi_setelah', ['Baik', 'Rusak Ringan', 'Rusak Berat']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
