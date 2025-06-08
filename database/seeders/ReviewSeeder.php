<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSession;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Teacher;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {

        // Get some user IDs to associate with reviews
        $userIds = User::pluck('id')->toArray();
        $teachersIds = Teacher::pluck('id')->toArray();
        $coursesIds = Course::pluck('id')->toArray();
        $coursesSessionsIds = CourseSession::query()->where('type' , 'session')->pluck('id')->toArray();

        // Define the number of sessions you want to create
        $numberOfSessions = 100;

        // Loop to create the sessions
        for ($i = 1; $i <= $numberOfSessions; $i++) {
            Review::query()->create([
                'user_id' => $userIds[array_rand($userIds)],
                'model_type' => Teacher::class,
                'model_id' => $teachersIds[array_rand($teachersIds)],
                'content' => 'Great teacher!',
                'rating' => 5,
            ]);
        }

         // Loop to create the sessions
         for ($i = 1; $i <= $numberOfSessions; $i++) {
            Review::query()->create( [
                'user_id' => $userIds[array_rand($userIds)],
                'model_type' => Course::class,
                'model_id' => $coursesIds[array_rand($coursesIds)],
                'content' => 'Very informative course.',
                'rating' => 4,
            ],);
        }


          // Loop to create the sessions
          for ($i = 1; $i <= $numberOfSessions; $i++) {
            Review::query()->create( [
                'user_id' => $userIds[array_rand($userIds)],
                'model_type' => CourseSession::class,
                'model_id' => $coursesSessionsIds[array_rand($coursesSessionsIds)],
                'content' => 'Very good session.',
                'rating' => 4,
            ],);
        }
    }
}