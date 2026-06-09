<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id', 'payer_id', 'amount', 'currency', 'status', 'payment_method',
        'gateway_payment_id', 'gateway_customer_id', 'gateway_metadata', 'captured_at', 'failed_at', 'failure_reason',
    ];

    protected $casts = [
        'gateway_metadata' => 'array',
        'captured_at'      => 'datetime',
        'failed_at'        => 'datetime',
        'amount'           => 'decimal:2',
    ];

    public function booking() { return $this->belongsTo(Booking::class); }
    public function payer()   { return $this->belongsTo(User::class, 'payer_id'); }
    public function escrow()  { return $this->hasOne(EscrowTransaction::class); }
}
