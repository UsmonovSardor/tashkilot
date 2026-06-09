<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanionPhoto extends Model
{
    protected $fillable = ['companion_id', 'original_url', 'blurred_url', 'thumbnail_url', 'is_primary', 'is_verified', 'sort_order'];
    protected $casts    = ['is_primary' => 'boolean', 'is_verified' => 'boolean'];
    public function companion() { return $this->belongsTo(Companion::class); }
}
