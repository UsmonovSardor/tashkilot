<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'age', 'is_verified', 'is_featured', 'photos_blurred',
        'hourly_rate', 'half_day_rate', 'full_day_rate', 'availability_status',
        'rating', 'total_reviews', 'total_bookings', 'headline', 'full_bio',
        'event_types', 'ai_embedding', 'verified_at',
    ];

    protected $casts = [
        'is_verified'    => 'boolean',
        'is_featured'    => 'boolean',
        'photos_blurred' => 'boolean',
        'event_types'    => 'array',
        'ai_embedding'   => 'array',
        'hourly_rate'    => 'decimal:2',
        'half_day_rate'  => 'decimal:2',
        'full_day_rate'  => 'decimal:2',
        'rating'         => 'decimal:2',
        'verified_at'    => 'datetime',
    ];

    public function user()         { return $this->belongsTo(User::class); }
    public function languages()    { return $this->hasMany(CompanionLanguage::class); }
    public function skills()       { return $this->hasMany(CompanionSkill::class); }
    public function photos()       { return $this->hasMany(CompanionPhoto::class)->orderBy('sort_order'); }
    public function availability() { return $this->hasMany(CompanionAvailability::class); }
    public function bookings()     { return $this->morphMany(Booking::class, 'bookable'); }
}
