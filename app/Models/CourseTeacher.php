<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\CarbonInterface;

/**
 * @property-read int $id
 * @property-read int $teacher_id
 * @property-read int $course_id
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read Teacher $teacher
 * @property-read Course $course
 */
class CourseTeacher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'course_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'teacher_id' => 'integer',
            'course_id' => 'integer',
        ];
    }

    /**
     * Get the teacher that owns the CourseTeacher.
     *
     * @return BelongsTo<Teacher, CourseTeacher>
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the course that owns the CourseTeacher.
     *
     * @return BelongsTo<Course, CourseTeacher>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
