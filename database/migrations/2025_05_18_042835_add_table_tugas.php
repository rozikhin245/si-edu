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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->text('deskripsi');
            $table->string('deadline', 255);
            $table->string('file', 255)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('grup_matapelajaran_id');
            $table->unsignedBigInteger('users_id');

            $table->foreign('grup_matapelajaran_id')->references('id')->on('grup_matapelajaran');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');

    }
};
