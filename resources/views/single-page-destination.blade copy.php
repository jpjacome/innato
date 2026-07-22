@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>INNATO – Turismo Comunitario</title>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/single-destination-style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
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
                <!-- Hero Info Card -->
                <div class="bento-card hero-info-card">
                    <div class="destination-coords">
                        <i class="ph ph-map-pin"></i>
                        <span>{{ $destination->coordinates }}</span>
                    </div>
                    <div class="conservation-status">
                        <span><i class="ph ph-shield-check"></i> {{ $destination->conservation_status }}</span>
                    </div>
                </div>
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
                    <div x-data="{ open: false, sending: false, confirmed: false, errorMsg: '', formData: {} }">
                        <button class="cta-button" @click="$store.reservation.open = true">RESERVAR AHORA</button>
                        {{--
                        <template x-if="open">
                            <div class="reservation-modal-bg" x-cloak @click.self="open = false">
                                <div class="reservation-modal">
                                    <button class="reservation-modal-close" @click="open = false">&times;</button>
                                    <template x-if="!sending && !confirmed">
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
                                    <template x-if="sending">
                                        <div class="reservation-modal-sending">
                                            <div class="spinner"></div>
                                            <p>Enviando reserva...</p>
                                        </div>
                                    </template>
                                    <template x-if="confirmed">
                                        <div class="reservation-modal-confirmed">
                                            <i class="ph ph-check-circle" style="font-size:2rem;color:#10b981;"></i>
                                            <h3>¡Reserva enviada!</h3>
                                            <p>Nos pondremos en contacto contigo pronto.</p>
                                            <button class="control-panel-button" @click="open = false">Cerrar</button>
                                        </div>
                                    </template>
                                    <template x-if="errorMsg">
                                        <div class="reservation-modal-error">
                                            <i class="ph ph-warning" style="font-size:2rem;color:#dc2626;"></i>
                                            <p x-text="errorMsg"></p>
                                            <button class="control-panel-button" @click="sending = false; errorMsg = ''">Intentar de nuevo</button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                        --}}
                    </div>
                </div>
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
                    </h3>
                    <div class="climate-seasons">
                        <div class="season-item dry-season">
                            <span class="season-name">{{ $destination->climate_dry_season['name'] ?? 'Época Seca' }}</span>
                            <span class="season-time">{{ $destination->climate_dry_season['months'] ?? 'Junio - Noviembre' }}</span>
                            <span class="season-temp">{{ $destination->climate_dry_season['temperature'] ?? '27°C' }}</span>
                        </div>
                        <div class="season-item wet-season">
                            <span class="season-name">{{ $destination->climate_wet_season['name'] ?? 'Época Húmeda' }}</span>
                            <span class="season-time">{{ $destination->climate_wet_season['months'] ?? 'Diciembre - Mayo' }}</span>
                            <span class="season-temp">{{ $destination->climate_wet_season['temperature'] ?? '20°C' }}</span>
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

                <!-- Schedule & Entry Card -->
                <div class="bento-card schedule-card">
                    <h3>
                        <i class="ph ph-clock"></i>
                        Horarios & Entrada
                    </h3>
                    <div class="schedule-details">
                        <div class="schedule-item">
                            <span><i class="ph ph-timer"></i> Horario:</span>
                            <strong>{{ $destination->schedule_hours ?? '06:00 - 17:00' }}</strong>
                        </div>
                        <div class="schedule-item">
                            <span><i class="ph ph-currency-dollar"></i> Entrada:</span>
                            <strong class="free-entry">{{ $destination->entry_fee ?? 'GRATIS ($0 USD)' }}</strong>
                        </div>
                        <div class="schedule-item">
                            <span><i class="ph ph-calendar"></i> Temporada:</span>
                            <strong>{{ $destination->season_availability ?? 'Todo el año' }}</strong>
                        </div>
                        <div class="schedule-item">
                            <span><i class="ph ph-identification-card"></i> Requisitos:</span>
                            <strong>{{ $destination->requirements ?? 'Ninguno' }}</strong>
                        </div>
                    </div>
                </div>



                <!-- Services & Facilities Card -->
                <div class="bento-card services-card">
                    <h3>
                        <i class="ph ph-activity"></i>
                        Servicios & Actividades
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
                                <i class="ph ph-wrench"></i>
                                <span>Talleres</span>
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

                <!-- Pricing & Accommodation Card -->
                <div class="bento-card pricing-card">
                    <h3>
                        <i class="ph ph-currency-dollar"></i>
                        Precios & Capacidad
                    </h3>
                    <div class="pricing-details">
                        <div class="price-item main-price">
                            <span>Hospedaje promedio:</span>
                            <strong>${{ $destination->average_price ?? '33' }} USD/persona</strong>
                        </div>
                        <div class="price-item">
                            <span>Capacidad:</span>
                            <strong>{{ $destination->capacity ?? '40' }} PAX</strong>
                        </div>
                        <div class="price-item">
                            <span>Pago:</span>
                            <strong>{{ $destination->payment_methods ?? 'Solo efectivo' }}</strong>
                        </div>
                        <div class="price-item">
                            <span>Cobertura móvil:</span>
                            <strong>{{ $destination->mobile_coverage ?? 'Sí disponible' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Tourism Criteria Card -->
                <div class="bento-card criteria-card">
                    <h3>
                        <i class="ph ph-medal"></i>
                        Criterios Turísticos
                    </h3>
                    <div class="criteria-list">
                        @if($destination->tourism_criteria)
                            <div class="criteria-item {{ ($destination->tourism_criteria['access'] ?? 'SI') == 'SI' ? 'positive' : 'neutral' }}">
                                <i class="ph {{ ($destination->tourism_criteria['access'] ?? 'SI') == 'SI' ? 'ph-check-circle' : 'ph-x-circle' }}"></i>
                                <span>Acceso a personas de tercera edad y/o con discapacidad: {{ $destination->tourism_criteria['access'] ?? 'SI' }}</span>
                            </div>
                            <div class="criteria-item {{ ($destination->tourism_criteria['access_status'] ?? 'SI') == 'SI' ? 'positive' : 'neutral' }}">
                                <i class="ph {{ ($destination->tourism_criteria['access_status'] ?? 'SI') == 'SI' ? 'ph-check-circle' : 'ph-x-circle' }}"></i>
                                <span>Estado del acceso para personas de tercera edad y/o con discapacidad: {{ $destination->tourism_criteria['access_status'] ?? 'SI' }}</span>
                            </div>
                            <div class="criteria-item {{ ($destination->tourism_criteria['security'] ?? 'SI') == 'SI' ? 'positive' : 'neutral' }}">
                                <i class="ph {{ ($destination->tourism_criteria['security'] ?? 'SI') == 'SI' ? 'ph-check-circle' : 'ph-x-circle' }}"></i>
                                <span>Seguridad en los alrededores: {{ $destination->tourism_criteria['security'] ?? 'SI' }}</span>
                            </div>
                            <div class="criteria-item positive">
                                <i class="ph ph-check-circle"></i>
                                <span>Cordialidad del Personal: {{ $destination->tourism_criteria['personnel'] ?? 'BUENO' }}</span>
                            </div>
                            <div class="criteria-item {{ ($destination->tourism_criteria['languages'] ?? 'NO') == 'SI' ? 'positive' : 'neutral' }}">
                                <i class="ph {{ ($destination->tourism_criteria['languages'] ?? 'NO') == 'SI' ? 'ph-check-circle' : 'ph-x-circle' }}"></i>
                                <span>Desempeño del personal en otros idiomas: {{ $destination->tourism_criteria['languages'] ?? 'NO' }}</span>
                            </div>
                            <div class="criteria-item positive">
                                <i class="ph ph-palette"></i>
                                <span>Concepto en la decoración del sitio: {{ $destination->tourism_criteria['decoration'] ?? 'PROPIO DE LA COSTA' }}</span>
                            </div>
                            <div class="criteria-item {{ ($destination->tourism_criteria['waste'] ?? 'NO') == 'SI' ? 'positive' : 'neutral' }}">
                                <i class="ph {{ ($destination->tourism_criteria['waste'] ?? 'NO') == 'SI' ? 'ph-check-circle' : 'ph-x-circle' }}"></i>
                                <span>Manejo de desechos: {{ $destination->tourism_criteria['waste'] ?? 'NO' }}</span>
                            </div>
                        @else
                            <div class="criteria-item positive">
                                <i class="ph ph-check-circle"></i>
                                <span>Acceso a personas de tercera edad y/o con discapacidad: SI</span>
                            </div>
                            <div class="criteria-item positive">
                                <i class="ph ph-check-circle"></i>
                                <span>Estado del acceso para personas de tercera edad y/o con discapacidad: SI</span>
                            </div>
                            <div class="criteria-item positive">
                                <i class="ph ph-check-circle"></i>
                                <span>Seguridad en los alrededores: SI</span>
                            </div>
                            <div class="criteria-item positive">
                                <i class="ph ph-check-circle"></i>
                                <span>Cordialidad del Personal: BUENO</span>
                            </div>
                            <div class="criteria-item neutral">
                                <i class="ph ph-x-circle"></i>
                                <span>Desempeño del personal en otros idiomas: NO</span>
                            </div>
                            <div class="criteria-item positive">
                                <i class="ph ph-palette"></i>
                                <span>Concepto en la decoración del sitio: PROPIO DE LA COSTA</span>
                            </div>
                            <div class="criteria-item neutral">
                                <i class="ph ph-x-circle"></i>
                                <span>Manejo de desechos: NO</span>
                            </div>
                        @endif
                    </div>
                </div>

                


                <!-- Suggestions Card -->
                <div class="bento-card suggestions-card">
                    <h3>
                        <i class="ph ph-lightbulb"></i>
                        Fortalezas & Beneficios
                    </h3>
                    <p>
                        {{ $destination->strengths_benefits ?? '' }}
                    </p>
                </div>
                
                <!-- Challenges Card -->
                <div class="bento-card challenges-card">
                    <h3>
                        <i class="ph ph-warning"></i>
                        Desafíos Ambientales
                    </h3>
                    <div class="challenges-content">
                        @if($destination->environmental_challenges && count($destination->environmental_challenges) > 0)
                            @php $challenge = $destination->environmental_challenges[0]; @endphp
                            <div class="challenge-item">
                                <div>
                                    <strong>
                                <i class="{{ $challenge['icon'] ?? 'ph ph-warning' }}"></i>{{ $challenge['title'] ?? 'Contaminación' }}:</strong>
                                    <span>{{ $challenge['description'] ?? 'Generación de residuos, especialmente plásticos en feriados que contaminan el entorno natural y marino.' }}</span>
                                </div>
                            </div>
                        @else
                            <div class="challenge-item">
                                <div>
                                    <strong>
                                <i class="ph ph-trash"></i>Contaminación:</strong>
                                    <span>Generación de residuos, especialmente plásticos en feriados que contaminan el entorno natural y marino.</span>
                                </div>
                            </div>
                        @endif
                    </div>
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
            </div>
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
    <section id="reviews" class="wrapper reviews-section section-light">
        <i class="ph ph-arrow-left reviews-icon reviews-icon-left"></i>
        <div class="reviews-list">
            <div class="review-card">
                <div class="stars">
                    <div class="more">...</div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                </div>
                <p class="review-text">“Excellent as always! This is a very nice choice if you like good food and a superb environment.”</p>
                <p class="reviewer-name">- Jhon Doe</p>
            </div>
            <div class="review-card">
                <div class="stars">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                </div>
                <p class="review-text">“A wonderful experience! The staff was friendly and the place was beautiful.”</p>
                <p class="reviewer-name">- Maria Perez</p>
            </div>
            <div class="review-card">
                <div class="stars">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                </div>
                <p class="review-text">“Unforgettable trip, highly recommended for families.”</p>
                <p class="reviewer-name">- Carlos Ruiz</p>
            </div>
            <div class="review-card">
                <div class="stars">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ED5934" viewBox="0 0 256 256"><path d="M239.18,97.26A16.38,16.38,0,0,0,224.92,86l-59-4.76L143.14,26.15a16.36,16.36,0,0,0-30.27,0L90.11,81.23,31.08,86a16.46,16.46,0,0,0-9.37,28.86l45,38.83L53,211.75a16.38,16.38,0,0,0,24.5,17.82L128,198.49l50.53,31.08A16.4,16.4,0,0,0,203,211.75l-13.76-58.07,45-38.83A16.43,16.43,0,0,0,239.18,97.26Zm-15.34,5.47-48.7,42a8,8,0,0,0-2.56,7.91l14.88,62.8a.37.37,0,0,1-.17.48c-.18.14-.23.11-.38,0l-54.72-33.65a8,8,0,0,0-8.38,0L69.09,215.94c-.15.09-.19.12-.38,0a.37.37,0,0,1-.17-.48l14.88-62.8a8,8,0,0,0-2.56-7.91l-48.7-42c-.12-.1-.23-.19-.13-.5s.18-.27.33-.29l63.92-5.16A8,8,0,0,0,103,91.86l24.62-59.61c.08-.17.11-.25.35-.25s.27.08.35.25L153,91.86a8,8,0,0,0,6.75,4.92l63.92,5.16c.15,0,.24,0,.33.29S224,102.63,223.84,102.73Z"></path></svg>
                </div>
                <p class="review-text">“The best eco-tourism experience in Ecuador.”</p>
                <p class="reviewer-name">- Luis Torres</p>
            </div>
        </div>
        <i class="ph ph-arrow-right reviews-icon reviews-icon-right"></i>
    </section>
        
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