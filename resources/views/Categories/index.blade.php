<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.5rem; font-weight: bold;">
                Categorias
            </h2>
            <a href="{{ route('admin.categories.create') }}" 
               style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                Nova Categoria
            </a>
        </div>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-w-7xl mx-auto; padding: 0 1.5rem;">
            
            {{-- Mensagens --}}
            @if(session('success'))
                <div style="background: #d1fae5; border: 1px solid #34d399; color: #065f46; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fee2e2; border: 1px solid #f87171; color: #991b1b; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            <div style="background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1.5rem;">
                
                @if($categories->count() > 0)
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 1rem; text-align: left; font-weight: bold;">Categoria</th>
                                <th style="padding: 1rem; text-align: left; font-weight: bold;">Descrição</th>
                                <th style="padding: 1rem; text-align: center; font-weight: bold;">Eventos</th>
                                <th style="padding: 1rem; text-align: center; font-weight: bold;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div style="width: 1rem; height: 1rem; border-radius: 50%; background-color: {{ $category->color }};"></div>
                                            <strong>{{ $category->name }}</strong>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; color: #6b7280;">
                                        {{ Str::limit($category->description, 60) ?? 'Sem descrição' }}
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem;">
                                            {{ $category->events_count }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <a href="{{ route('admin.categories.show', $category) }}" 
                                               style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                                                Ver
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               style="background: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                  method="POST" 
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Tem certeza que deseja apagar esta categoria?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        style="background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer; font-size: 0.875rem;">
                                                    Apagar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: 3rem;">
                        <p style="color: #6b7280; margin-bottom: 1rem;">Ainda não existem categorias.</p>
                        <a href="{{ route('admin.categories.create') }}" 
                           style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                            Criar Primeira Categoria
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>