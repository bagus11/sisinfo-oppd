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
        Schema::create('master_assets', function (Blueprint $table) {
            $table->id();
            $table->integer('satgas');
            $table->integer('user_id');
            $table->string('no_un');
            $table->string('category');
            $table->string('sub_category');
            $table->string('type');
            $table->string('brand');
            $table->string('no_rangka');
            $table->integer('kodisi');
            $table->longText('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_assets');
    }
};
