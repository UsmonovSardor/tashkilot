<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueSlot extends Model
{
    protected $fillable = ['venue_id', 'date', 'start_time', 'end_time', 'status', 'price_override', 'booking_id'];
    protected $casts    = ['date' => 'date', 'price_override' => 'decimal:2'];
    public function venue()   { return $this->belongsTo(Venue::class); }
    public function booking() { return $this->belongsTo(Booking::class); }
}
