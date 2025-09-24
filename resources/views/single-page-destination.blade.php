@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="es">
@section('title', 'INNATO – Turismo Comunitario')
@section('single-destination-css')
    <link rel="stylesheet" href="../css/single-destination-style.css">
@endsection
@include('components.public-head')
<body class="home-page">
    <!-- Header Component -->
    <x-header />

    <!-- Hero Section -->
    <section class="hero fade-in-1 parallax" id="hero">
        @if(!empty($destination->gallery_images))
            <img src="{{ Storage::url($destination->gallery_images[0]) }}" alt="Main Photo">
        @else
            <img src="../assets/imgs/bg1.png" alt="">
        @endif
    </section>

        <div class="icon fade-in-3">
            <img id="icon-fauna" src="../assets/imgs/icon-fauna.svg" alt="Orange vector abstract illustration">
        </div>

    <!-- Headline Section -->
    <section id="headline" class="wrapper headline-section">
        <div class="container">
            <h2 class="fade-in-1">{{ strtoupper($destination->title) }}</h2>
            <p class="fade-in-2">{{ $destination->subtitle }}</p>
            
            <div class="destination-bento-grid">
                <!-- Description Card - Large -->
                <div class="bento-card description-card">
                    <h3>
                        <i class="ph ph-info"></i>
                        Experiencia Única
                    </h3>
                    <p>
                        {{ $destination->main_description ?? '' }}
                    </p>
                    <p>
                        {{ $destination->secondary_description ?? '' }}
                    </p>
                    <x-reservation-button />
                </div>

                <!-- Photos Gallery Card -->
                @if($destination->gallery_images && count($destination->gallery_images) > 0)
                <div class="bento-card gallery-card">
                    <h3>
                        <i class="ph ph-images"></i>
                        Fotos
                    </h3>
                    <div class="gallery-content">
                        <div class="photo-grid">
                            @foreach($destination->gallery_images as $index => $image)
                                @if($index < 8)
                                <div class="photo-item" onclick="openGalleryModal({{ $index }})">
                                    <img src="{{ Storage::url($image) }}" alt="Photo {{ $index + 1 }} of {{ $destination->title }}" loading="lazy">
                                    @if($index === 3 && count($destination->gallery_images) > 4)
                                        <div class="photo-overlay">
                                            <span>+{{ count($destination->gallery_images) - 4 }}</span>
                                        </div>
                                    @endif
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Location Card -->
                <div class="bento-card location-card">
                    <h3>
                        <i class="ph ph-map-pin"></i>
                        Ubicación
                    </h3>
                    <div class="location-details">
                        <div class="location-item">
                            <span>Provincia:</span> <strong>{{ $destination->province }}</strong>
                        </div>
                        <div class="location-item">
                            <span>Cantón:</span> <strong>{{ $destination->canton }}</strong>
                        </div>
                        <div class="location-item">
                            <span>Parroquia:</span> <strong>{{ $destination->parish }}</strong>
                        </div>
                        <div class="location-item">
                            <span>Sector:</span> <strong>{{ $destination->sector }}</strong>
                        </div>
                        <div class="reference-distance">
                            <i class="ph ph-navigation-arrow"></i>
                            <span>{{ $destination->reference_distance }}</span>
                        </div>
                    </div>
                </div>

                <!-- Climate Card -->
                <div class="bento-card climate-card">
                    <h3>
                        <i class="ph ph-sun-dim"></i>
                        Clima
                        <button class="temp-toggle-btn" onclick="toggleTemperatureUnit()" title="Cambiar unidad de temperatura">
                            <span id="temp-unit-display">°C</span>
                        </button>
                    </h3>
                    <div class="altitude-info">
                        <span class="altitude-label">
                            <i class="ph ph-mountains"></i>
                            Altitud:
                        </span>
                        <span class="altitude-value">{{ $destination->altitude ?? 'Información no disponible' }}</span>
                    </div>
                    <div class="climate-seasons">
                        <div class="season-item dry-season">
                            <span class="season-name">{{ $destination->climate_dry_season['name'] ?? 'Época Seca' }}</span>
                            <span class="season-time">{{ $destination->climate_dry_season['months'] ?? 'Junio - Noviembre' }}</span>
                            <span class="season-temp" data-celsius="{{ $destination->climate_dry_season['temperature'] ?? '27' }}">{{ ($destination->climate_dry_season['temperature'] ?? '27') }}°C</span>
                        </div>
                        <div class="season-item wet-season">
                            <span class="season-name">{{ $destination->climate_wet_season['name'] ?? 'Época Húmeda' }}</span>
                            <span class="season-time">{{ $destination->climate_wet_season['months'] ?? 'Diciembre - Mayo' }}</span>
                            <span class="season-temp" data-celsius="{{ $destination->climate_wet_season['temperature'] ?? '20' }}">{{ ($destination->climate_wet_season['temperature'] ?? '20') }}°C</span>
                        </div>
                    </div>
                </div>

                <!-- Access & Logistics Card -->
                <div class="bento-card access-card">
                    <h3>
                        <i class="ph ph-road-horizon"></i>
                        Acceso & Transporte
                    </h3>
                    <div class="access-details">
                        <div class="access-item">
                            <span><i class="ph ph-map-pin-line"></i> Desde:</span>
                            <strong>{{ $destination->access_from ?? 'Comuna Atravezado (1.4 KM)' }}</strong>
                        </div>
                        <div class="access-item">
                            <span><i class="ph ph-path"></i> Vía:</span>
                            <strong>{{ $destination->access_route ?? 'Asfaltado/Lastrada (Bueno)' }}</strong>
                        </div>
                        <div class="access-item">
                            <span><i class="ph ph-bus"></i> Transporte:</span>
                            <strong>{{ $destination->access_transport ?? 'Público/Privado (Cada 30 min)' }}</strong>
                        </div>
                        <div class="access-item">
                            <span><i class="ph ph-timer"></i> Tiempo:</span>
                            <strong>{{ $destination->access_time ?? '3-4 horas' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Activities Card -->
                <div class="bento-card activities-card">
                    <h3>
                        <i class="ph ph-activity"></i>
                        Actividades
                    </h3>
                    <div class="activities-grid">
                        @if($destination->activities && count($destination->activities) > 0)
                            @foreach($destination->getFormattedActivities() as $activity)
                                <div class="activity-tag">
                                    <i class="{{ $activity['icon'] }}"></i>
                                    <span>{{ $activity['name'] }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="activity-tag">
                                <i class="ph ph-mountains"></i>
                                <span>Senderismo</span>
                            </div>
                            <div class="activity-tag">
                                <i class="ph ph-camera"></i>
                                <span>Fotografía</span>
                            </div>
                            <div class="activity-tag">
                                <i class="ph ph-binoculars"></i>
                                <span>Observación de Aves</span>
                            </div>
                            <div class="activity-tag">
                                <i class="ph ph-leaf"></i>
                                <span>Observación de Flora</span>
                            </div>
                            <div class="activity-tag">
                                <i class="ph ph-campfire"></i>
                                <span>Camping</span>
                            </div>
                            <div class="activity-tag">
                                <i class="ph ph-bicycle"></i>
                                <span>Ciclismo</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Services Card -->
                <div class="bento-card services-card">
                    <h3>
                        <i class="ph ph-handshake"></i>
                        Servicios
                    </h3>
                    <div class="services-grid">
                        @if($destination->services && count($destination->services) > 0)
                            @foreach($destination->getFormattedServices() as $service)
                                <div class="service-tag {{ $service['available'] ? 'available' : 'unavailable' }}">
                                    <i class="{{ $service['icon'] }}"></i>
                                    <span>{{ $service['name'] }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="service-tag available">
                                <i class="ph ph-car"></i>
                                <span>Estacionamiento</span>
                            </div>
                            <div class="service-tag available">
                                <i class="ph ph-fork-knife"></i>
                                <span>Alimentación</span>
                            </div>
                            <div class="service-tag available">
                                <i class="ph ph-bed"></i>
                                <span>Alojamiento</span>
                            </div>
                            <div class="service-tag available">
                                <i class="ph ph-toilet-paper"></i>
                                <span>Baterías Sanitarias</span>
                            </div>
                            <div class="service-tag available">
                                <i class="ph ph-user-check"></i>
                                <span>Visitas Guiadas</span>
                            </div>
                            <div class="service-tag available">
                                <i class="ph ph-signpost"></i>
                                <span>Señalización</span>
                            </div>
                            <div class="service-tag available">
                                <i class="ph ph-shield-check"></i>
                                <span>Seguridad</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Ten en Cuenta Que Card -->
                <div class="bento-card considerations-card">
                    <h3>
                        <i class="ph ph-warning-circle"></i>
                        Ten en Cuenta Que
                    </h3>
                    <div class="considerations-list">
                        @if($destination->considerations && count($destination->considerations) > 0)
                            @foreach($destination->getFormattedConsiderations() as $consideration)
                                <div class="consideration-item">
                                    <i class="{{ $consideration['icon'] }}"></i>
                                    <span>{{ $consideration['text'] }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="consideration-item">
                                <i class="ph ph-clock"></i>
                                <span>Respetar horarios de visita establecidos</span>
                            </div>
                            <div class="consideration-item">
                                <i class="ph ph-leaf"></i>
                                <span>No recoger plantas ni alterar el ecosistema</span>
                            </div>
                            <div class="consideration-item">
                                <i class="ph ph-trash"></i>
                                <span>Llevar de vuelta todos los desechos</span>
                            </div>
                            <div class="consideration-item">
                                <i class="ph ph-users"></i>
                                <span>Mantener distancia en grupos grandes</span>
                            </div>
                            <div class="consideration-item">
                                <i class="ph ph-volume-x"></i>
                                <span>Evitar ruidos fuertes que perturben la fauna</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Qué Llevar Card -->
                <div class="bento-card what-to-bring-card">
                    <h3>
                        <i class="ph ph-backpack"></i>
                        Qué Llevar
                    </h3>
                    <div class="what-to-bring-list">
                        @if($destination->what_to_bring && count($destination->what_to_bring) > 0)
                            @foreach($destination->getFormattedWhatToBring() as $item)
                                <div class="bring-item">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['text'] }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="bring-item">
                                <i class="ph ph-sneaker"></i>
                                <span>Zapatos cómodos para caminar</span>
                            </div>
                            <div class="bring-item">
                                <i class="ph ph-sun"></i>
                                <span>Protector solar y sombrero</span>
                            </div>
                            <div class="bring-item">
                                <i class="ph ph-drop"></i>
                                <span>Botella de agua reutilizable</span>
                            </div>
                            <div class="bring-item">
                                <i class="ph ph-camera"></i>
                                <span>Cámara o teléfono para fotos</span>
                            </div>
                            <div class="bring-item">
                                <i class="ph ph-first-aid-kit"></i>
                                <span>Kit básico de primeros auxilios</span>
                            </div>
                            <div class="bring-item">
                                <i class="ph ph-jacket"></i>
                                <span>Ropa apropiada para el clima</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Difficulty Level Card -->
                <div class="bento-card difficulty-card">
                    <h3>
                        <i class="ph ph-gauge"></i>
                        Nivel de Dificultad
                    </h3>
                    @php
                        $difficultyData = $destination->getDifficultyData();
                    @endphp
                    <div class="difficulty-content">
                        <div class="difficulty-bars">
                            <div class="bar-container">
                                <div class="difficulty-bar bar-low {{ $difficultyData['level'] >= 1 ? 'active' : '' }}"></div>
                            </div>
                            <div class="bar-container">
                                <div class="difficulty-bar bar-medium {{ $difficultyData['level'] >= 2 ? 'active' : '' }}"></div>
                            </div>
                            <div class="bar-container">
                                <div class="difficulty-bar bar-high {{ $difficultyData['level'] >= 3 ? 'active' : '' }}"></div>
                            </div>
                        </div>
                        <div class="difficulty-info">
                            <span class="difficulty-label">Nivel:</span>
                            <span class="difficulty-value difficulty-{{ $difficultyData['color'] }}">
                                {{ $difficultyData['label'] }}
                            </span>
                        </div>
                    </div>
                </div>

                
            </div>                    <x-reservation-button/>
        </div>


        <div class="sidebar">
            <div class="headline-cards fade-in-1">
                @php
                    use Illuminate\Support\Str;
                    $randomSidebarDestinations = $destinations
                        ->reject(fn($d) => $d->slug === $destination->slug)
                        ->shuffle()
                        ->take(3);
                @endphp
                @foreach($randomSidebarDestinations as $sidebarDestination)
                    <a href="{{ route('destination.show', $sidebarDestination->slug) }}">
                        <div class="headline-card">
                            <div class="img-container">
                                @php
                                    $image = (is_array($sidebarDestination->gallery_images) && !empty($sidebarDestination->gallery_images)) ? $sidebarDestination->gallery_images[0] : null;
                                @endphp
                                <img src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/300x200?text=Imagen' }}" alt="{{ $sidebarDestination->title }}" class="headline-card-img">
                            </div>
                            <div class="info">
                                <div class="title-container">
                                    <h3 class="headline-card-title">{{ $sidebarDestination->title }}</h3>
                                    <i class="ph ph-arrow-right"></i>
                                </div>
                                <p>{{ Str::limit($sidebarDestination->main_description, 120, '...') }}</p>
                            </div>
                            <button class="cta-button">CONOCE MÁS</button>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- destinations Section -->
    <section class="wrapper destinations-section" id="destinations">
        <div class="container container-1 fade-in-1">
            <h2 class="destinations-title fade-in-1">VISITA EL CENTRO DE EXPERIENCIAS TURÍSTICAS</h2>
            <button class="cta-button fade-in-1">UBICACIÓN</button>            
        </div>        
    </section>


    <!-- Reviews Section -->
    
    <x-reviews-section :reviews="$reviews ?? []" />
        
        <div class="destinations-values">
            <div class="destinations-track">
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <!-- Duplicate for seamless scroll -->
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>            </div>        </div>

    <x-footer />
    
    <!-- Gallery Modal -->
    @if($destination->gallery_images && count($destination->gallery_images) > 0)
    <div id="galleryModal" class="gallery-modal">
        <div class="gallery-modal-content" style="position:relative;">
            <button class="gallery-close" onclick="closeGalleryModal()">
                <i class="ph ph-x"></i>
            </button>
            <div class="gallery-modal-body">
                <div class="gallery-main-image">
                    <img id="modalMainImage" src="" alt="Gallery image">
                    <button class="gallery-nav gallery-prev" onclick="prevGalleryImage()">
                        <i class="ph ph-caret-left"></i>
                    </button>
                    <button class="gallery-nav gallery-next" onclick="nextGalleryImage()">
                        <i class="ph ph-caret-right"></i>
                    </button>
                </div>
                <div class="gallery-thumbnails">
                    @foreach($destination->gallery_images as $index => $image)
                    <div class="gallery-thumbnail" data-index="{{ $index }}" onclick="showGalleryImage({{ $index }})">
                        <img src="{{ Storage::url($image) }}" alt="Thumbnail {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
                <div class="gallery-counter">
                    <span id="galleryCounter">1 / {{ count($destination->gallery_images) }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <script src="{{ asset('assets/js/home.js') }}"></script>
    
    <!-- Temperature Toggle JavaScript -->
    <script>
        let isCelsius = true;
        
        function toggleTemperatureUnit() {
            const tempElements = document.querySelectorAll('.season-temp');
            const toggleBtn = document.getElementById('temp-unit-display');
            
            tempElements.forEach(element => {
                const celsiusValue = element.getAttribute('data-celsius');
                const numericValue = parseFloat(celsiusValue); // Clean numeric value, no need to remove symbols
                
                if (isCelsius) {
                    // Convert to Fahrenheit
                    const fahrenheit = Math.round((numericValue * 9/5) + 32);
                    element.textContent = `${fahrenheit}°F`;
                } else {
                    // Convert back to Celsius
                    element.textContent = `${numericValue}°C`;
                }
            });
            
            // Update toggle button
            toggleBtn.textContent = isCelsius ? '°F' : '°C';
            isCelsius = !isCelsius;
        }
    </script>
    
    <!-- Gallery Modal JavaScript -->
    @if($destination->gallery_images && count($destination->gallery_images) > 0)
    <script>
        const galleryImages = @json($destination->gallery_images);
        let currentImageIndex = 0;
        
        function openGalleryModal(index = 0) {
            currentImageIndex = index;
            document.getElementById('galleryModal').style.display = 'flex';
            showGalleryImage(index);
            document.body.style.overflow = 'hidden';
        }
        
        function closeGalleryModal() {
            document.getElementById('galleryModal').style.display = 'none';
            document.body.style.overflow = '';
        }
        
        function showGalleryImage(index) {
            currentImageIndex = index;
            const imageUrl = '{{ asset("storage") }}/' + galleryImages[index];
            document.getElementById('modalMainImage').src = imageUrl;
            document.getElementById('galleryCounter').textContent = `${index + 1} / ${galleryImages.length}`;
            
            // Update active thumbnail
            document.querySelectorAll('.gallery-thumbnail').forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });
        }
        
        function nextGalleryImage() {
            const nextIndex = (currentImageIndex + 1) % galleryImages.length;
            showGalleryImage(nextIndex);
        }
        
        function prevGalleryImage() {
            const prevIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            showGalleryImage(prevIndex);
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeGalleryModal();
            }
        });
        
        // Close modal on backdrop click
        document.getElementById('galleryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGalleryModal();
            }
        });
    </script>
    @endif
    
    <!-- Alpine.js for modal interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')

    <!-- Reservation Modal as direct child of body -->
