<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'type', 'description', 'short_description', 'address', 'city', 'country',
        'latitude', 'longitude', 'capacity_min', 'capacity_max',
        'base_price_per_hour', 'base_price_half_day', 'base_price_full_day',
        'currency', 'images', 'cover_image_url', 'rating', 'total_reviews',
        'is_active', 'is_featured', 'rules',
    ];

    protected $casts = [
        'images'       => 'array',
        'rules'        => 'array',
        'is_active'    => 'boolean',
        'is_featured'  => 'boolean',
        'latitude'     => 'decimal:7',
        'longitude'    => 'decimal:7',
    ];

    public function amenities() { return $this->hasMany(VenueAmenity::class); }
    public function addons()    { return $this->hasMany(VenueAddon::class); }
    public function slots()     { return $this->hasMany(VenueSlot::class); }
    public function bookings()  { return $this->morphMany(Booking::class, 'bookable'); }
}
