<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
/**
 * @property-read int $id
 * @property-read string $name
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 * @property-read Collection<Subject> $subjects
 */
class University extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UniversityFactory> */
    use HasFactory, InteractsWithMedia , Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

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
     * Get the subjects associated with the university.
     *
     * @return HasMany<Subject, University>
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
