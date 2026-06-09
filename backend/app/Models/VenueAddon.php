<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueAddon extends Model
{
    protected $fillable = ['venue_id', 'name', 'description', 'price', 'pricing_type', 'is_active'];
    protected $casts    = ['is_active' => 'boolean', 'price' => 'decimal:2'];
    public function venue() { return $this->belongsTo(Venue::class); }
}
