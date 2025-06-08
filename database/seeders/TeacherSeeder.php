<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = Teacher::create([
            'user_id' => User::query()->where('username' , 'teacher')->first()->id,
            'name' => 'teacher',
            'summary' => 'Experienced teacher in Mathematics.',
            'phone' => '1234567890',
            'whatsapp_phone' => '1234567890',
        ]);

        // Attach teacher to all courses
        $courses = Course::all();
        $teacher->courses()->attach($courses->pluck('id'));

        // Add a fake image using Spatie Media Library
        $teacher->addMediaFromUrl('https://picsum.photos/200/300')->toMediaCollection('courses-images');

        $teacher = Teacher::create([
            'user_id' => User::query()->where('username' , 'teacher')->first()->id,
            'name' => 'teacher-2',
            'summary' => 'Experienced teacher in Mathematics.',
            'phone' => '1234567890',
            'whatsapp_phone' => '1234567890',
            'rate' => 4.8
        ]);

        // Attach teacher to all courses
        $teacher->courses()->attach($courses->pluck('id'));

        // Add a fake image using Spatie Media Library
        $teacher->addMediaFromUrl('https://picsum.photos/200/300')->toMediaCollection('courses-images');
    }
}
