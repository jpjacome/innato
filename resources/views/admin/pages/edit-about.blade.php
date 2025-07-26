<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Edit About Page</h2>
        </div>
        <p class="control-panel-text-muted">Edit the content and settings for your About page.</p>

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

        <form id="about-edit-form" method="POST" action="{{ route('admin.pages.update-about') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            @method('PUT')

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-info-circle"></i> Hero Section
                </h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="hero_title" class="control-panel-label">Hero Title</label>
                        <input 
                            type="text" 
                            id="hero_title" 
                            name="hero_title" 
                            value="{{ old('hero_title', (isset($aboutSetting) && !empty($aboutSetting->hero_title)) ? $aboutSetting->hero_title : 'TURISMO COMUNITARIO') }}"
                            class="control-panel-input"
                            placeholder="TURISMO COMUNITARIO"
                        >
                    </div>
                </div>
            </div>
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-info-circle"></i> ¿Quiénes Somos?
                </h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="about_title" class="control-panel-label">Título</label>
                        <input 
                            type="text" 
                            id="about_title" 
                            name="about_title" 
                            value="{{ old('about_title', (isset($aboutSetting) && !empty($aboutSetting->title)) ? $aboutSetting->title : '¿QUIÉNES SOMOS?') }}"
                            class="control-panel-input"
                            placeholder="¿QUIÉNES SOMOS?"
                        >
                    </div>
                    <div>
                        <label for="about_description" class="control-panel-label">Descripción</label>
                        <textarea 
                            id="about_description" 
                            name="about_description" 
                            class="control-panel-input"
                            rows="5"
                            placeholder="Somos un centro de experiencias que ofrece inmersión cultural, compromiso con la sostenibilidad, turismo comunitario y gastronomía con productos locales. Atraemos a viajeros conscientes y amantes de la cultura que comparten nuestros valores."
                        >{{ old('about_description', (isset($aboutSetting) && !empty($aboutSetting->description)) ? $aboutSetting->description : 'Somos un centro de experiencias que ofrece inmersión cultural, compromiso con la sostenibilidad, turismo comunitario y gastronomía con productos locales. Atraemos a viajeros conscientes y amantes de la cultura que comparten nuestros valores.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- About Cards Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-th-large"></i> Valores (Cards)</h3>
                <p>Edita los valores que aparecen como tarjetas en la sección "¿Quiénes somos?"</p>
                @php
                    $defaultCards = [
                        ['title' => 'Autenticidad'],
                        ['title' => 'Sostenibilidad'],
                        ['title' => 'Conexión'],
                        ['title' => 'Aprendizaje'],
                    ];
                    $cards = old('cards', (isset($aboutSetting) && !empty($aboutSetting->cards)) ? json_decode($aboutSetting->cards, true) : $defaultCards);
                @endphp
                <div id="about-cards-list">
                    @foreach($cards as $i => $card)
                        <div class="control-panel-form-grid" style="align-items: end;">
                            <div style="flex:1;">
                                <label class="control-panel-label">Título de la tarjeta #{{ $i+1 }}</label>
                                <input type="text" name="cards[{{ $i }}][title]" class="control-panel-input" value="{{ old('cards.'.$i.'.title', $card['title'] ?? '') }}" placeholder="Título">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Banner Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-image"></i> Banner</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="banner_text" class="control-panel-label">Banner Text</label>
                        <input type="text" id="banner_text" name="banner_text" class="control-panel-input" value="{{ old('banner_text', (isset($aboutSetting) && !empty($aboutSetting->banner_text)) ? $aboutSetting->banner_text : '"TRAVEL WITH RESPECT FOR NATURE AND CULTURES”') }}">
                    </div>
                    <div>
                        <label for="banner_image" class="control-panel-label">Banner Image</label>
                        @if(isset($aboutSetting) && !empty($aboutSetting->banner_image))
                            <div><img src="{{ asset('storage/' . $aboutSetting->banner_image) }}" alt="Banner" style="max-width:120px;"></div>
                        @endif
                        <input type="file" id="banner_image" name="banner_image" class="control-panel-input">
                    </div>
                </div>
            </div>

            <!-- Headline Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-users"></i> Headline (Equipo)</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="headline_title" class="control-panel-label">Headline Title</label>
                        <input type="text" id="headline_title" name="headline_title" class="control-panel-input" value="{{ old('headline_title', (isset($aboutSetting) && !empty($aboutSetting->headline_title)) ? $aboutSetting->headline_title : '¿QUIÉN ESTÁ DETRÁS DE INNATO?') }}">
                    </div>
                </div>
                @php
                    $defaultHeadlineCards = [
                        [
                            'title' => 'JOHANNA VITERI',
                            'subtitle' => 'Founder',
                            'degree' => 'Ms. en Gestión de Destinos Turísticos.',
                            'description' => 'Administración de Empresas Hoteleras y Turísticas. Gest de recursos hotelero y turístico.',
                            'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80',
                        ],
                        [
                            'title' => 'CYNTHIA VITERI',
                            'subtitle' => 'Founder',
                            'degree' => 'Ms. en RI en Econ. para el Desarrollo.',
                            'description' => 'Gerencia de proyectos de desarrollo rural, administración y gestión financiera.',
                            'image' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80',
                        ],
                    ];
                    $headlineCards = old('headline_cards', isset($aboutSetting) && !empty($aboutSetting->headline_cards) ? json_decode($aboutSetting->headline_cards, true) : $defaultHeadlineCards);
                @endphp
                <div id="headline-cards-list">
                    @foreach($headlineCards as $i => $card)
                        <div class="control-panel-form-grid" style="align-items: end; border:1px solid #eee; margin-bottom:10px; padding:10px;">
                            <div>
                                <label class="control-panel-label">Nombre</label>
                                <input type="text" name="headline_cards[{{ $i }}][title]" class="control-panel-input" value="{{ old('headline_cards.'.$i.'.title', $card['title'] ?? '') }}" placeholder="Nombre">
                            </div>
                            <div>
                                <label class="control-panel-label">Rol/Subtítulo</label>
                                <input type="text" name="headline_cards[{{ $i }}][subtitle]" class="control-panel-input" value="{{ old('headline_cards.'.$i.'.subtitle', $card['subtitle'] ?? '') }}" placeholder="Rol o subtítulo">
                            </div>
                            <div>
                                <label class="control-panel-label">Título académico</label>
                                <input type="text" name="headline_cards[{{ $i }}][degree]" class="control-panel-input" value="{{ old('headline_cards.'.$i.'.degree', $card['degree'] ?? '') }}" placeholder="Título académico">
                            </div>
                            <div>
                                <label class="control-panel-label">Descripción</label>
                                <textarea name="headline_cards[{{ $i }}][description]" class="control-panel-input" rows="2" placeholder="Descripción">{{ old('headline_cards.'.$i.'.description', $card['description'] ?? '') }}</textarea>
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
                        </div>
                    @endforeach
                </div>
                <!-- Removed 'Agregar persona' button as requested -->
            </div>

            <!-- Destinations Section (only title and button editable, values are static) -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-map-marker-alt"></i> Destinos</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="destinations_title" class="control-panel-label">Destinations Title</label>
                        <input type="text" id="destinations_title" name="destinations_title" class="control-panel-input" value="{{ old('destinations_title', (isset($aboutSetting) && !empty($aboutSetting->destinations_title)) ? $aboutSetting->destinations_title : 'VISITA EL CENTRO DE EXPERIENCIAS TURÍSTICAS') }}">
                    </div>
                    <div>
                        <label for="destinations_button_text" class="control-panel-label">Button Text</label>
                        <input type="text" id="destinations_button_text" name="destinations_button_text" class="control-panel-input" value="{{ old('destinations_button_text', (isset($aboutSetting) && !empty($aboutSetting->destinations_button_text)) ? $aboutSetting->destinations_button_text : 'UBICACIÓN') }}">
                    </div>
                </div>
            </div>

        </form>
    </div>

    <!-- Fixed Action Buttons -->
    <div class="control-panel-fixed-actions">
        <a href="{{ route('admin.pages') }}" class="control-panel-button">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" form="about-edit-form" class="control-panel-button">
            <i class="fas fa-save"></i> Save Changes
        </button>
        <a href="/about" target="_blank" class="control-panel-button">
            <i class="fas fa-external-link-alt"></i> View About Page
        </a>
    </div>

    <script>
        function previewHeadlineImage(input, imgId) {
            const img = document.getElementById(imgId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                    console.log('Preview updated for', imgId);
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
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" form="about-edit-form" class="control-panel-button">
            <i class="fas fa-save"></i> Save Changes
        </button>
        <a href="/about" target="_blank" class="control-panel-button">
            <i class="fas fa-external-link-alt"></i> View About Page
        </a>
    </div>
</x-control-panel-layout>
