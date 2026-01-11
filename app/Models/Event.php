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

        static::updating(function ($event) {
            if ($event->isDirty('title') && empty($event->slug)) {
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
     * Alias para creator (para compatibilidade com código existente)
     */
    public function user()
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
     * Relação 1:N - Inscrições confirmadas apenas
     */
    public function confirmedRegistrations()
    {
        return $this->hasMany(Registration::class)->where('status', 'confirmed');
    }

    /**
     * Relação 1:N - Inscrições pendentes
     */
    public function pendingRegistrations()
    {
        return $this->hasMany(Registration::class)->where('status', 'pending');
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
     * Scope para eventos passados
     */
    public function scopePast($query)
    {
        return $query->where('start_date', '<', now());
    }

    /**
     * Scope para eventos de hoje
     */
    public function scopeToday($query)
    {
        return $query->whereDate('start_date', today());
    }

    /**
     * Scope para eventos em destaque
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope para eventos por categoria
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope para pesquisa por título
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
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
     * Accessor para total de inscritos confirmados
     */
    public function getConfirmedCountAttribute()
    {
        return $this->registrations()->where('status', 'confirmed')->count();
    }

    /**
     * Accessor para percentagem de ocupação
     */
    public function getOccupancyPercentageAttribute()
    {
        if ($this->max_participants == 0) {
            return 0;
        }
        return round(($this->confirmed_count / $this->max_participants) * 100, 2);
    }

    /**
     * Verificar se o evento é gratuito
     */
    public function getIsFreeAttribute()
    {
        return $this->price == 0;
    }

    /**
     * Verificar se o evento já passou
     */
    public function getIsPastAttribute()
    {
        return $this->start_date < now();
    }

    /**
     * Verificar se o evento é hoje
     */
    public function getIsTodayAttribute()
    {
        return $this->start_date->isToday();
    }

    /**
     * Verificar se o evento é amanhã
     */
    public function getIsTomorrowAttribute()
    {
        return $this->start_date->isTomorrow();
    }

    /**
     * Verificar se um utilizador está inscrito neste evento
     */
    public function isUserRegistered($userId)
    {
        return $this->registrations()
                    ->where('user_id', $userId)
                    ->exists();
    }

    /**
     * Verificar se um utilizador está inscrito e confirmado
     */
    public function isUserConfirmed($userId)
    {
        return $this->registrations()
                    ->where('user_id', $userId)
                    ->where('status', 'confirmed')
                    ->exists();
    }

    /**
     * Obter a inscrição de um utilizador específico
     */
    public function getUserRegistration($userId)
    {
        return $this->registrations()
                    ->where('user_id', $userId)
                    ->first();
    }

    /**
     * Formatar o preço
     */
    public function getFormattedPriceAttribute()
    {
        if ($this->is_free) {
            return 'Gratuito';
        }
        return number_format($this->price, 2, ',', '.') . ' €';
    }

    /**
     * Obter URL da imagem ou placeholder
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/event-placeholder.jpg');
    }

    /**
     * Formatar data de início
     */
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date->format('d/m/Y H:i');
    }

    /**
     * Formatar data de fim
     */
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('d/m/Y H:i') : null;
    }

    /**
     * Obter duração do evento em horas
     */
    public function getDurationInHoursAttribute()
    {
        if (!$this->end_date) {
            return null;
        }
        return $this->start_date->diffInHours($this->end_date);
    }

    /**
     * Status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'published' => 'green',
            'draft' => 'gray',
            'cancelled' => 'red',
            default => 'blue',
        };
    }

    /**
     * Status traduzido
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'published' => 'Publicado',
            'draft' => 'Rascunho',
            'cancelled' => 'Cancelado',
            default => ucfirst($this->status),
        };
    }
}