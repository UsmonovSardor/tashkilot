<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanionLanguage extends Model
{
    protected $fillable = ['companion_id', 'language', 'proficiency'];
    public function companion() { return $this->belongsTo(Companion::class); }
}
