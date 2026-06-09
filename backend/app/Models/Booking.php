<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference', 'client_id', 'booking_type', 'bookable_type', 'bookable_id',
        'driver_id', 'starts_at', 'ends_at', 'duration_hours',
        'base_amount', 'addons_amount', 'service_fee', 'tax_amount', 'total_amount',
        'currency', 'status', 'special_requests', 'event_details',
    ];

    protected $casts = [
        'starts_at'     => 'datetime',
        'ends_at'       => 'datetime',
        'event_details' => 'array',
        'base_amount'   => 'decimal:2',
        'total_amount'  => 'decimal:2',
    ];

    public function client()  { return $this->belongsTo(User::class, 'client_id'); }
    public function bookable(){ return $this->morphTo(); }
    public function driver()  { return $this->belongsTo(Driver::class); }
    public function addons()  { return $this->hasMany(BookingAddon::class); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function escrow()  { return $this->hasOne(EscrowTransaction::class); }
}
