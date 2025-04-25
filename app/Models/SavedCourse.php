<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 * @property-read int $student_id
 * @property-read int $course_id
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 */
class SavedCourse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
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
            'student_id' => 'integer',
            'course_id' => 'integer',
        ];
    }

    /**
     * Get the student associated with the saved course.
     *
     * @return BelongsTo<Student , self>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course associated with the saved course.
     *
     * @return BelongsTo<Course , self>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
