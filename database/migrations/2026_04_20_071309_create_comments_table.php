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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('id_komentar');
            $table->unsignedInteger('id_pelaporan');
            $table->integer('nis');
            $table->longText('komentar');
            $table->timestamps();

            $table->foreign('id_pelaporan')->references('id_pelaporan')->on('aspirasis')->onDelete('cascade');
            $table->foreign('nis')->references('nis')->on('siswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
