<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">Eventos</h2>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 80rem; margin: 0 auto;">
            
            <!-- Mensagens de Sucesso/Erro -->
            @if(session('success'))
                <div style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Botão Novo Evento (apenas Organizer/Admin) -->
            @if(Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                <div style="margin-bottom: 1rem;">
                    <a href="{{ route('events.create') }}" 
                       style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold; display: inline-block;">
                        + Novo Evento
                    </a>
                </div>
            @endif

            <div style="background: white; border-radius: 0.5rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                
                @if($events->count() > 0)
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 1rem; text-align: left; font-weight: bold;">Título</th>
                                <th style="padding: 1rem; text-align: left; font-weight: bold;">Categoria</th>
                                <th style="padding: 1rem; text-align: left; font-weight: bold;">Data</th>
                                <th style="padding: 1rem; text-align: center; font-weight: bold;">Vagas</th>
                                <th style="padding: 1rem; text-align: center; font-weight: bold;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 1rem;">
                                        <strong>{{ $event->title }}</strong>
                                        <br>
                                        <small style="color: #6b7280;">📍 {{ $event->location }}</small>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem;">
                                            {{ $event->category->name }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        {{ $event->start_date->format('d/m/Y H:i') }}
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        @php
                                            $registeredCount = $event->registrations()->where('status', 'confirmed')->count();
                                            $maxParticipants = $event->max_participants;
                                            $isFull = $registeredCount >= $maxParticipants;
                                        @endphp
                                        
                                        <span style="font-weight: bold; color: {{ $isFull ? '#ef4444' : '#10b981' }};">
                                            {{ $registeredCount }} / {{ $maxParticipants }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center; align-items: center; flex-wrap: wrap;">
                                            
                                            <!-- Botão Ver -->
                                            <a href="{{ route('events.show', $event) }}" 
                                               style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; display: inline-block;">
                                                👁️ Ver
                                            </a>

                                            <!-- Botão Participar (apenas se NÃO for o criador do evento) -->
                                            @if(Auth::id() !== $event->user_id && $event->start_date > now())
                                                @php
                                                    $isRegistered = $event->registrations()->where('user_id', Auth::id())->exists();
                                                @endphp

                                                @if($isRegistered)
                                                    <span style="background: #d1fae5; color: #065f46; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 600; display: inline-block;">
                                                        ✓ Inscrito
                                                    </span>
                                                @elseif($isFull)
                                                    <span style="background: #fee2e2; color: #991b1b; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 600; display: inline-block;">
                                                        ❌ Esgotado
                                                    </span>
                                                @else
                                                    <form action="{{ route('registrations.register', $event) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" 
                                                                style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 600; border: none; cursor: pointer; display: inline-block;"
                                                                onmouseover="this.style.background='#059669'" 
                                                                onmouseout="this.style.background='#10b981'">
                                                            🎫 Participar
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif

                                            <!-- Botão Editar (apenas criador do evento ou admin) -->
                                            @if(Auth::user()->role === 'admin' || Auth::id() === $event->user_id)
                                                <a href="{{ route('events.edit', $event) }}" 
                                                   style="background: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; display: inline-block;">
                                                    ✏️ Editar
                                                </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Paginação -->
                    <div style="margin-top: 1.5rem;">
                        {{ $events->links() }}
                    </div>
                @else
                    <div style="text-align: center; padding: 3rem;">
                        <svg style="margin: 0 auto; width: 4rem; height: 4rem; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 style="margin-top: 1rem; font-size: 1.125rem; font-weight: 600; color: #374151;">Nenhum evento disponível</h3>
                        <p style="margin-top: 0.5rem; color: #6b7280;">Ainda não existem eventos criados.</p>
                        
                        @if(Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                            <div style="margin-top: 1.5rem;">
                                <a href="{{ route('events.create') }}" 
                                   style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold; display: inline-block;">
                                    + Criar Primeiro Evento
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>