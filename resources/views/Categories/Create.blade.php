<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">Criar Novo Evento</h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 60rem; margin: 0 auto; padding: 0 1.5rem;">
            <div style="background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 2rem;">
                
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Título --}}
                    <div style="margin-bottom: 1.5rem;">
                        <label for="title" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Título do Evento *
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('title')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descrição --}}
                    <div style="margin-bottom: 1.5rem;">
                        <label for="description" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Descrição *
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="5"
                                  required
                                  style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ old('description') }}</textarea>
                        <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem;">Mínimo 20 caracteres</p>
                        @error('description')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Categoria e Localização (lado a lado) --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        {{-- Categoria --}}
                        <div>
                            <label for="category_id" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Categoria *
                            </label>
                            <select name="category_id" 
                                    id="category_id" 
                                    required
                                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                                <option value="">Selecione...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Localização --}}
                        <div>
                            <label for="location" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Localização *
                            </label>
                            <input type="text" 
                                   name="location" 
                                   id="location" 
                                   value="{{ old('location') }}"
                                   required
                                   placeholder="Ex: Teatro Rivoli, Porto"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('location')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Datas (lado a lado) --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        {{-- Data Início --}}
                        <div>
                            <label for="start_date" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Data e Hora de Início *
                            </label>
                            <input type="datetime-local" 
                                   name="start_date" 
                                   id="start_date" 
                                   value="{{ old('start_date') }}"
                                   required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('start_date')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Data Fim --}}
                        <div>
                            <label for="end_date" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Data e Hora de Fim *
                            </label>
                            <input type="datetime-local" 
                                   name="end_date" 
                                   id="end_date" 
                                   value="{{ old('end_date') }}"
                                   required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('end_date')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Max Participantes e Preço (lado a lado) --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        {{-- Max Participantes --}}
                        <div>
                            <label for="max_participants" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Máximo de Participantes *
                            </label>
                            <input type="number" 
                                   name="max_participants" 
                                   id="max_participants" 
                                   value="{{ old('max_participants', 100) }}"
                                   min="1"
                                   required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('max_participants')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Preço --}}
                        <div>
                            <label for="price" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Preço (€) *
                            </label>
                            <input type="number" 
                                   name="price" 
                                   id="price" 
                                   value="{{ old('price', 0) }}"
                                   min="0"
                                   step="0.01"
                                   required
                                   placeholder="0.00"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem;">Use 0 para evento gratuito</p>
                            @error('price')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div style="margin-bottom: 1.5rem;">
                        <label for="status" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Status *
                        </label>
                        <select name="status" 
                                id="status" 
                                required
                                style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Rascunho</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publicado</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('status')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Imagem --}}
                    <div style="margin-bottom: 1.5rem;">
                        <label for="image" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Imagem do Evento
                        </label>
                        <input type="file" 
                               name="image" 
                               id="image" 
                               accept="image/*"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem;">JPG, PNG ou GIF. Máximo 2MB</p>
                        @error('image')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Evento em Destaque --}}
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}
                                   style="width: 1.25rem; height: 1.25rem; cursor: pointer;">
                            <span style="font-weight: 600;">Marcar como evento em destaque</span>
                        </label>
                    </div>

                    {{-- Botões --}}
                    <div style="display: flex; gap: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                        <button type="submit" 
                                style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: bold;">
                            Criar Evento
                        </button>
                        <a href="{{ route('events.index') }}" 
                           style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block; font-weight: bold;">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>