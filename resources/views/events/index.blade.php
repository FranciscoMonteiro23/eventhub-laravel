<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">Eventos</h2>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 80rem; margin: 0 auto;">
            
            <div style="margin-bottom: 1rem;">
                <a href="{{ route('events.create') }}" 
                   style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold;">
                    + Novo Evento
                </a>
            </div>

            <div style="background: white; border-radius: 0.5rem; padding: 1.5rem;">
                
                @if($events->count() > 0)
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 1rem; text-align: left; font-weight: bold;">Título</th>
                                <th style="padding: 1rem; text-align: left; font-weight: bold;">Categoria</th>
                                <th style="padding: 1rem; text-align: left; font-weight: bold;">Data</th>
                                <th style="padding: 1rem; text-align: center; font-weight: bold;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 1rem;">
                                        <strong>{{ $event->title }}</strong>
                                        <br>
                                        <small style="color: #6b7280;">{{ $event->location }}</small>
                                    </td>
                                    <td style="padding: 1rem;">
                                        {{ $event->category->name }}
                                    </td>
                                    <td style="padding: 1rem;">
                                        {{ $event->start_date->format('d/m/Y H:i') }}
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <a href="{{ route('events.show', $event) }}" 
                                           style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                                            Ver
                                        </a>
                                        <a href="{{ route('events.edit', $event) }}" 
                                           style="background: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; margin-left: 0.5rem;">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="text-align: center; padding: 3rem; color: #6b7280;">Nenhum evento criado ainda.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>