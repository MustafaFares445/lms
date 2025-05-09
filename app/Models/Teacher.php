<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\Review;
use Carbon\CarbonInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read string $name
 * @property-read string $phone
 * @property-read string $whatsapp_phone
 * @property-read string $summary
 * @property-read float $rate
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 */
class Teacher extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'summary',
        'phone',
        'whatsapp_phone',
        'rate'
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
            'user_id' => 'integer',
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
                'source' => 'user.name'
            ]
        ];
    }


    /**
     * Get the user associated with the teacher.
     *
     * @return BelongsTo<User , self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the courses associated with the teacher.
     *
     * @return BelongsToMany<Course , self>
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    /**
     * Get the reviews associated with the teacher.
     *
     * @return MorphMany<Review , self>
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class , 'model');
    }
}
