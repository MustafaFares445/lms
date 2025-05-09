<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Review;
use Carbon\CarbonInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string|null $notes
 * @property-read int $course_id
 * @property-read int $order
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read Course $course
 * @property-read Collection<Review> $reviews
 * @property-read Quiz $quiz
 */
class Lecture extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia , Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'notes',
        'course_id',
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
            'course_id' => 'integer',
            'order' => 'integer',
        ];
    }

     /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the course that owns the Lecture.
     *
     * @return BelongsTo<Course, Lecture>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the reviews associated with the lecture.
     *
     * @return MorphMany<Review, self>
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'model');
    }

    /**
     * Get the related model.
     *
     * @return MorphOne<Quiz>
     */
    public function quiz(): MorphOne
    {
        return $this->morphOne(Quiz::class, 'model');
    }
}
