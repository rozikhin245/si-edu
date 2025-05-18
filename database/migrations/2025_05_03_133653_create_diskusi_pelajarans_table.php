<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Extension\Table\TableRow;
use Symfony\Component\Console\Helper\TableCellStyle;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diskusi_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->text('pesan');
            $table->timestamps();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('grup_mata_pelajaran_id');

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('grup_mata_pelajaran_id')->references('id')->on('grup_matapelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskusi_pelajaran');
    }
};
