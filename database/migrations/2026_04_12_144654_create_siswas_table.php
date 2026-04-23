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
        Schema::create('siswas', function (Blueprint $table) {
            $table->integer('nis')->primary(); // nis(int, 10) [cite: 67]
            $table->string('nama', 35); // nama(varchar, 35) [cite: 68]
            $table->string('kelas', 10); // kelas(varchar, 10) [cite: 69]
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
