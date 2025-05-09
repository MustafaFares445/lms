<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = Student::create([
            'name' => 'student',
            'user_id' => User::query()->where('username' , 'student')->first()->id,
            'student_number' => '123456',
            'university_id' => 1,
            'gender' => 'Male',
            'birth' => '2000-01-01',
        ]);

        $student->courses()->attach([Course::query()->first()->id]);

        // Add a fake image using Spatie Media Library
        $student->addMediaFromUrl('https://picsum.photos/200/300')
                ->toMediaCollection('students-images');
    }
}
