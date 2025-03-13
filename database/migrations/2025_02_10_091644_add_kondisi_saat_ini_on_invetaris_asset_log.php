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
        Schema::table('inventaris_detail_logs', function (Blueprint $table) {
            $table->integer('kondisi_saat_ini')->after('kondisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventaris_detail_logs', function (Blueprint $table) {
            $table->dropColumn('kondisi_saat_ini');
        });
    }
};
