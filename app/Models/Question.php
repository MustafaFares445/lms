<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read int $quiz_id
 * @property-read string $type
 * @property-read int $order
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read Quiz $quiz
 */
class Question extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'quizable_id',
        'quizable_type',
        'type',
        'order',
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
            'quiz_id' => 'integer',
            'order' => 'integer',
        ];
    }

    /**
     * Get the quiz that owns the Question.
     *
     * @return BelongsTo<Quiz, Question>
     */
    public function quizable(): BelongsTo
    {
        return $this->morphTo();
    }

    public function answers() : HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
