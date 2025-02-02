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
        Schema::create('inventaris_logs', function (Blueprint $table) {
            $table->id();
            $table->string('inventaris_code');
            $table->date('bulan');
            $table->integer('satgas');
            $table->integer('satgas_type');
            $table->integer('reporter');
            $table->string('asset_code');
            $table->integer('kondisi');
            $table->integer('user_id');
            $table->string('attachment');
            $table->longText('catatan');
            $table->longText('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_logs');
    }
};
