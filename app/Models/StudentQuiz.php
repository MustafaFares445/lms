<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\CarbonInterface;

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
        'quiz_id',
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
            'student_id' => 'integer',
            'quiz_id' => 'integer',
            'solved_questions' => 'integer',
            'total_questions' => 'integer',
            'time_taked' => 'datetime'
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
     * @return BelongsTo<Quiz, StudentQuiz>
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
