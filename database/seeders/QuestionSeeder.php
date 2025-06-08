<?php

namespace Database\Seeders;

use App\Models\CourseSession;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the number of sessions you want to create
        $numberOfSessions = 25;

        $coursesSessionsIds = CourseSession::query()->where('type' , 'quiz')->pluck('id')->toArray();

        // Loop to create the sessions
        for ($i = 1; $i <= $numberOfSessions; $i++) {
            $types = ['one', 'multi'];
            $type = $types[array_rand($types)];
            $question = Question::query()->create([
                'title' => 'Question ' . $i,
                'quizable_id' => $coursesSessionsIds[array_rand($coursesSessionsIds)],
                'quizable_type' => CourseSession::class ,
                'type' => $type,
                'order' => rand(1 , 20),
            ]);

            // Add a fake image URL using Spatie Media Library
            $question->addMediaFromUrl('https://picsum.photos/200/300')
                     ->toMediaCollection('images');
        }
    }
}
