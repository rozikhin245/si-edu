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
        Schema::create('grup_matapelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_grup', 255);
            $table->unsignedBigInteger('komonitas_id');

            $table->foreign('komonitas_id')->references('id')->on('komonitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grup_matapelajaran');
    }
};
