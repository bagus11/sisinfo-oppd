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
        Schema::create('status_distribusi_detail', function (Blueprint $table) {
            $table->id();
            $table->string('distribution_code');
            $table->string('detail_distribution_code');
            $table->integer('user_id');
            $table->integer('status');
            $table->longText('keterangan');
            $table->string('attachment');
            $table->integer('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_distribusi_detail');
    }
};
