<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'email', 'password', 'role', 'status',
        'email_verified', 'phone', 'invitation_code', 'referred_by', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified' => 'boolean',
        'last_login_at'  => 'datetime',
    ];

    // JWT
    public function getJWTIdentifier(): mixed   { return $this->getKey(); }
    public function getJWTCustomClaims(): array { return ['role' => $this->role]; }

    // Relations
    public function profile()    { return $this->hasOne(UserProfile::class); }
    public function companion()  { return $this->hasOne(Companion::class); }
    public function driver()     { return $this->hasOne(Driver::class); }
    public function bookings()   { return $this->hasMany(Booking::class, 'client_id'); }
}
