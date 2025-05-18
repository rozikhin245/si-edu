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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->integer('nilai');
            $table->text('keterngan');
            $table->timestamps();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('tugas_id');
            $table->unsignedBigInteger('users_id');


            $table->foreign('siswa_id')->references('id')->on('siswa');
            $table->foreign('tugas_id')->references('id')->on('tugas');
            $table->foreign('users_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
