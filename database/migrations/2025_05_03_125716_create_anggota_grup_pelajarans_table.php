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
        Schema::create('anggota_grup_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['admin', 'wali murid', 'guru']);
            $table->timestamps();
            $table->unsignedBigInteger('grup_mata_pelajaran_id');
            $table->unsignedBigInteger('users_id');

            $table->foreign('grup_mata_pelajaran_id')->references('id')->on('grup_matapelajaran');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_grup_pelajaran');
    }
};
