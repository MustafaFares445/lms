<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSession;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::query()->first()->id;
        $coursesSessionsIds = CourseSession::query()->pluck('id')->toArray();
        for($i = 0 ; $i<= 10 ; $i++){
            UserProgress::query()->create([
                'user_id' => $userId,
                'relatable_id' => $coursesSessionsIds[array_rand($coursesSessionsIds)],
                'relatable_type' => CourseSession::class,
                'complete' => rand(0 , 1),
                'last_time' => sprintf("%02d:%02d", rand(0, 23), rand(0, 59)),
            ]);
        }
    }
}
