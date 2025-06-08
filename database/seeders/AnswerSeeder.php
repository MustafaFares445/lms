<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $number = 50;
        $questionsIds = Question::query()->pluck('id')->toArray();


        for ($i = 1; $i <= $number; $i++) {
            Answer::create([
                'content' => 'This is a sample answer.',
                'question_id' => $questionsIds[array_rand($questionsIds)],
                'correct' => random_int(0 , 1),
            ]);
        }
    }
}
