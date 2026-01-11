<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.5rem; font-weight: bold;">{{ $category->name }}</h2>
            <a href="{{ route('admin.categories.index') }}" 
               style="background: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600;">
                ← Voltar
            </a>
        </div>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 80rem; margin: 0 auto;">
            
            <!-- Informações da Categoria -->
            <div style="background: white; border-radius: 0.5rem; padding: 2rem; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                
                <!-- Badge com cor -->
                <div style="margin-bottom: 1.5rem;">
                    <span style="background: {{ $category->color }}; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600;">
                        {{ $category->icon }} {{ $category->name }}
                    </span>
                </div>

                <!-- Descrição -->
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Descrição</h3>
                    <p style="color: #6b7280;">{{ $category->description }}</p>
                </div>

                <!-- Detalhes -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="background: #f9fafb; padding: 1rem; border-radius: 0.375rem;">
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Slug</p>
                        <p style="font-weight: 600; color: #111827;">{{ $category->slug }}</p>
                    </div>
                    <div style="background: #f9fafb; padding: 1rem; border-radius: 0.375rem;">
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Cor</p>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 24px; height: 24px; border-radius: 0.25rem; background: {{ $category->color }}; border: 2px solid #e5e7eb;"></div>
                            <span style="font-weight: 600; color: #111827;">{{ $category->color }}</span>
                        </div>
                    </div>
                    <div style="background: #f9fafb; padding: 1rem; border-radius: 0.375rem;">
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Total de Eventos</p>
                        <p style="font-weight: 600; color: #111827; font-size: 1.5rem;">{{ $category->events->count() }}</p>
                    </div>
                </div>

                <!-- Botões -->
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       style="background: #f59e0b; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600;">
                        ✏️ Editar
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                          onsubmit="return confirm('Tens a certeza que queres apagar esta categoria?')"
                          style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                style="background: #ef4444; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: 600;">
                            🗑️ Apagar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lista de Eventos desta Categoria -->
            <div style="background: white; border-radius: 0.5rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">
                    📅 Eventos nesta Categoria ({{ $category->events->count() }})
                </h3>

                @if($category->events->isEmpty())
                    <p style="text-align: center; padding: 3rem; color: #6b7280;">
                        Ainda não existem eventos nesta categoria.
                    </p>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                        @foreach($category->events as $event)
                            <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden; transition: box-shadow 0.3s;">
                                
                                <!-- Imagem -->
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" 
                                         alt="{{ $event->title }}"
                                         style="width: 100%; height: 12rem; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 12rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 4rem; height: 4rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <div style="padding: 1rem;">
                                    <h4 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">
                                        {{ $event->title }}
                                    </h4>
                                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">
                                        📍 {{ $event->location }}
                                    </p>
                                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                                        📅 {{ $event->start_date->format('d/m/Y H:i') }}
                                    </p>
                                    <a href="{{ route('events.show', $event) }}" 
                                       style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; font-weight: 600; display: inline-block;">
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>