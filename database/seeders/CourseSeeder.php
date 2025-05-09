<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course1 = Course::create([
            'name' => 'Introduction to Programming',
            'slug' => 'introduction-to-programming',
            'summary' => 'Learn the basics of programming.',
            'description' => 'This course covers the fundamentals of programming using a popular language.',
            'duration' => 10.5,
            'likes' => 100,
            'dislikes' => 5,
            'end_date' => now()->addMonths(3),
            'year' => 2023,
            'section' => 1,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'full',
        ]);

        // Add a fake image to the first course
        $course1->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');

        $course2 = Course::create([
            'name' => 'Advanced Web Development',
            'slug' => 'advanced-web-development',
            'summary' => 'Take your web development skills to the next level.',
            'description' => 'This course covers advanced topics in web development, including frameworks and best practices.',
            'duration' => 15.0,
            'likes' => 150,
            'dislikes' => 10,
            'end_date' => now()->addMonths(6),
            'year' => 2023,
            'section' => 2,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'type' => 'partial',
        ]);

        // Add a fake image to the second course
        $course2->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('courses-images');
    }
}