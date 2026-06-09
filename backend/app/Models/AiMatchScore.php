<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiMatchScore extends Model
{
    protected $table    = 'ai_match_scores';
    protected $fillable = ['client_id', 'companion_id', 'score', 'event_type', 'matched_skills', 'matched_languages', 'computed_at'];
    protected $casts    = ['matched_skills' => 'array', 'matched_languages' => 'array', 'computed_at' => 'datetime', 'score' => 'decimal:4'];
}
