<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 * @property-read int $student_id
 * @property-read int $quiz_id
 * @property-read int $solved_questions
 * @property-read int $total_questions
 * @property-read CarbonInterface $time_taked
 * @property-read Student $student
 * @property-read Quiz $quiz
 */
class StudentQuiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'quizable_id',
        'quizable_type',
        'solved_questions',
        'total_questions',
        'time_taked'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'solved_questions' => 'integer',
            'total_questions' => 'integer',
        ];
    }

    /**
     * Get the student that owns the StudentQuiz.
     *
     * @return BelongsTo<Student, StudentQuiz>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the quiz that owns the StudentQuiz.
     *
     * @return MorphTo<Quiz, StudentQuiz>
     */
    public function quiz(): MorphTo
    {
        return $this->morphTo('quizable');
    }
}
