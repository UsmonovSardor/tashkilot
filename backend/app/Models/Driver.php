<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'vehicle_id', 'license_number', 'license_class', 'experience_years',
        'rating', 'total_trips', 'languages', 'is_available', 'is_verified',
        'avatar_url', 'bio', 'certifications',
    ];

    protected $casts = [
        'languages'      => 'array',
        'certifications' => 'array',
        'is_available'   => 'boolean',
        'is_verified'    => 'boolean',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function vehicle() { return $this->belongsTo(Vehicle::class); }
}
