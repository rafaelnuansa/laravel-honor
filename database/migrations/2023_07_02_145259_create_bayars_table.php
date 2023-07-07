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
        Schema::create('bayar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->string('kode_bayar');
            $table->bigInteger('jml_jtm');
            $table->bigInteger('jml_honor');
            $table->bigInteger('bayar_honor');
            $table->string('tambahan1');
            $table->bigInteger('nom_tamb1');
            $table->string('tambahan2');
            $table->bigInteger('nom_tamb2');
            $table->string('tam_lainnya');
            $table->bigInteger('jml_tambahan');
            $table->date('bulan');
            $table->bigInteger('payroll')->nullable();
            $table->bigInteger('koperasi')->nullable();
            $table->bigInteger('total_bersih')->nullable();
            $table->string('honor_bulan')->nullable();
            $table->unsignedBigInteger('channel_id');
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
        Schema::dropIfExists('bayar');
    }
};
