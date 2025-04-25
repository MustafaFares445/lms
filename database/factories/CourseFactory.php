<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Subject;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'summary' => fake()->text(),
            'description' => fake()->text(),
            'duration' => fake()->randomFloat(0, 0, 9999999999.),
            'likes' => fake()->randomNumber(),
            'dislikes' => fake()->randomNumber(),
            'end_date' => fake()->dateTime(),
            'year' => fake()->numberBetween(-1000, 1000),
            'section' => fake()->numberBetween(-1000, 1000),
            'subject_id' => Subject::factory(),
        ];
    }
}
