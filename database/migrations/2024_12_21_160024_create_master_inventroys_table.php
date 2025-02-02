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
        Schema::create('master_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('no_un');
            $table->string('no_mesin');
            // $table->string('no_rangka');
            // $table->string('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_inventory');
    }
};
