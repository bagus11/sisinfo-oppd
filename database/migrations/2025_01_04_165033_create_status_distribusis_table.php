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
        Schema::create('status_distribusi', function (Blueprint $table) {
            $table->id();
            $table->string('distribution_code');
            $table->string('asset_code');
            $table->integer('des_location');
            $table->integer('current_location');
            $table->integer('status');
            $table->integer('kondisi');
            $table->longText('keterangan');
            $table->string('attachment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_distribusi');
    }
};
