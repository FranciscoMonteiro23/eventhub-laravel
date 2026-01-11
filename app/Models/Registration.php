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
        'registration_date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'registration_date' => 'datetime',
    ];

    /**
     * Relação: Inscrição pertence a um User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relação: Inscrição pertence a um Event
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}