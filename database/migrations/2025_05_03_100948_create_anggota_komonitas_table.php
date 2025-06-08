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
        Schema::create('anggota_komonitas', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['admin', 'guru', 'wali-murid']);
            $table->timestamps();
            $table->unsignedBigInteger('komonitas_id');
            $table->unsignedBigInteger('users_id');

            $table->foreign('komonitas_id')->references('id')->on('komonitas');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_komonitas');
    }
};
