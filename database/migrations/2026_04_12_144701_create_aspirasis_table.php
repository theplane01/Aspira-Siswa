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
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->increments('id_pelaporan'); // [cite: 62]
            $table->integer('nis'); // Foreign key ke siswa [cite: 62]
            $table->integer('id_kategori'); // Foreign key ke kategori [cite: 63]
            $table->string('lokasi', 50); // [cite: 70]
            $table->string('ket', 50); // [cite: 72]
            $table->enum('status', ['Menunggu', 'Proses', 'Selesai'])->default('Menunggu'); // [cite: 74]
            $table->string('feedback', 50)->nullable(); // [cite: 78]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirasis');
    }
};
