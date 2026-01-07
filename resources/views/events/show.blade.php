<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">{{ $event->title }}</h2>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 60rem; margin: 0 auto;">
            
            <div style="margin-bottom: 1rem;">
                <a href="{{ route('events.index') }}" 
                   style="background: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none;">
                    ← Voltar
                </a>
            </div>

            <div style="background: white; border-radius: 0.5rem; padding: 2rem;">
                
                <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">{{ $event->title }}</h1>
                
                <p style="color: #6b7280; margin-bottom: 1.5rem;">
                    <strong>Categoria:</strong> {{ $event->category->name }}
                </p>
                
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-weight: bold; margin-bottom: 0.5rem;">Descrição</h3>
                    <p style="line-height: 1.7;">{{ $event->description }}</p>
                </div>

                <div style="border-top: 1px solid #e5e7eb; padding-top: 1.5rem; margin-top: 1.5rem;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 0.5rem 0; font-weight: bold; width: 200px;">📍 Localização:</td>
                            <td style="padding: 0.5rem 0;">{{ $event->location }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem 0; font-weight: bold;">🗓️ Data Início:</td>
                            <td style="padding: 0.5rem 0;">{{ $event->start_date->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem 0; font-weight: bold;">🏁 Data Fim:</td>
                            <td style="padding: 0.5rem 0;">{{ $event->end_date->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem 0; font-weight: bold;">👥 Max Participantes:</td>
                            <td style="padding: 0.5rem 0;">{{ $event->max_participants }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem 0; font-weight: bold;">💰 Preço:</td>
                            <td style="padding: 0.5rem 0;">
                                @if($event->price > 0)
                                    €{{ number_format($event->price, 2) }}
                                @else
                                    <span style="color: #059669; font-weight: bold;">GRÁTIS</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem 0; font-weight: bold;">👤 Organizador:</td>
                            <td style="padding: 0.5rem 0;">{{ $event->creator->name }}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>