<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a student user
        $student = User::create([
            'name' => 'Student',
            'username' => 'student',
            'email' => 'student@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'is_banned' => false,
        ]);

        $student->assignRole('student');

        // Add a fake image to the student user
        $student->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('images');

        // Create a teacher user
        $teacher =  User::create([
            'name' => 'Teacher',
            'username' => 'teacher',
            'email' => 'teacher@example.com',
            'phone' => '0987654321',
            'password' => Hash::make('password'),
            'is_banned' => false,
        ]);

        $teacher->assignRole('teacher');

        // Add a fake image to the teacher user
        $teacher->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('images');

                  // Create a teacher user
        $teacher2 =  User::create([
            'name' => 'Teacher 2',
            'username' => 'teacher_2',
            'email' => 'teacher-2@example.com',
            'phone' => '0987654322',
            'password' => Hash::make('password'),
            'is_banned' => false,
        ]);

        $teacher2->assignRole('teacher');

        // Add a fake image to the teacher user
        $teacher2->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('images');
    }
}