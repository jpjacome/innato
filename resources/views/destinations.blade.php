<!DOCTYPE html>
<html lang="es">
@section('title', 'INNATO – Turismo Comunitario')
@section('destinations-css')
    <link rel="stylesheet" href="../css/destinations-style.css">
@endsection
@include('components.public-head')
<body>
    <!-- Header Component -->
    <x-header />

        <div class="icon fade-in-3">
            @php
                $iconClass = (isset($region) && !request('search'))
                    ? 'icon-' . strtolower($region)
                    : 'icon-comunidad';
                $iconFile = (isset($region) && !request('search'))
                    ? 'icon-' . strtolower($region) . '.svg'
                    : 'icon-comunidad.svg';
                $iconAlt = (isset($region) && !request('search'))
                    ? ucfirst($region) . ' region icon'
                    : 'Purple vector abstract illustration';
            @endphp
            <img class="icon-destinations {{ $iconClass }}" id="icon-comunidad" src="{{ asset('assets/imgs/' . $iconFile) }}" alt="{{ $iconAlt }}">
        </div>

    <!-- Banner Section -->
    <section class="banner-section">
        <div class="container">
            <h3>
                @if(isset($region))
                    {{ strtoupper($region) }}
                @elseif(isset($destinationsSetting) && !empty($destinationsSetting->banner_title))
                    {{ $destinationsSetting->banner_title }}
                @else
                    ECUADOR ES UN PARAÍSO, VEÁMOSLO JUNTOS.
                @endif
            </h3>
            <p>{{ isset($destinationsSetting) && !empty($destinationsSetting->banner_description) ? $destinationsSetting->banner_description : 'Encuentra artículos de aventura y actividades al aire libre, artesanías, cultura, festividades, gastronomía, vida silvestre, tradiciones, leyendas, sitios históricos y más.' }}</p>
            @if(isset($destinationsSetting) && !empty($destinationsSetting->banner_image))
                <img src="{{ asset('storage/' . $destinationsSetting->banner_image) }}" alt="Banner" style="max-width:120px;">
            @endif
        </div>
    </section

    <!-- Headline Section -->
    <section id="headline" class="wrapper headline-section">
        <div class="headline-cards fade-in-1">
            @php
                use Illuminate\Support\Str;
            @endphp
            @foreach($destinations as $destination)
                <a href="{{ route('destination.show', $destination->slug) }}">
                    <div class="headline-card">
                        <div class="img-container">
                            @php
                                $image = (is_array($destination->gallery_images) && !empty($destination->gallery_images)) ? $destination->gallery_images[0] : null;
                            @endphp
                            <img src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/300x200?text=Imagen' }}" alt="{{ $destination->title }}" class="headline-card-img">
                        </div>
                        <div class="info">
                            <div class="title-container">
                                <h3 class="headline-card-title">{{ $destination->title }}</h3>
                                <i class="ph ph-arrow-right"></i>
                            </div>
                            <p>{{ Str::limit($destination->main_description, 120, '...') }}</p>
                        </div>
                        <button class="cta-button">CONOCE MÁS</button>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- destinations Section -->
    <section class="wrapper destinations-section" id="destinations">
        <div class="container container-1 fade-in-1">
            <h2 class="destinations-title fade-in-1">{{ (isset($destinationsSetting) && !empty($destinationsSetting->destinations_title)) ? $destinationsSetting->destinations_title : 'EXPLORA ECUADOR Y SUS COMUNIDADES' }}</h2>
            <button class="cta-button fade-in-1">{{ (isset($destinationsSetting) && !empty($destinationsSetting->destinations_button_text)) ? $destinationsSetting->destinations_button_text : 'UBICACIÓN' }}</button>            
        </div>        
    </section>
        
        <div class="destinations-values">
            <div class="destinations-track">
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
            </div>
        </div>

    <!-- Footer -->
    <x-footer />

    <div class="drpixel fade-in-1">
        <x-interactive-icon size="20px" />carefully crafted by <a href="https://drpixel.it.nf/">DR PIXEL</a>    </div>
    <script src="{{ asset('assets/js/home.js') }}"></script>
    
    @stack('scripts')
</body>
</html>