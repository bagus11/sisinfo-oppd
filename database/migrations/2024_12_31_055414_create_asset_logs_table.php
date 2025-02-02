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
        Schema::create('asset_logs', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code');
            $table->string('no_rangka');
            $table->string('no_mesin');
            $table->string('no_un');
            $table->integer('kategori');
            $table->integer('subkategori');
            $table->integer('jenis');
            $table->integer('merk');
            $table->integer('kondisi');
            $table->integer('user_id');
            $table->integer('pic');
            $table->integer('lokasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_logs');
    }
};
