<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'make', 'model', 'year', 'color', 'license_plate', 'category',
        'passenger_capacity', 'hourly_rate', 'daily_rate', 'airport_transfer_rate',
        'cover_image_url', 'images', 'features', 'status', 'current_driver_id', 'rating',
    ];

    protected $casts = [
        'images'   => 'array',
        'features' => 'array',
        'hourly_rate' => 'decimal:2',
        'daily_rate'  => 'decimal:2',
        'airport_transfer_rate' => 'decimal:2',
    ];

    public function driver()   { return $this->hasOne(Driver::class); }
    public function bookings() { return $this->morphMany(Booking::class, 'bookable'); }
}
