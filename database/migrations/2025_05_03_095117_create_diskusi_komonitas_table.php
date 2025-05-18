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
        Schema::create('diskusi_komonitas', function (Blueprint $table) {
            $table->id();
            $table->text('pesan');
            $table->timestamps();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('komonitas_id');

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('komonitas_id')->references('id')->on('komonitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskusi_komonitas');
    }
};
