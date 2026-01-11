<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">
            As Minhas Inscrições
        </h2>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 80rem; margin: 0 auto;">
            
            <!-- Mensagens -->
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

            <div style="background: white; border-radius: 0.5rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                
                @if($registrations->isEmpty())
                    <div style="text-align: center; padding: 3rem;">
                        <svg style="margin: 0 auto; width: 4rem; height: 4rem; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 style="margin-top: 1rem; font-size: 1.125rem; font-weight: 600; color: #374151;">Sem inscrições</h3>
                        <p style="margin-top: 0.5rem; color: #6b7280;">Ainda não te inscreveste em nenhum evento.</p>
                        <div style="margin-top: 1.5rem;">
                            <a href="{{ route('events.index') }}" 
                               style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold; display: inline-block;">
                                Ver Eventos Disponíveis
                            </a>
                        </div>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                        @foreach($registrations as $registration)
                            <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: box-shadow 0.3s;">
                                
                                <!-- Imagem do Evento -->
                                @if($registration->event->image)
                                    <img src="{{ asset('storage/' . $registration->event->image) }}" 
                                         alt="{{ $registration->event->title }}"
                                         style="width: 100%; height: 12rem; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 12rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 4rem; height: 4rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <div style="padding: 1rem;">
                                    <!-- Nome do Evento -->
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">
                                        {{ $registration->event->title }}
                                    </h3>

                                    <!-- Informações -->
                                    <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                                        <div style="display: flex; align-items: center;">
                                            <span style="margin-right: 0.5rem;">📅</span>
                                            {{ $registration->event->start_date->format('d/m/Y H:i') }}
                                        </div>
                                        <div style="display: flex; align-items: center;">
                                            <span style="margin-right: 0.5rem;">📍</span>
                                            {{ $registration->event->location }}
                                        </div>
                                        <div style="display: flex; align-items: center;">
                                            <span style="margin-right: 0.5rem;">🕐</span>
                                            Inscrito em {{ $registration->registration_date->format('d/m/Y') }}
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div style="margin-bottom: 1rem;">
                                        @if($registration->status === 'confirmed')
                                            <span style="background: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; display: inline-block;">
                                                ✓ Confirmada
                                            </span>
                                        @elseif($registration->status === 'pending')
                                            <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; display: inline-block;">
                                                ⏳ Pendente
                                            </span>
                                        @else
                                            <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; display: inline-block;">
                                                ✗ Cancelada
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Ações -->
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('events.show', $registration->event) }}" 
                                           style="flex: 1; text-align: center; background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; font-weight: 600;">
                                            Ver Evento
                                        </a>

                                        @if($registration->status !== 'cancelled' && $registration->event->start_date > now())
                                            <form action="{{ route('registrations.cancel', $registration) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Tens a certeza que queres cancelar esta inscrição?')"
                                                  style="flex: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        style="background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 600; border: none; cursor: pointer; white-space: nowrap;"
                                                        onmouseover="this.style.background='#dc2626'" 
                                                        onmouseout="this.style.background='#ef4444'">
                                                    Cancelar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Paginação -->
                    <div style="margin-top: 1.5rem;">
                        {{ $registrations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>