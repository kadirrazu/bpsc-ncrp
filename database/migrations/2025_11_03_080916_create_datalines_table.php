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
        Schema::create('datalines', function (Blueprint $table) {
            $table->id();
            $table->string('script_type');
            $table->string('part_title');
            $table->string('part_sequence');
            $table->string('start_position')->nullable();
            $table->string('length');
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datalines');
    }
};
