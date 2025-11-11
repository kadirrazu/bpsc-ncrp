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
        Schema::create('htype_data', function (Blueprint $table) {
            $table->id();
            $table->integer('post_code');
            $table->string('bnd_number');
            $table->string('scan_bnd_number')->nullable();
            $table->integer('scan_sr');
            $table->string('litho_code1');
            $table->string('scan_litho_code1');
            $table->string('hex_code1');
            $table->string('answers')->nullable();
            $table->string('total_mark')->nullable();
            $table->string('negative_mark')->nullable();
            $table->string('extra_mark')->nullable();
            $table->string('final_mark')->nullable();
            $table->string('litho_code2');
            $table->string('scan_litho_code2');
            $table->string('hex_code2');
            $table->string('bullet')->nullable();
            $table->boolean('litho_issue')->default(0);
            $table->string('litho_status')->nullable();
            $table->boolean('hex_issue')->default(0);
            $table->string('hex_status')->nullable();
            $table->string('update_status')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('general_status')->nullable();
            $table->timestamps();
            $table->index(['bnd_number', 'litho_issue', 'hex_issue']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('htype_data');
    }
};
