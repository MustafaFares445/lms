<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read string $name
 * @property-read string $gender
 * @property-read string $birth
 * @property-read string $student_number
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read University $university
 * @property-read Collection<StudentQuiz> $quizzes
 * @property-read Collection<Course> $courses
 * @property-read Collection<Course> $savedCourses
 */
class Student extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'student_number',
        'university_id',
        'gender',
        'birth',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'user_id' => 'integer',
        ];
    }

    /**
     * Get the user associated with the student.
     *
     * @return BelongsTo<User , self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user associated with the student.
     *
     * @return BelongsTo<User , self>
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    /**
     * Get the courses associated with the student.
     *
     * @return BelongsToMany<Course , self>
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    /**
     * Get the saved courses associated with the student.
     *
     * @return BelongsToMany<Course , self>
     */
    public function savedCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class , SavedCourse::class);
    }

    /**
     * Get the quizzes associated with the student.
     *
     * @return BelongsToMany<Quiz , self>
     */
    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class , StudentQuiz::class);
    }
}
