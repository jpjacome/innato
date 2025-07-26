<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Páginas
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Editar Página de Destinos</h2>
        </div>
        <p class="control-panel-text-muted">Edita el contenido y la configuración de tu página de destinos.</p>

        @if(session('success'))
            <div class="alert alert-success control-panel-alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error control-panel-alert-error-custom">
                <ul class="control-panel-alert-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="destinations-edit-form" method="POST" action="{{ route('admin.pages.update-destinations') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            @method('PUT')

            <!-- Banner Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-image"></i> Banner</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="banner_title" class="control-panel-label">Título del Banner</label>
                        <input type="text" id="banner_title" name="banner_title" class="control-panel-input" value="{{ old('banner_title', $destinationsSetting->banner_title ?? 'ECUADOR ES UN PARAÍSO, VEÁMOSLO JUNTOS.') }}">
                    </div>
                    <div>
                        <label for="banner_description" class="control-panel-label">Descripción del Banner</label>
                        <textarea id="banner_description" name="banner_description" class="control-panel-input" rows="3">{{ old('banner_description', $destinationsSetting->banner_description ?? 'Encuentra artículos de aventura y actividades al aire libre, artesanías, cultura, festividades, gastronomía, vida silvestre, tradiciones, leyendas, sitios históricos y más.') }}</textarea>
                    </div>
                    <div>
                        <label for="banner_image" class="control-panel-label">Imagen del Banner</label>
                        @if(!empty($destinationsSetting->banner_image))
                            <div><img src="{{ asset('storage/' . $destinationsSetting->banner_image) }}" alt="Banner" style="max-width:120px;"></div>
                        @endif
                        <input type="file" id="banner_image" name="banner_image" class="control-panel-input">
                    </div>
                </div>
            </div>

            <!-- Headline Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-users"></i> Tarjetas de Encabezado</h3>
                @php
                    $defaultHeadlineCards = [
                        [
                            'title' => 'YUNGUILLA',
                            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia optio, minima fugiat nihil nemo adipisci omnis.',
                            'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600&h=400&fit=crop&crop=entropy&auto=format',
                            'button' => 'RESERVAR',
                            'link' => '/destination',
                        ],
                        [
                            'title' => 'OYACACHI',
                            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia optio, minima fugiat nihil nemo adipisci omnis.',
                            'image' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=600&h=400&fit=crop&crop=entropy&auto=format',
                            'button' => 'RESERVAR',
                            'link' => '#',
                        ],
                        [
                            'title' => 'AGUA BLANCA',
                            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia optio, minima fugiat nihil nemo adipisci omnis.',
                            'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop&crop=entropy&auto=format',
                            'button' => 'RESERVAR',
                            'link' => '#',
                        ],
                    ];
                    $headlineCards = old('headline_cards', isset($destinationsSetting) && !empty($destinationsSetting->headline_cards) ? json_decode($destinationsSetting->headline_cards, true) : $defaultHeadlineCards);
                @endphp
                <div id="headline-cards-list">
                    @foreach($headlineCards as $i => $card)
                        <div class="control-panel-form-grid" style="align-items: end; border:1px solid #eee; margin-bottom:10px; padding:10px;">
                            <div>
                                <label class="control-panel-label">Título</label>
                                <input type="text" name="headline_cards[{{ $i }}][title]" class="control-panel-input" value="{{ $card['title'] ?? '' }}" placeholder="Título">
                            </div>
                            <div>
                                <label class="control-panel-label">Descripción</label>
                                <textarea name="headline_cards[{{ $i }}][description]" class="control-panel-input" rows="2" placeholder="Descripción">{{ $card['description'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="control-panel-label">Imagen</label>
                                @php
                                    $imgSrc = null;
                                    if (isset($card['image']) && !empty($card['image'])) {
                                        if (str_starts_with($card['image'], 'http')) {
                                            $imgSrc = $card['image'];
                                        } else {
                                            $imgSrc = asset('storage/' . $card['image']);
                                        }
                                    }
                                @endphp
                                <img id="headline-image-preview-{{ $i }}" src="{{ $imgSrc ?? '' }}" alt="Imagen actual" style="max-width:80px; margin-bottom:6px; {{ $imgSrc ? 'display:block;' : 'display:none;' }}">
                                <input type="file" name="headline_cards[{{ $i }}][image]" class="control-panel-input" onchange="previewHeadlineImage(this, 'headline-image-preview-{{ $i }}')">
                            </div>
                            <div>
                                <label class="control-panel-label">Botón</label>
                                <input type="text" name="headline_cards[{{ $i }}][button]" class="control-panel-input" value="{{ $card['button'] ?? '' }}" placeholder="Texto del botón">
                            </div>
                            <!-- No editable link field for headline cards, to match homepage/about edit UX -->
                            <!-- No delete button for headline cards, to match homepage/about edit UX -->
                        </div>
                    @endforeach
                </div>

            </div>

            <!-- Destinations Section (only title and button editable, values are static) -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-map-marker-alt"></i> Destinos</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="destinations_title" class="control-panel-label">Título de Destinos</label>
                        <input type="text" id="destinations_title" name="destinations_title" class="control-panel-input" value="{{ old('destinations_title', $destinationsSetting->destinations_title ?? 'EXPLORA ECUADOR Y SUS COMUNIDADES') }}">
                    </div>
                    <div>
                        <label for="destinations_button_text" class="control-panel-label">Texto del Botón</label>
                        <input type="text" id="destinations_button_text" name="destinations_button_text" class="control-panel-input" value="{{ old('destinations_button_text', $destinationsSetting->destinations_button_text ?? 'UBICACIÓN') }}">
                    </div>
                </div>
                <div class="control-panel-text-muted">Los valores que se muestran en la pista de destinos son estáticos y no editables, igual que en la página de inicio.</div>
            </div>

            <script>
                function addHeadlineCard() {
                    const list = document.getElementById('headline-cards-list');
                    // Count only the card containers, not all children
                    const idx = list.querySelectorAll('.control-panel-form-grid').length;
                    const div = document.createElement('div');
                    div.className = 'control-panel-form-grid';
                    div.style.alignItems = 'end';
                    div.style.border = '1px solid #eee';
                    div.style.marginBottom = '10px';
                    div.style.padding = '10px';
                    div.innerHTML = `
                        <div><label class=\"control-panel-label\">Título</label><input type=\"text\" name=\"headline_cards[${idx}][title]\" class=\"control-panel-input\" placeholder=\"Título\"></div>
                        <div><label class=\"control-panel-label\">Descripción</label><textarea name=\"headline_cards[${idx}][description]\" class=\"control-panel-input\" rows=\"2\" placeholder=\"Descripción\"></textarea></div>
                        <div><label class=\"control-panel-label\">Imagen</label>
                            <img id=\"headline-image-preview-${idx}\" style=\"max-width:80px; margin-bottom:6px; display:none;\">
                            <input type=\"file\" name=\"headline_cards[${idx}][image]\" class=\"control-panel-input\" onchange=\"previewHeadlineImage(this, 'headline-image-preview-${idx}')\">
                        </div>
                        <div><label class=\"control-panel-label\">Botón</label><input type=\"text\" name=\"headline_cards[${idx}][button]\" class=\"control-panel-input\" placeholder=\"Texto del botón\"></div>
                    `;
                    list.appendChild(div);
                }
            </script>
            <script>
                function previewHeadlineImage(input, imgId) {
                    const img = document.getElementById(imgId);
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            img.src = e.target.result;
                            img.style.display = 'block';
                        };
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        img.src = '';
                        img.style.display = 'none';
                    }
                }
            </script>
        </form>
    </div>

    <!-- Fixed Action Buttons -->
    <div class="control-panel-fixed-actions">
        <a href="{{ route('admin.pages') }}" class="control-panel-button">
            <i class="fas fa-times"></i> Cancelar
        </a>
        <button type="submit" form="destinations-edit-form" class="control-panel-button">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
        <a href="/destinations" target="_blank" class="control-panel-button">
            <i class="fas fa-external-link-alt"></i> Ver Página de Destinos
        </a>
    </div>
</x-control-panel-layout>
