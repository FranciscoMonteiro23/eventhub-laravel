<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'payment_status',
        'notes',
        'attended_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'attended_at' => 'datetime',
    ];

    /**
     * Relação N:1 - Uma inscrição pertence a um utilizador
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relação N:1 - Uma inscrição pertence a um evento
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Scope para inscrições confirmadas
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope para inscrições pagas
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Verificar se fez check-in
     */
    public function getHasAttendedAttribute()
    {
        return !is_null($this->attended_at);
    }
}