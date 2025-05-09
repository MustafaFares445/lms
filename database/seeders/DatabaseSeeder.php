<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\University;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      $this->call(RoleSeeder::class);
      $this->call(UniversitySeeder::class);
      $this->call(SubjectSeeder::class);
      $this->call(CourseSeeder::class);
      $this->call(UserSeeder::class);
      $this->call(StudentSeeder::class);
      $this->call(TeacherSeeder::class);
    }
}
