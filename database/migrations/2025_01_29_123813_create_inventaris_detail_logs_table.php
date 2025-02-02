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
        Schema::create('inventaris_detail_logs', function (Blueprint $table) {
            $table->id();
            $table->string('inventaris_code');
            $table->string('asset_code');
            $table->string('satgas');
            $table->string('satgas_type');
            $table->string('bulan');
            $table->integer('reporter');
            $table->integer('user_id');
            $table->integer('kondisi');
            $table->longText('catatan');
            $table->string('attachment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_detail_logs');
    }
};
