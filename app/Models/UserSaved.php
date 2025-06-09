<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSaved extends Model
{
    protected $fillable = [
        'user_id',
        'saveable_id',
        'saveable_type'
    ];

    public function saveable()
    {
        return $this->morphTo();
    }
}
