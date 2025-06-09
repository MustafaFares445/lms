<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use App\Models\UserSaved;
use Illuminate\Database\Seeder;

class SavedCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::query()->first()->id;

        $coursesIds = Course::query()->pluck('id')->toArray();
        for($i = 0 ; $i<= 10 ; $i++){
            UserSaved::query()->create([
                'user_id' => $userId,
                'saveable_id' => $coursesIds[array_rand($coursesIds)],
                'saveable_type' => Course::class ,
            ]);
        }

        $quizzesIds = Quiz::query()->pluck('id')->toArray();
        for($i = 0 ; $i<= 10 ; $i++){
            UserSaved::query()->create([
                'user_id' => $userId,
                'saveable_id' => $quizzesIds[array_rand($quizzesIds)],
                'saveable_type' => Quiz::class ,
            ]);
        }
    }
}
