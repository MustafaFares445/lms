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
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('teacher_id')->constrained('teachers')->references('id');
            $table->foreignId('course_id')->constrained('courses')->references('id');
            $table->text('note')->nullable();
            $table->time('time');
            $table->unsignedBigInteger('like')->default(0);
            $table->unsignedBigInteger('disLike')->default(0);
            $table->enum('type' , ['session' , 'quiz']);
            $table->unsignedInteger('order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sessions');
    }
};
