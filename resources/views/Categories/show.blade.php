<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.5rem; font-weight: bold;">{{ $event->title }}</h2>
            <a href="{{ route('events.index') }}" 
               style="background: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none;">
                Voltar
            </a>
        </div>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 80rem; margin: 0 auto; padding: 0 1.5rem;">
            
            {{-- Imagem --}}
            @if($event->image)
                <div style="background: white; border-radius: 0.5rem; margin-bottom: 1.5rem; overflow: hidden;">
                    <img src="{{ asset('storage/' . $event->image) }}" 
                         alt="{{ $event->title }}"
                         style="width: 100%; max-height: 400px; object-fit: cover;">
                </div>
            @endif

            {{-- Conteúdo Principal --}}
            <div style="background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 2rem;">
                
                {{-- Status --}}
                <div style="margin-bottom: 1rem;">
                    <span style="background: #d1fae5; color: #065f46; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                        {{ ucfirst($event->status) }}
                    </span>
                    @if($event->is_featured)
                        <span style="background: #fef3c7; color: #92400e; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; margin-left: 0.5rem;">
                            ★ Destaque
                        </span>
                    @endif
                </div>

                {{-- Categoria --}}
                <div style="margin-bottom: 1.5rem;">
                    <span style="background: {{ $event->category->color }}22; color: {{ $event->category->color }}; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600;">
                        {{ $event->category->name }}
                    </span>
                </div>

                {{-- Descrição --}}
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.75rem;">Sobre o Evento</h3>
                    <p style="color: #374151; line-height: 1.7;">{{ $event->description }}</p>
                </div>

                {{-- Informações --}}
                <div style="border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Informações</h3>
                    
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 0.75rem 0; color: #6b7280; font-weight: 600;">📍 Localização:</td>
                            <td style="padding: 0.75rem 0;">{{ $event->location }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem 0; color: #6b7280; font-weight: 600;">🗓️ Data Início:</td>
                            <td style="padding: 0.75rem 0;">{{ $event->start_date->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem 0; color: #6b7280; font-weight: 600;">🏁 Data Fim:</td>
                            <td style="padding: 0.75rem 0;">{{ $event->end_date->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem 0; color: #6b7280; font-weight: 600;">💰 Preço:</td>
                            <td style="padding: 0.75rem 0; font-weight: bold; font-size: 1.25rem;">
                                @if($event->price > 0)
                                    €{{ number_format($event->price, 2) }}
                                @else
                                    <span style="color: #059669;">GRÁTIS</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem 0; color: #6b7280; font-weight: 600;">👥 Vagas:</td>
                            <td style="padding: 0.75rem 0;">{{ $event->max_participants }} participantes</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem 0; color: #6b7280; font-weight: 600;">👤 Organizador:</td>
                            <td style="padding: 0.75rem 0;">{{ $event->creator->name }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Botões de Ação --}}
                @if(auth()->user()->isAdmin() || $event->user_id === auth()->id())
                    <div style="border-top: 1px solid #e5e7eb; padding-top: 1.5rem; margin-top: 2rem;">
                        <div style="display: flex; gap: 1rem;">
                            <a href="{{ route('events.edit', $event) }}" 
                               style="background: #f59e0b; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold;">
                                Editar Evento
                            </a>
                            <form action="{{ route('events.destroy', $event) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('Tem certeza que deseja apagar este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="background: #ef4444; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: bold;">
                                    Apagar Evento
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Inscrições (se for organizador/admin) --}}
            @if((auth()->user()->isAdmin() || $event->user_id === auth()->id()) && $event->registrations->count() > 0)
                <div style="background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 2rem; margin-top: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">
                        Participantes ({{ $event->registrations->count() }})
                    </h3>
                    
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 0.75rem; text-align: left;">Nome</th>
                                <th style="padding: 0.75rem; text-align: left;">Email</th>
                                <th style="padding: 0.75rem; text-align: center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->registrations as $registration)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 0.75rem;">{{ $registration->user->name }}</td>
                                    <td style="padding: 0.75rem;">{{ $registration->user->email }}</td>
                                    <td style="padding: 0.75rem; text-align: center;">
                                        <span style="background: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem;">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>