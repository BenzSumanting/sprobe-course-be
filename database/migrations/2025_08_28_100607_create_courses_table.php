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
        Schema::create('courses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('credits')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignUlid('student_id')->references('id')->on('students');
            $table->foreignUlid('course_id')->references('id')->on('courses');
            $table->date('enrollment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('courses');
    }
};
