<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">Editar: {{ $event->title }}</h2>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 60rem; margin: 0 auto;">
            
            <div style="background: white; border-radius: 0.5rem; padding: 2rem;">
                
                <form action="{{ route('events.update', $event) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Título *</label>
                        <input type="text" name="title" value="{{ $event->title }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Descrição *</label>
                        <textarea name="description" rows="5" required
                                  style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ $event->description }}</textarea>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Categoria *</label>
                        <select name="category_id" required
                                style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Localização *</label>
                        <input type="text" name="location" value="{{ $event->location }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Data Início *</label>
                            <input type="datetime-local" name="start_date" value="{{ $event->start_date->format('Y-m-d\TH:i') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Data Fim *</label>
                            <input type="datetime-local" name="end_date" value="{{ $event->end_date->format('Y-m-d\TH:i') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Max Participantes *</label>
                            <input type="number" name="max_participants" value="{{ $event->max_participants }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Preço (€) *</label>
                            <input type="number" name="price" value="{{ $event->price }}" step="0.01" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Status *</label>
                        <select name="status" required
                                style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            <option value="draft" {{ $event->status == 'draft' ? 'selected' : '' }}>Rascunho</option>
                            <option value="published" {{ $event->status == 'published' ? 'selected' : '' }}>Publicado</option>
                            <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>Concluído</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" name="is_featured" value="1" {{ $event->is_featured ? 'checked' : '' }}>
                            <span>Marcar como destaque</span>
                        </label>
                    </div>

                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" 
                                style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: bold;">
                            Atualizar Evento
                        </button>
                        <a href="{{ route('events.index') }}" 
                           style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold;">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>