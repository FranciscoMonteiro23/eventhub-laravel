<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold;">Editar Categoria</h2>
    </x-slot>

    <div style="padding: 2rem;">
        <div style="max-width: 56rem; margin: 0 auto;">
            <div style="background: white; border-radius: 0.5rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nome -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Nome *</label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $category->name) }}" 
                               required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('name')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Slug *</label>
                        <input type="text" 
                               name="slug" 
                               value="{{ old('slug', $category->slug) }}" 
                               required
                               placeholder="Ex: tecnologia, desporto, cultura"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">
                            URL amigável (sem espaços, acentos ou caracteres especiais)
                        </p>
                        @error('slug')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Descrição</label>
                        <textarea name="description" 
                                  rows="3"
                                  style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cor e Ícone -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Cor</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="color" 
                                       name="color" 
                                       value="{{ old('color', $category->color ?? '#3b82f6') }}"
                                       style="width: 60px; height: 40px; border: 1px solid #d1d5db; border-radius: 0.375rem; cursor: pointer;">
                                <input type="text" 
                                       name="color_hex" 
                                       value="{{ old('color', $category->color ?? '#3b82f6') }}"
                                       placeholder="#3b82f6"
                                       readonly
                                       style="flex: 1; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f9fafb;">
                            </div>
                            @error('color')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Ícone</label>
                            <select name="icon" 
                                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                                <option value="📅" {{ old('icon', $category->icon) == '📅' ? 'selected' : '' }}>📅 Calendário</option>
                                <option value="🎵" {{ old('icon', $category->icon) == '🎵' ? 'selected' : '' }}>🎵 Música</option>
                                <option value="⚽" {{ old('icon', $category->icon) == '⚽' ? 'selected' : '' }}>⚽ Desporto</option>
                                <option value="💻" {{ old('icon', $category->icon) == '💻' ? 'selected' : '' }}>💻 Tecnologia</option>
                                <option value="🎨" {{ old('icon', $category->icon) == '🎨' ? 'selected' : '' }}>🎨 Arte</option>
                                <option value="🎭" {{ old('icon', $category->icon) == '🎭' ? 'selected' : '' }}>🎭 Cultura</option>
                                <option value="🍕" {{ old('icon', $category->icon) == '🍕' ? 'selected' : '' }}>🍕 Gastronomia</option>
                                <option value="✈️" {{ old('icon', $category->icon) == '✈️' ? 'selected' : '' }}>✈️ Viagens</option>
                                <option value="🎓" {{ old('icon', $category->icon) == '🎓' ? 'selected' : '' }}>🎓 Educação</option>
                                <option value="💼" {{ old('icon', $category->icon) == '💼' ? 'selected' : '' }}>💼 Negócios</option>
                                <option value="🏃" {{ old('icon', $category->icon) == '🏃' ? 'selected' : '' }}>🏃 Fitness</option>
                                <option value="🎪" {{ old('icon', $category->icon) == '🎪' ? 'selected' : '' }}>🎪 Entretenimento</option>
                            </select>
                            @error('icon')
                                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview -->
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f9fafb; border-radius: 0.375rem;">
                        <p style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Preview:</p>
                        <span id="preview-badge" style="background: {{ $category->color ?? '#3b82f6' }}; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; display: inline-block;">
                            <span id="preview-icon">{{ $category->icon ?? '📅' }}</span>
                            <span id="preview-name">{{ $category->name }}</span>
                        </span>
                    </div>

                    <!-- Botões -->
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" 
                                style="background: #f59e0b; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: bold;"
                                onmouseover="this.style.background='#d97706'" 
                                onmouseout="this.style.background='#f59e0b'">
                            ✓ Atualizar Categoria
                        </button>
                        <a href="{{ route('admin.categories.index') }}" 
                           style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold; display: inline-block;">
                            Cancelar
                        </a>

                        <!-- Botão Apagar -->
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                              onsubmit="return confirm('Tens a certeza que queres apagar esta categoria? Todos os eventos associados ficarão sem categoria!')"
                              style="margin-left: auto;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="background: #ef4444; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: bold;"
                                    onmouseover="this.style.background='#dc2626'" 
                                    onmouseout="this.style.background='#ef4444'">
                                🗑️ Apagar
                            </button>
                        </form>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- JavaScript para Preview em tempo real -->
    <script>
        // Preview do badge em tempo real
        const colorInput = document.querySelector('input[name="color"]');
        const colorHexInput = document.querySelector('input[name="color_hex"]');
        const iconSelect = document.querySelector('select[name="icon"]');
        const nameInput = document.querySelector('input[name="name"]');
        const previewBadge = document.getElementById('preview-badge');
        const previewIcon = document.getElementById('preview-icon');
        const previewName = document.getElementById('preview-name');

        // Atualizar cor
        colorInput.addEventListener('input', function() {
            previewBadge.style.background = this.value;
            colorHexInput.value = this.value;
        });

        // Atualizar ícone
        iconSelect.addEventListener('change', function() {
            previewIcon.textContent = this.value + ' ';
        });

        // Atualizar nome
        nameInput.addEventListener('input', function() {
            previewName.textContent = this.value || 'Nome da Categoria';
        });
    </script>
</x-app-layout>