<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\CarbonInterface;

/**
 * @property-read int $id
 * @property-read int $student_id
 * @property-read int $course_id
 * @property-read int $quizez_percent
 * @property-read int $lectures_percent
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read Student $student
 * @property-read Course $course
 */
class CourseStudent extends Model
{
    use HasFactory;

    protected $table = 'course_student';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'quizez_percent',
        'lectures_percent',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'student_id' => 'integer',
            'course_id' => 'integer',
            'quizez_percent' => 'integer',
            'lectures_percent' => 'integer',
        ];
    }

    /**
     * Get the student that owns the CourseStudent.
     *
     * @return BelongsTo<Student, CourseStudent>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course that owns the CourseStudent.
     *
     * @return BelongsTo<Course, CourseStudent>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
