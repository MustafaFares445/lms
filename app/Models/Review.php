<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Carbon\CarbonInterface;

/**
 * @property-read int $id
 * @property-read string $content
 * @property-read int $rating
 * @property-read int $user_id
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read User $user
 * @property-read Model $model
 */
class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'rating',
        'user_id'
    ];

    /**
     * Get the user that owns the Review.
     *
     * @return BelongsTo<User, Review>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent model.
     *
     * @return MorphTo<Model, Review>
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
