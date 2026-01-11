<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">Detalhes do Evento</h2>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 80rem; margin: 0 auto;">
            
            <div style="background: white; border-radius: 0.5rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                
                <!-- Imagem do Evento -->
                @if($event->image)
                    <div style="margin-bottom: 2rem;">
                        <img src="{{ asset('storage/' . $event->image) }}" 
                             alt="{{ $event->title }}"
                             style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 0.5rem;">
                    </div>
                @endif

                <!-- Título e Categoria -->
                <div style="margin-bottom: 1.5rem;">
                    <h1 style="font-size: 2rem; font-weight: bold; color: #111827; margin-bottom: 0.5rem;">
                        {{ $event->title }}
                    </h1>
                    <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                        {{ $event->category->name }}
                    </span>
                    
                    @if($event->is_featured)
                        <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; margin-left: 0.5rem;">
                            ⭐ Destaque
                        </span>
                    @endif

                    <!-- Status -->
                    @if($event->status === 'published')
                        <span style="background: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; margin-left: 0.5rem;">
                            ✓ Publicado
                        </span>
                    @elseif($event->status === 'draft')
                        <span style="background: #e5e7eb; color: #374151; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; margin-left: 0.5rem;">
                            📝 Rascunho
                        </span>
                    @elseif($event->status === 'cancelled')
                        <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; margin-left: 0.5rem;">
                            ✗ Cancelado
                        </span>
                    @endif
                </div>

                <!-- Descrição -->
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">Descrição</h3>
                    <p style="color: #4b5563; line-height: 1.6; white-space: pre-wrap;">{{ $event->description }}</p>
                </div>

                <!-- Informações do Evento -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    
                    <!-- Card 1 -->
                    <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 1rem;">📅 DATAS</h4>
                        <table style="width: 100%; font-size: 0.875rem;">
                            <tr>
                                <td style="padding: 0.5rem 0; font-weight: bold; color: #374151;">Início:</td>
                                <td style="padding: 0.5rem 0; color: #6b7280;">{{ $event->start_date->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($event->end_date)
                                <tr>
                                    <td style="padding: 0.5rem 0; font-weight: bold; color: #374151;">Fim:</td>
                                    <td style="padding: 0.5rem 0; color: #6b7280;">{{ $event->end_date->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <!-- Card 2 -->
                    <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 1rem;">📍 LOCALIZAÇÃO</h4>
                        <p style="font-size: 1rem; font-weight: 600; color: #111827;">{{ $event->location }}</p>
                    </div>

                    <!-- Card 3 -->
                    <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 1rem;">👥 PARTICIPANTES</h4>
                        @php
                            $confirmedCount = $event->registrations()->where('status', 'confirmed')->count();
                        @endphp
                        <p style="font-size: 1.5rem; font-weight: bold; color: #111827;">
                            {{ $confirmedCount }} / {{ $event->max_participants }}
                        </p>
                        <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">
                            {{ $event->max_participants - $confirmedCount }} vagas disponíveis
                        </p>
                    </div>

                    <!-- Card 4 -->
                    <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 1rem;">💰 PREÇO</h4>
                        <p style="font-size: 1.5rem; font-weight: bold; color: #111827;">
                            @if($event->price > 0)
                                €{{ number_format($event->price, 2, ',', '.') }}
                            @else
                                Gratuito
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Organizador -->
                <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem;">👤 ORGANIZADOR</h4>
                    <p style="font-size: 1rem; font-weight: 600; color: #111827;">{{ $event->user->name }}</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">{{ $event->user->email }}</p>
                </div>

                <!-- Lista de Participantes (apenas para criador/admin) -->
                @if(Auth::id() === $event->user_id || Auth::user()->role === 'admin')
                    <div style="border-top: 2px solid #e5e7eb; padding-top: 2rem; margin-top: 2rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">
                            📋 Participantes Inscritos ({{ $event->registrations->count() }})
                        </h3>
                        
                        @if($event->registrations->isEmpty())
                            <p style="color: #6b7280; text-align: center; padding: 2rem;">
                                Ainda não há participantes inscritos.
                            </p>
                        @else
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #e5e7eb;">
                                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #374151;">Nome</th>
                                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #374151;">Email</th>
                                            <th style="padding: 0.75rem; text-align: center; font-size: 0.875rem; font-weight: 600; color: #374151;">Data Inscrição</th>
                                            <th style="padding: 0.75rem; text-align: center; font-size: 0.875rem; font-weight: 600; color: #374151;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($event->registrations as $registration)
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 0.75rem; font-size: 0.875rem;">{{ $registration->user->name }}</td>
                                                <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;">{{ $registration->user->email }}</td>
                                                <td style="padding: 0.75rem; font-size: 0.875rem; text-align: center; color: #6b7280;">
                                                    {{ $registration->registration_date->format('d/m/Y') }}
                                                </td>
                                                <td style="padding: 0.75rem; text-align: center;">
                                                    @if($registration->status === 'confirmed')
                                                        <span style="background: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                            ✓ Confirmado
                                                        </span>
                                                    @elseif($registration->status === 'pending')
                                                        <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                            ⏳ Pendente
                                                        </span>
                                                    @else
                                                        <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                            ✗ Cancelado
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Botões de Ação -->
                <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e5e7eb;">
                    <a href="{{ route('events.index') }}" 
                       style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600;">
                        ← Voltar
                    </a>

                    @if(Auth::id() === $event->user_id || Auth::user()->role === 'admin')
                        <a href="{{ route('events.edit', $event) }}" 
                           style="background: #f59e0b; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600;">
                            ✏️ Editar
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>