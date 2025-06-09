<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\Question;
use App\Models\UserSaved;
use Carbon\CarbonInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'title',
        'time',
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
     * Get the questions associated with the session.
     *
     * This method defines a polymorphic one-to-many relationship between the CourseSession
     * and the Question model, allowing a session to have multiple questions.
     *
     * @return MorphMany
     */
    public function questions() : MorphMany
    {
        return $this->morphMany(Question::class , 'quizable');
    }

    /**
     * Get the user Saved associated with the quiz.
     *
     * @return MorphMany<UserSaved , self>
     */
    public function userSaved() : MorphMany
    {
        return $this->morphMany(UserSaved::class , 'saveable');
    }
}
