<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowTransaction extends Model
{
    protected $fillable = [
        'payment_id', 'booking_id', 'provider_id', 'held_amount', 'platform_fee',
        'provider_payout', 'state', 'held_at', 'release_scheduled_at', 'released_at',
        'refunded_at', 'stripe_transfer_id', 'stripe_refund_id', 'admin_notes',
    ];

    protected $casts = [
        'held_at'              => 'datetime',
        'release_scheduled_at' => 'datetime',
        'released_at'          => 'datetime',
        'refunded_at'          => 'datetime',
        'held_amount'          => 'decimal:2',
        'platform_fee'         => 'decimal:2',
        'provider_payout'      => 'decimal:2',
    ];

    public function payment()  { return $this->belongsTo(Payment::class); }
    public function booking()  { return $this->belongsTo(Booking::class); }
    public function provider() { return $this->belongsTo(User::class, 'provider_id'); }
}
