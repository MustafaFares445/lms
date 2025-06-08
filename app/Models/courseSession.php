<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class CourseSession
 *
 * Represents a session within a course, including details like title, teacher, and time.
 */
class CourseSession extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'course_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'teacher_id',
        'course_id',
        'type',
        'note',
        'time',
        'like',
        'dislike',
        'order'
    ];

    /**
     * Get the teacher associated with the session.
     *
     * @return BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the course associated with the session.
     *
     * @return BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
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
}
