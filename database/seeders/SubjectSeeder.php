<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\University;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'name' => 'Mathematics',
            'description' => 'Introduction to basic mathematics concepts.',
            'year' => 1,
            'semester' => 1,
            'university_id' => University::query()->first()->id,
        ]);

        Subject::create([
            'name' => 'Physics',
            'description' => 'Fundamentals of physics.',
            'year' => 1,
            'semester' => 2,
            'university_id' => University::query()->first()->id,
        ]);

        // Add more subjects as needed
    }
}