<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ========================================
    // RELAÇÕES
    // ========================================

    /**
     * Relação 1:N - User cria muitos Events (como organizador)
     */
    public function createdEvents()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Relação N:N - User está registado em muitos Events
     * através da tabela registrations
     */
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'registrations')
                    ->withPivot('status', 'payment_status', 'notes', 'attended_at')
                    ->withTimestamps();
    }

    /**
     * Relação 1:N - User tem muitas Registrations (inscrições)
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

    // ========================================
    // MÉTODOS DE VERIFICAÇÃO DE ROLE
    // ========================================

    /**
     * Verificar se o user é Admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Verificar se o user é Organizer
     * (Admin também conta como Organizer)
     */
    public function isOrganizer()
    {
        return $this->role === 'organizer' || $this->isAdmin();
    }

    /**
     * Verificar se o user é Participant
     */
    public function isParticipant()
    {
        return $this->role === 'participant';
    }

    /**
     * Verificar se o user pode criar eventos
     */
    public function canCreateEvents()
    {
        return $this->isOrganizer();
    }

    /**
     * Verificar se o user pode gerir categorias
     */
    public function canManageCategories()
    {
        return $this->isAdmin();
    }

    /**
     * Verificar se o user pode editar um evento específico
     */
    public function canEditEvent(Event $event)
    {
        return $this->isAdmin() || $event->user_id === $this->id;
    }

    /**
     * Verificar se o user pode apagar um evento específico
     */
    public function canDeleteEvent(Event $event)
    {
        return $this->isAdmin() || $event->user_id === $this->id;
    }

    // ========================================
    // MÉTODOS DE INSCRIÇÕES
    // ========================================

    /**
     * Verificar se o user está inscrito num evento
     */
    public function isRegisteredForEvent($eventId)
    {
        return $this->registrations()
                    ->where('event_id', $eventId)
                    ->exists();
    }

    /**
     * Verificar se o user está confirmado num evento
     */
    public function isConfirmedForEvent($eventId)
    {
        return $this->registrations()
                    ->where('event_id', $eventId)
                    ->where('status', 'confirmed')
                    ->exists();
    }

    /**
     * Obter a inscrição do user num evento específico
     */
    public function getRegistrationForEvent($eventId)
    {
        return $this->registrations()
                    ->where('event_id', $eventId)
                    ->first();
    }

    /**
     * Obter todos os eventos futuros onde o user está inscrito
     */
    public function upcomingRegisteredEvents()
    {
        return $this->registeredEvents()
                    ->where('start_date', '>', now())
                    ->where('registrations.status', 'confirmed')
                    ->orderBy('start_date', 'asc');
    }

    /**
     * Obter todos os eventos passados onde o user esteve inscrito
     */
    public function pastRegisteredEvents()
    {
        return $this->registeredEvents()
                    ->where('start_date', '<', now())
                    ->where('registrations.status', 'confirmed')
                    ->orderBy('start_date', 'desc');
    }

    // ========================================
    // ACCESSORS (GETTERS)
    // ========================================

    /**
     * Obter o nome da role formatado
     */
    public function getRoleLabelAttribute()
    {
        return match($this->role) {
            'admin' => 'Administrador',
            'organizer' => 'Organizador',
            'participant' => 'Participante',
            default => ucfirst($this->role),
        };
    }

    /**
     * Obter cor do badge da role
     */
    public function getRoleColorAttribute()
    {
        return match($this->role) {
            'admin' => 'red',
            'organizer' => 'blue',
            'participant' => 'green',
            default => 'gray',
        };
    }

    /**
     * Obter URL do avatar ou placeholder
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        // Placeholder com iniciais
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Obter iniciais do nome
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Total de eventos criados
     */
    public function getTotalCreatedEventsAttribute()
    {
        return $this->createdEvents()->count();
    }

    /**
     * Total de eventos onde está inscrito (confirmado)
     */
    public function getTotalRegisteredEventsAttribute()
    {
        return $this->confirmedRegistrations()->count();
    }

    /**
     * Total de inscrições pendentes
     */
    public function getTotalPendingRegistrationsAttribute()
    {
        return $this->pendingRegistrations()->count();
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Scope para filtrar apenas admins
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope para filtrar apenas organizadores
     */
    public function scopeOrganizers($query)
    {
        return $query->where('role', 'organizer');
    }

    /**
     * Scope para filtrar apenas participantes
     */
    public function scopeParticipants($query)
    {
        return $query->where('role', 'participant');
    }

    /**
     * Scope para pesquisar users por nome ou email
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
    }

    // ========================================
    // MÉTODOS AUXILIARES
    // ========================================

    /**
     * Verificar se o user pode inscrever-se num evento
     */
    public function canRegisterForEvent(Event $event)
    {
        // Não pode ser o criador do evento
        if ($event->user_id === $this->id) {
            return false;
        }

        // Não pode já estar inscrito
        if ($this->isRegisteredForEvent($event->id)) {
            return false;
        }

        // O evento não pode estar cheio
        if ($event->is_full) {
            return false;
        }

        // O evento não pode ter passado
        if ($event->start_date < now()) {
            return false;
        }

        return true;
    }

    /**
     * Verificar se o user pode cancelar inscrição num evento
     */
    public function canCancelRegistrationForEvent(Event $event)
    {
        // Tem de estar inscrito
        if (!$this->isRegisteredForEvent($event->id)) {
            return false;
        }

        // O evento não pode ter passado
        if ($event->start_date < now()) {
            return false;
        }

        return true;
    }

    /**
     * Estatísticas do user
     */
    public function getStatsAttribute()
    {
        return [
            'created_events' => $this->total_created_events,
            'registered_events' => $this->total_registered_events,
            'pending_registrations' => $this->total_pending_registrations,
        ];
    }
}