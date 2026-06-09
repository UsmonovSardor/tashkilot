<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanionAvailability extends Model
{
    protected $fillable = ['companion_id', 'day_of_week', 'specific_date', 'available_from', 'available_until', 'is_blocked'];
    protected $casts    = ['is_blocked' => 'boolean', 'specific_date' => 'date'];
    public function companion() { return $this->belongsTo(Companion::class); }
}
