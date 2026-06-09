<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'avatar_url', 'bio',
        'gender', 'date_of_birth', 'nationality', 'city', 'country', 'preferences',
    ];

    protected $casts = ['preferences' => 'array', 'date_of_birth' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
}
