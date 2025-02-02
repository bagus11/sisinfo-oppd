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
        Schema::table('status_distribusi', function (Blueprint $table) {
            $table->dropColumn('asset_code');
            $table->dropColumn('kondisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_distribusi', function (Blueprint $table) {
            $table->string('asset_code')->after('distribution_code');
            $table->integer('kondisi')->after('status');

        });
    }
};
