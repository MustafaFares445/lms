<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Cviebrock\EloquentSluggable\Sluggable;
/**
 * @property-read int $id
 * @property-read int $subject_id
 * @property-read string $name
 * @property-read int $duration
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read Subject $subject
 */
class Quiz extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject_id',
        'name',
        'duration',
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
            'subject_id' => 'integer',
            'duration' => 'time',
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
     * Get the subject that owns the Quiz.
     *
     * @return BelongsTo<Subject, Quiz>
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the related model.
     *
     * @return MorphTo<Model>
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
