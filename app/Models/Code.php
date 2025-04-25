<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\CarbonInterface;

/**
 * @property-read int $id
 * @property-read string $code
 * @property-read int $student_id
 * @property-read int $course_id
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read Student|null $student
 * @property-read Course $course
 *
 */
class Code extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
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
            'id' => 'integer',
            'student_id' => 'integer',
            'course_id' => 'integer',
        ];
    }

    /**
     * Get the student that owns the Code.
     *
     * @return BelongsTo<Student, Code>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course that owns the Code.
     *
     * @return BelongsTo<Course, Code>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
