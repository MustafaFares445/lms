<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\CourseTeacher;
use App\Models\Teacher;

class CourseTeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseTeacher::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::factory(),
            'course_id' => Course::factory(),
        ];
    }
}
