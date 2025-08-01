<?php

namespace App\Models;

use App\Models\Review;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\UserSaved;
use Carbon\CarbonInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $summary
 * @property-read string $description
 * @property-read float $duration
 * @property-read int $likes
 * @property-read int $dislikes
 * @property-read CarbonInterface|null $end_date
 * @property-read int $year
 * @property-read string $type
 * @property-read int $section
 * @property-read int $subject_id
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read Subject $subject
 * @property-read Collection<Review> $reviews
 * @property-read Collection<Student> $students
 * @property-read Collection<Teacher> $teachers
 */
class Course extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'summary',
        'description',
        'duration',
        'likes',
        'dislikes',
        'end_date',
        'year',
        'section',
        'subject_id',
        'type',
        'discount',
        'price',
        'rating',
        'time'
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
            'duration' => 'float',
            'likes' => 'integer',
            'dislikes' => 'integer',
            'end_date' => 'datetime',
            'section' => 'integer',
            'subject_id' => 'integer',
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
     * Get the subject associated with the course.
     *
     * @return BelongsTo<Subject, self>
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the course sessions associated with the course.
     *
     * @return HasMany<CourseSession>
     */
    public function courseSessions()
    {
        return $this->hasMany(CourseSession::class);
    }

    /**
     * Get the course sessions associated with the course.
     *
     * @return HasMany<CourseSession>
     */
    public function quizez()
    {
        return $this->hasMany(CourseSession::class)->where('type' , 'quiz');
    }

    /**
     * Get the reviews associated with the course.
     *
     * @return MorphMany<Review , self>
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class , 'model');
    }

    /**
     * Get the reviews associated with the course.
     *
     * @return MorphMany<UserSaved , self>
     */
    public function userSaved() : MorphMany
    {
        return $this->morphMany(UserSaved::class , 'saveable');
    }
    
    /**
     * Get the students associated with the course.
     *
     * @return BelongsToMany<Student , self>
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withPivot(['lectures_percent' , 'quizez_percent']);
    }

    /**
     * Get the teachers associated with the course.
     *
     * @return BelongsToMany<Teacher , self>
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }
}
