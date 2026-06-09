<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAddon extends Model
{
    protected $fillable = ['booking_id', 'addon_name', 'category', 'quantity', 'unit_price', 'total_price'];
    protected $casts    = ['unit_price' => 'decimal:2', 'total_price' => 'decimal:2'];
    public function booking() { return $this->belongsTo(Booking::class); }
}
