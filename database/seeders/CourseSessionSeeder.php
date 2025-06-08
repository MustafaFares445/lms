<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseSession;
use App\Models\Teacher;

class CourseSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the number of sessions you want to create
        $numberOfSessions = 100;

        // Loop to create the sessions
        for ($i = 1; $i <= $numberOfSessions; $i++) {
            $types = ['quiz', 'session'];
            $type = $types[array_rand($types)];
            CourseSession::query()->create([
                'title' => $type . ' ' . $i,
                'teacher_id' => Teacher::inRandomOrder()->first()->id, // Assuming you have 5 teachers
                'course_id' => Course::inRandomOrder()->first()->id, // Assuming you have 5 courses
                'note' => 'This is a note for session ' . $i,
                'time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59)),
                'type' => $type,
                'like' => rand(10 , 100),
                'disLike' => rand(10 , 100),
                'order' => rand(1 , 20),
            ]);
        }
    }
}
