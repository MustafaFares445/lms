<?php

namespace App\Models;

use App\Models\UserSaved;
use Carbon\CarbonInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string|null $description
 * @property-read int $year
 * @property-read int $semester
 * @property-read int $university_id
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read University $university
 * @property-read Collection<Quiz> $quizes
 */
class Subject extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'year',
        'semester',
        'university_id',
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
            'year' => 'integer',
            'semester' => 'integer',
            'university_id' => 'integer',
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
     * Get the university that owns the subject.
     *
     * @return BelongsTo<University, Subject>
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    /**
     * Get the quizzes associated with the subject.
     *
     * @return HasMany<Quiz, Subject>
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

        /**
     * Get the subjects associated with the course.
     *
     * @return MorphMany<UserSaved , self>
     */
    public function userSaved() : MorphMany
    {
        return $this->morphMany(UserSaved::class , 'saveable');
    }
}
