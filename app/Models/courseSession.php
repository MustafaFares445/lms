<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CourseSession extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    // Define the table associated with the model
    protected $table = 'course_sessions';

    // Define the fillable attributes
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

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
