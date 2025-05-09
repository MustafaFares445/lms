<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\CarbonInterface;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read string $name
 * @property-read string $email
 * @property-read string $phone
 * @property-read string $password
 * @property-read CarbonInterface|null $email_verified_at
 * @property-read CarbonInterface|null $phone_verified_at
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface|null $updated_at
 */
class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable , InteractsWithMedia , HasRoles , HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'is_banned',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean'
        ];
    }

    /**
     * Check if the user's phone is verified.
     *
     * @return bool
     */
    public function isPhoneVerified(): bool
    {
        return $this->phone_verified_at !== null;
    }

    /**
     * Get the student associated with the user.
     *
     * @return HasOne<Student , self>
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Get the teacher associated with the user.
     *
     * @return HasOne<Teacher , self>
     */
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }
}
