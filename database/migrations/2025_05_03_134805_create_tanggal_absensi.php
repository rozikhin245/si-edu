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
        Schema::create('tanggal_absensi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_guru');
            $table->unsignedBigInteger('komunitas_id');
            $table->timestamps();

            $table->foreign('komunitas_id')->references('id')->on('komonitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggal_absensi');
    }
};
