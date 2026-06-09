<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanionSkill extends Model
{
    protected $fillable = ['companion_id', 'skill_name', 'category', 'description', 'years_experience'];
    public function companion() { return $this->belongsTo(Companion::class); }
}
