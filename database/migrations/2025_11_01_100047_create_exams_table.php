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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('authority');
            $table->string('entity');
            $table->integer('post_code')->unique();
            $table->string('post_name');
            $table->integer('grade');
            $table->string('type')->nullable();
            $table->date('exam_date')->nullable();
            $table->date('rp_date')->nullable();
            $table->integer('total_candidate')->nullable();
            $table->integer('present_candidate')->nullable();
            $table->string('rp_status')->nullable();
            $table->boolean('is_current')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
