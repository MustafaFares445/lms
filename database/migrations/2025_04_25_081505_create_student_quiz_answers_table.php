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
        Schema::disableForeignKeyConstraints();

        Schema::create('student_quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_quiz_id')->constrained('student_quizzes');
            $table->foreignId('answer_id')->constrained('answers');
            $table->foreignId('question_id')->constrained('questions');
            $table->index('student_quiz_id');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_quiz_answers');
    }
};