<div x-data x-show="$store.reservation.open" x-cloak class="reservation-modal-bg" style="z-index:9999; position:fixed; top:0; left:0; width:100vw; height:100vh; display:flex; align-items:center; justify-content:center;" @click.self="$store.reservation.open = false">
    <div class="reservation-modal">
        <button class="reservation-modal-close" @click="$store.reservation.open = false">&times;</button>
        <template x-if="!$store.reservation.sending && !$store.reservation.confirmed">
            <div class="reservation-modal-form-wrapper">
                @php
                    $destinationOptions = $destinations->map(function($d) {
                        return (object) ['id' => $d->id, 'name' => $d->title];
                    });
                    $selectedDestinationId = $destination->id ?? null;
                @endphp
                @include('components.reservation-form', ['destinations' => $destinationOptions, 'selectedDestinationId' => $selectedDestinationId])
            </div>
        </template>
        <template x-if="$store.reservation.sending">
            <div class="reservation-modal-sending">
                <div class="spinner"></div>
                <p>Enviando reserva...</p>
            </div>
        </template>
        <template x-if="$store.reservation.confirmed">
            <div class="reservation-modal-confirmed">
                <i class="ph ph-check-circle" style="font-size:2rem;color:#10b981;"></i>
                <h3>¡Reserva enviada!</h3>
                <p>Nos pondremos en contacto contigo pronto.</p>
                <button class="control-panel-button" @click="$store.reservation.open = false">Cerrar</button>
            </div>
        </template>
        <template x-if="$store.reservation.errorMsg">
            <div class="reservation-modal-error">
                <i class="ph ph-warning" style="font-size:2rem;color:#dc2626;"></i>
                <p x-text="$store.reservation.errorMsg"></p>
                <button class="control-panel-button" @click="$store.reservation.sending = false; $store.reservation.errorMsg = ''">Intentar de nuevo</button>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('reservation', {
        open: false,
        sending: false,
        confirmed: false,
        errorMsg: '',
        formData: {},
    });
});
</script>
</body>
</html>