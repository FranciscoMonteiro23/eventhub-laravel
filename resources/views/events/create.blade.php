<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">Criar Novo Evento</h2>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 60rem; margin: 0 auto;">
            
            <div style="background: white; border-radius: 0.5rem; padding: 2rem;">
                
                <!-- ⚠️ IMPORTANTE: enctype="multipart/form-data" para upload de ficheiros -->
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Título *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('title')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Descrição *</label>
                        <textarea name="description" rows="5" required
                                  style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ old('description') }}</textarea>
                        @error('description')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Categoria *</label>
                        <select name="category_id" required
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

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Localização *</label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                               placeholder="Ex: Porto, Lisboa, Coimbra"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('location')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Data Início *</label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('start_date')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Data Fim</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('end_date')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Max Participantes *</label>
                            <input type="number" name="max_participants" value="{{ old('max_participants', 100) }}" min="1" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('max_participants')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Preço (€) *</label>
                            <input type="number" name="price" value="{{ old('price', 0) }}" step="0.01" min="0" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('price')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 📸 CAMPO DE UPLOAD DE IMAGEM -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">📸 Imagem do Evento</label>
                        <input type="file" 
                               name="image" 
                               id="image" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                        <p style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;">
                            Formatos aceites: JPG, PNG, GIF (máx. 2MB)
                        </p>
                        @error('image')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Status *</label>
                        <select name="status" required
                                style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Rascunho</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publicado</option>
                        </select>
                        @error('status')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <span style="font-weight: 600;">⭐ Marcar como destaque</span>
                        </label>
                    </div>

                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" 
                                style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: bold;"
                                onmouseover="this.style.background='#2563eb'" 
                                onmouseout="this.style.background='#3b82f6'">
                            ✓ Criar Evento
                        </button>
                        <a href="{{ route('events.index') }}" 
                           style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold; display: inline-block;">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>