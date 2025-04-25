<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\CarbonInterface;

/**
 * @property-read int $id
 * @property-read int $student_quiz_id
 * @property-read int $answer_id
 * @property-read int $question_id
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read StudentQuiz $studentQuiz
 * @property-read Answer $answer
 * @property-read Question $question
 */
class StudentQuizAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_quiz_id',
        'answer_id',
        'question_id',
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
            'student_quiz_id' => 'integer',
            'answer_id' => 'integer',
            'question_id' => 'integer',
        ];
    }

    /**
     * Get the student quiz that owns the answer.
     *
     * @return BelongsTo<StudentQuiz, StudentQuizAnswer>
     */
    public function studentQuiz(): BelongsTo
    {
        return $this->belongsTo(StudentQuiz::class);
    }

    /**
     * Get the answer associated with the student quiz answer.
     *
     * @return BelongsTo<Answer, StudentQuizAnswer>
     */
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }

    /**
     * Get the question associated with the student quiz answer.
     *
     * @return BelongsTo<Question, StudentQuizAnswer>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
