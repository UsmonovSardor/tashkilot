<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueAmenity extends Model
{
    protected $fillable = ['venue_id', 'name', 'icon'];
    public function venue() { return $this->belongsTo(Venue::class); }
}
