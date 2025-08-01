<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\UserProgress;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UniversitySeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(QuizSeeder::class);
        $this->call(CourseSessionSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(AnswerSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(SavedCourseSeeder::class);
        $this->call(UserProgressSeeder::class);
    }
}
