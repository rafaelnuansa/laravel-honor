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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->unsignedBigInteger('channel_id');
            $table->string('kode_bayar')->unique();
            $table->date('tanggal_bayar');
            $table->string('bulan');
            $table->bigInteger('total_jtm');
            $table->bigInteger('total_honor')->nullable();
            $table->json('tugas_honor')->nullable();
            $table->bigInteger('payroll')->nullable();
            $table->bigInteger('koperasi')->nullable();
            $table->bigInteger('total_bersih')->nullable();
            $table->timestamps();
            // Menambahkan foreign key untuk pegawai
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            // Menambahkan foreign key untuk mata pelajaran
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('cascade');
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
