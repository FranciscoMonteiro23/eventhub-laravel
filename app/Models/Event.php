<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'location',
        'image',
        'start_date',
        'end_date',
        'max_participants',
        'price',
        'status',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    /**
     * Boot method para gerar slug automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    /**
     * Relação N:1 - Um evento pertence a um criador (User)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relação N:1 - Um evento pertence a uma categoria
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relação N:N - Um evento tem muitos participantes (Users)
     * através da tabela registrations
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'registrations')
                    ->withPivot('status', 'payment_status', 'notes', 'attended_at')
                    ->withTimestamps();
    }

    /**
     * Relação 1:N - Um evento tem muitas inscrições
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Scope para eventos publicados
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope para eventos futuros
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    /**
     * Accessor para verificar se o evento está cheio
     */
    public function getIsFullAttribute()
    {
        return $this->registrations()->where('status', 'confirmed')->count() >= $this->max_participants;
    }

    /**
     * Accessor para vagas disponíveis
     */
    public function getAvailableSpotsAttribute()
    {
        $confirmed = $this->registrations()->where('status', 'confirmed')->count();
        return max(0, $this->max_participants - $confirmed);
    }

    /**
     * Verificar se o evento é gratuito
     */
    public function getIsFreeAttribute()
    {
        return $this->price == 0;
    }
}