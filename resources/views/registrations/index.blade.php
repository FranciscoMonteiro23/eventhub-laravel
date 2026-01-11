<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">
            Gestão de Inscrições
        </h2>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 80rem; margin: 0 auto;">
            
            <!-- Mensagens de sucesso/erro -->
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
                    <p style="text-align: center; padding: 3rem; color: #6b7280;">Ainda não existem inscrições.</p>
                @else
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e5e7eb;">
                                    <th style="padding: 1rem; text-align: left; font-weight: bold;">ID</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: bold;">Participante</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: bold;">Evento</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: bold;">Data Inscrição</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: bold;">Status</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: bold;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 1rem;">
                                            #{{ $registration->id }}
                                        </td>
                                        <td style="padding: 1rem;">
                                            <div style="font-weight: 600;">{{ $registration->user->name }}</div>
                                            <div style="font-size: 0.875rem; color: #6b7280;">{{ $registration->user->email }}</div>
                                        </td>
                                        <td style="padding: 1rem;">
                                            <div style="font-weight: 600;">{{ $registration->event->title }}</div>
                                            <div style="font-size: 0.875rem; color: #6b7280;">{{ $registration->event->start_date->format('d/m/Y H:i') }}</div>
                                        </td>
                                        <td style="padding: 1rem; color: #6b7280;">
                                            {{ $registration->registration_date->format('d/m/Y H:i') }}
                                        </td>
                                        <td style="padding: 1rem; text-align: center;">
                                            @if($registration->status === 'confirmed')
                                                <span style="background: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                                                    ✓ Confirmada
                                                </span>
                                            @elseif($registration->status === 'pending')
                                                <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                                                    ⏳ Pendente
                                                </span>
                                            @else
                                                <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                                                    ✗ Cancelada
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem; text-align: center;">
                                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                                <!-- Aprovar -->
                                                @if($registration->status !== 'confirmed')
                                                    <form action="{{ route('registrations.updateStatus', $registration) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" 
                                                                style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; border: none; cursor: pointer;"
                                                                onmouseover="this.style.background='#059669'" 
                                                                onmouseout="this.style.background='#10b981'">
                                                            Aprovar
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Cancelar -->
                                                @if($registration->status !== 'cancelled')
                                                    <form action="{{ route('registrations.updateStatus', $registration) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" 
                                                                style="background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; border: none; cursor: pointer;"
                                                                onmouseover="this.style.background='#dc2626'" 
                                                                onmouseout="this.style.background='#ef4444'">
                                                            Cancelar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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