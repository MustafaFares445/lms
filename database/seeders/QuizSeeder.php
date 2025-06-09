<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0 ; $i <= 10 ; $i++){
            Quiz::query()->create([
                'subject_id' => Subject::inRandomOrder()->first()->id,
                'title' => 'title ' . '' . $i,
                'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59)),
            ]);
        }
    }
}
