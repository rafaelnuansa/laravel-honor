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
        Schema::create('other_payment_items', function (Blueprint $table) {
            $table->id();
            $table->string('kode_payment');
            $table->unsignedBigInteger('other_payment_id');
            $table->unsignedBigInteger('kegiatan_id');
            $table->bigInteger('honor');
            $table->bigInteger('qty');
            $table->bigInteger('total_honor');
            $table->timestamps();

            $table->foreign('kegiatan_id')->references('id')->on('kegiatan')->onDelete('cascade');
            $table->foreign('other_payment_id')->references('id')->on('other_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_payment_items');
    }
};
