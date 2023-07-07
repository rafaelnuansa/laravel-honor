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
        Schema::create('pegawai_mapel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('mapel_id');
            $table->timestamps();

            // Menambahkan foreign key untuk pegawai
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            // Menambahkan foreign key untuk mata pelajaran
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_mapel');
    }
};
