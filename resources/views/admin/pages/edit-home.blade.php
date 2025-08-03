<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Páginas
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Editar Página de Inicio</h2>
        </div>
        
        <p class="control-panel-text-muted">Edita el contenido y la configuración de las secciones de tu página de inicio.</p>

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

        <form id="home-edit-form" method="POST" action="{{ route('admin.pages.update-home') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            @method('PUT')

            <!-- Hero Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-play-circle"></i> Sección Hero
            </h3>
            <p>Personaliza la sección principal (hero) de tu página de inicio.</p>
                
                <div class="control-panel-form-grid">
                    <div>
                        <label for="hero_title" class="control-panel-label">Título Hero</label>
                        <input 
                            type="text" 
                            id="hero_title" 
                            name="hero_title" 
                            value="{{ old('hero_title', $homeSetting->hero_title) }}"
                            class="control-panel-input"
                            placeholder="Ingresa el título de la sección hero"
                        >
                    </div>
                    
                    <div>
                        <label for="hero_button_text" class="control-panel-label">Texto del Botón Hero</label>
                        <input 
                            type="text" 
                            id="hero_button_text" 
                            name="hero_button_text" 
                            value="{{ old('hero_button_text', $homeSetting->hero_button_text) }}"
                            class="control-panel-input"
                            placeholder="Ingresa el texto del botón"
                        >
                    </div>
                    
                    <div>
                        <label for="hero_video" class="control-panel-label">Video Hero</label>
                        <input 
                            type="file" 
                            id="hero_video" 
                            name="hero_video" 
                            class="control-panel-input"
                            accept="video/*"
                        >
                        <small class="control-panel-small-text">Actual: {{ $homeSetting->hero_video_path ? basename($homeSetting->hero_video_path) : 'vid1.mp4 (predeterminado)' }}</small>
                    </div>
                </div>
            </div>

            <!-- Headline Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-heading"></i> Sección Encabezado
            </h3>
            <p>Personaliza la sección de encabezado principal debajo del hero.</p>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="headline_title" class="control-panel-label">Título del Encabezado</label>
                        <input 
                            type="text" 
                            id="headline_title" 
                            name="headline_title" 
                            value="{{ old('headline_title', $homeSetting->headline_title) }}"
                            class="control-panel-input"
                            placeholder="Ingresa el título del encabezado"
                        >
                    </div>
                    <div>
                        <label for="headline_description" class="control-panel-label">Descripción del Encabezado</label>
                        <textarea 
                            id="headline_description" 
                            name="headline_description" 
                            class="control-panel-input"
                            rows="3"
                            placeholder="Ingresa la descripción del encabezado"
                        >{{ old('headline_description', $homeSetting->headline_description) }}</textarea>
                    </div>
                </div>
                <div class="control-panel-form-grid" style="margin-top: 1.5rem;">
                    <div>
                        <label for="headline_coast_image" class="control-panel-label">Imagen Costa</label>
                        @php
                            $coastImg = $homeSetting->headline_coast_image ? asset('storage/' . $homeSetting->headline_coast_image) : '';
                        @endphp
                        <img id="preview-headline-coast-image" src="{{ $coastImg }}" style="max-width:100px; margin-bottom:6px; {{ $coastImg ? 'display:block;' : 'display:none;' }}">
                        <input type="file" id="headline_coast_image" name="headline_coast_image" class="control-panel-input" accept="image/*" onchange="previewImage(this, 'preview-headline-coast-image')">
                        <small class="control-panel-small-text">Actual: {{ $homeSetting->headline_coast_image ? basename($homeSetting->headline_coast_image) : 'Unsplash predeterminado' }}</small>
                    </div>
                    <div>
                        <label for="headline_andes_image" class="control-panel-label">Imagen Andes</label>
                        @php
                            $andesImg = $homeSetting->headline_andes_image ? asset('storage/' . $homeSetting->headline_andes_image) : '';
                        @endphp
                        <img id="preview-headline-andes-image" src="{{ $andesImg }}" style="max-width:100px; margin-bottom:6px; {{ $andesImg ? 'display:block;' : 'display:none;' }}">
                        <input type="file" id="headline_andes_image" name="headline_andes_image" class="control-panel-input" accept="image/*" onchange="previewImage(this, 'preview-headline-andes-image')">
                        <small class="control-panel-small-text">Actual: {{ $homeSetting->headline_andes_image ? basename($homeSetting->headline_andes_image) : 'Unsplash predeterminado' }}</small>
                    </div>
                    <div>
                        <label for="headline_amazon_image" class="control-panel-label">Imagen Amazonía</label>
                        @php
                            $amazonImg = $homeSetting->headline_amazon_image ? asset('storage/' . $homeSetting->headline_amazon_image) : '';
                        @endphp
                        <img id="preview-headline-amazon-image" src="{{ $amazonImg }}" style="max-width:100px; margin-bottom:6px; {{ $amazonImg ? 'display:block;' : 'display:none;' }}">
                        <input type="file" id="headline_amazon_image" name="headline_amazon_image" class="control-panel-input" accept="image/*" onchange="previewImage(this, 'preview-headline-amazon-image')">
                        <small class="control-panel-small-text">Actual: {{ $homeSetting->headline_amazon_image ? basename($homeSetting->headline_amazon_image) : 'Unsplash predeterminado' }}</small>
                    </div>
    <script>
        function previewImage(input, imgId) {
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
                </div>
            </div>

            <!-- Destinations Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-map-marked-alt"></i> Sección Destinos
            </h3>
            <p>Personaliza la sección de exploración de destinos.</p>
                
                <div class="control-panel-form-grid">
                    <div>
                        <label for="destinations_title" class="control-panel-label">Título de Destinos</label>
                        <input 
                            type="text" 
                            id="destinations_title" 
                            name="destinations_title" 
                            value="{{ old('destinations_title', $homeSetting->destinations_title) }}"
                            class="control-panel-input"
                            placeholder="Ingresa el título de la sección de destinos"
                        >
                    </div>
                    
                    <div>
                        <label for="destinations_description" class="control-panel-label">Descripción de Destinos</label>
                        <textarea 
                            id="destinations_description" 
                            name="destinations_description" 
                            class="control-panel-input"
                            rows="2"
                            placeholder="Ingresa la descripción de destinos"
                        >{{ old('destinations_description', $homeSetting->destinations_description) }}</textarea>
                    </div>
                    
                    <div>
                        <label for="destinations_button_text" class="control-panel-label">Texto del Botón de Destinos</label>
                        <input 
                            type="text" 
                            id="destinations_button_text" 
                            name="destinations_button_text" 
                            value="{{ old('destinations_button_text', $homeSetting->destinations_button_text) }}"
                            class="control-panel-input"
                            placeholder="Ingresa el texto del botón"
                        >
                    </div>
                    <div>
                        <label for="destinations_footer_text" class="control-panel-label">Texto del Pie de Destinos</label>
                        <input 
                            type="text" 
                            id="destinations_footer_text" 
                            name="destinations_footer_text" 
                            value="{{ old('destinations_footer_text', $homeSetting->destinations_footer_text) }}"
                            class="control-panel-input"
                            placeholder="Ingresa el texto del pie (ej. Haz clic en una región para observarla más de cerca.)"
                        >
                    </div>
                </div>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="dest_span_amazonia" class="control-panel-label">Texto del Span Amazonia</label>
                        <input 
                            type="text" 
                            id="dest_span_amazonia" 
                            name="dest_span_amazonia" 
                            value="{{ old('dest_span_amazonia', $homeSetting->dest_span_amazonia ?? 'Amazonía') }}"
                            class="control-panel-input"
                            placeholder="Ingresa el texto para el span de Amazonia"
                        >
                    </div>
                    <div>
                        <label for="dest_span_costa" class="control-panel-label">Texto del Span Costa</label>
                        <input 
                            type="text" 
                            id="dest_span_costa" 
                            name="dest_span_costa" 
                            value="{{ old('dest_span_costa', $homeSetting->dest_span_costa ?? 'Costa') }}"
                            class="control-panel-input"
                            placeholder="Ingresa el texto para el span de Costa"
                        >
                    </div>
                    <div>
                        <label for="dest_span_sierra" class="control-panel-label">Texto del Span Sierra</label>
                        <input 
                            type="text" 
                            id="dest_span_sierra" 
                            name="dest_span_sierra" 
                            value="{{ old('dest_span_sierra', $homeSetting->dest_span_sierra ?? 'Sierra') }}"
                            class="control-panel-input"
                            placeholder="Ingresa el texto para el span de Sierra"
                        >
                    </div>
                    <div>
                        <label for="dest_span_galapagos" class="control-panel-label">Texto del Span Galápagos</label>
                        <input 
                            type="text" 
                            id="dest_span_galapagos" 
                            name="dest_span_galapagos" 
                            value="{{ old('dest_span_galapagos', $homeSetting->dest_span_galapagos ?? 'Galápagos') }}"
                            class="control-panel-input"
                            placeholder="Ingresa el texto para el span de Galápagos"
                        >
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Fixed Action Buttons -->
    <div class="control-panel-fixed-actions">
        <a href="{{ route('admin.pages') }}" class="control-panel-button">
            <i class="fas fa-times"></i> Cancelar
        </a>
        <button type="submit" form="home-edit-form" class="control-panel-button">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
        <a href="/home" target="_blank" class="control-panel-button">
            <i class="fas fa-external-link-alt"></i> Ver Página de Inicio
        </a>
    </div>
</x-control-panel-layout>
