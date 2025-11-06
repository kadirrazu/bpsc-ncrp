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
        Schema::create('issue_generation_report', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_id');
            $table->string('file_type');
            $table->string('issue_type');
            $table->timestamp('run_time')->nullable();
            $table->integer('issue_count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_generation_report');
    }
};
