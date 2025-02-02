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
        Schema::table('submodules', function (Blueprint $table) {
            $table->string('submodule_code')->afted('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submodules', function (Blueprint $table) {
            $table->dropColumn('submodule_code');
        });
    }
};
