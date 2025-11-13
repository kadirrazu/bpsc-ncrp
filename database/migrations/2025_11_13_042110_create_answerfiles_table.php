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
        Schema::create('answerfiles', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_id');
            $table->integer('post_code');
            $table->string('file_type');
            $table->string('file_name')->unique();
            $table->boolean('conversion_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answerfiles');
    }
};
