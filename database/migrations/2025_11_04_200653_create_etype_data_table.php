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
        Schema::create('etype_data', function (Blueprint $table) {
            $table->id();
            $table->integer('post_code');
            $table->integer('bnd_number');
            $table->integer('scan_sr');
            $table->string('litho_code1');
            $table->string('scan_litho_code1');
            $table->string('hexcode_code1');
            $table->string('center')->nullable();
            $table->string('scan_center')->nullable();
            $table->string('reg_number');
            $table->string('scan_reg_number');
            $table->string('set_code')->nullable();
            $table->string('scan_set_code')->nullable();
            $table->string('litho_code2');
            $table->string('scan_litho_code2');
            $table->string('hexcode_code2');
            $table->string('bullet')->nullable();
            $table->string('litho_status')->nullable();
            $table->string('hex_status')->nullable();
            $table->string('update_status')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etype_data');
    }
};
