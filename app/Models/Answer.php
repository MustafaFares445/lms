<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\CarbonInterface;

/**
 * @property-read int $id
 * @property-read string $content
 * @property-read int $question_id
 * @property-read bool $correct
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read Question $question
 */
class Answer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'question_id',
        'correct',
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
            'question_id' => 'integer',
            'correct' => 'boolean',
        ];
    }

    /**
     * Get the question that owns the Answer.
     *
     * @return BelongsTo<Question, Answer>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
