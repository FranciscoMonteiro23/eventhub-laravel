<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELAÇÕES
    public function createdEvents()
    {
        return $this->hasMany(Event::class);
    }

    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'registrations')
                    ->withPivot('status', 'payment_status', 'notes', 'attended_at')
                    ->withTimestamps();
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // MÉTODOS DE VERIFICAÇÃO (ADICIONA AQUI!)
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOrganizer()
    {
        return $this->role === 'organizer' || $this->isAdmin();
    }

    public function canCreateEvents()
    {
        return $this->isOrganizer();
    }

    public function isRegisteredForEvent($eventId)
    {
        return $this->registrations()
                    ->where('event_id', $eventId)
                    ->where('status', 'confirmed')
                    ->exists();
    }
}