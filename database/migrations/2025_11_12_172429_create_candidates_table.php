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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_id');
            $table->string('post_code');
            $table->string('reg_number');
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->string('dob')->nullable();
            $table->string('district')->nullable();
            $table->string('center_code')->nullable();
            $table->timestamps();
            $table->index(['reg_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
