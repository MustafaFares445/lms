<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Answer;
use App\Models\Question;
use App\Models\StudentQuiz;
use App\Models\StudentQuizAnswer;

class StudentQuizAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentQuizAnswer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'student_quiz_id' => StudentQuiz::factory(),
            'answer_id' => Answer::factory(),
            'question_id' => Question::factory(),
        ];
    }
}
