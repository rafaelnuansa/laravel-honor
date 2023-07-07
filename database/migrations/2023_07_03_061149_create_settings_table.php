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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi')->nullable();
            $table->string('logo_aplikasi')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->string('logo_sekolah')->nullable();
            $table->string('alamat_sekolah')->nullable();
            $table->bigInteger('nomor_kontak')->nullable();
            $table->string('nama_ttd_invoice')->nullable();
            $table->string('jabatan_ttd_invoice')->nullable();
            $table->text('catatan_invoice')->nullable();
            $table->string('img_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
