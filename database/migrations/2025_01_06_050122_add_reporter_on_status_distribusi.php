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
            $table->integer('reporter')->after('status');
            $table->integer('user_id')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_distribusi', function (Blueprint $table) {
            $table->dropColumn('reporter');
            $table->dropColumn('user_id');
        });
    }
};
