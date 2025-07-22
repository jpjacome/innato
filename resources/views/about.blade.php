<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>INNATO – Turismo Comunitario</title>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="../css/about-style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <!-- Header Component -->
    <x-header />

    <!-- Hero Section -->
    <section class="hero fade-in-1 parallax" id="hero">
        <h1 class="fade-in-2">{{ isset($aboutSetting) && !empty($aboutSetting->hero_title) ? $aboutSetting->hero_title : 'TURISMO COMUNITARIO' }}</h1>
    </section>

        <div class="icon fade-in-3">
            <img id="icon-fauna" src="../assets/imgs/icon-fauna.svg" alt="Orange vector abstract illustration">
        </div>

    <section class="about-section">
        <h2 class="about-title fade-in-1">{{ isset($aboutSetting) && !empty($aboutSetting->title) ? $aboutSetting->title : '¿QUIÉNES SOMOS?' }}</h2>
        <p class="about-description fade-in-1">
            {!! nl2br(e(isset($aboutSetting) && !empty($aboutSetting->description)
                ? $aboutSetting->description
                : 'Somos un centro de experiencias que ofrece inmersión cultural, compromiso con la sostenibilidad, turismo comunitario y gastronomía con productos locales. Atraer a viajeros conscientes y amantes de la cultura que compartan nuestros mismos valores:')) !!}
        </p>
        <div class="about-cards fade-in-2">
            @php
                $defaultCards = [
                    ['title' => 'Autenticidad'],
                    ['title' => 'Sostenibilidad'],
                    ['title' => 'Conexión'],
                    ['title' => 'Aprendizaje'],
                ];
                $cards = (isset($aboutSetting) && !empty($aboutSetting->cards)) ? json_decode($aboutSetting->cards, true) : $defaultCards;
            @endphp
            @foreach($cards as $i => $card)
                <div class="about-card-container">
                    <div class="about-card"><p class='fade-in-3'>{{ $card['title'] ?? '' }}</p></div><span class="number">{{ $i+1 }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Banner Section -->
    <section class="banner-section">
        <h3>{{ (isset($aboutSetting) && !empty($aboutSetting->banner_text)) ? $aboutSetting->banner_text : '"TRAVEL WITH RESPECT FOR NATURE AND CULTURES”' }}</h3>
        <div class="icon fade-in-3">
            @if(isset($aboutSetting) && !empty($aboutSetting->banner_image))
                <img id="icon-coral" src="{{ asset('storage/' . $aboutSetting->banner_image) }}" alt="Banner illustration">
            @else
                <img id="icon-coral" src="../assets/imgs/icon-coral.svg" alt="Orange vector abstract illustration">
            @endif
        </div>
    </section>

    <!-- Headline Section -->
    <section id="headline" class="wrapper headline-section">
        <h2 class="headline-title fade-in-2">{{ (isset($aboutSetting) && !empty($aboutSetting->headline_title)) ? $aboutSetting->headline_title : '¿QUIÉN ESTÁ DETRÁS DE INNATO?' }}</h2>
        <div class="headline-cards fade-in-1">
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
                $headlineCards = (isset($aboutSetting) && !empty($aboutSetting->headline_cards)) ? json_decode($aboutSetting->headline_cards, true) : $defaultHeadlineCards;
            @endphp
            @foreach($headlineCards as $i => $card)
                <div class="headline-card">
                    @php
                        $defaultImages = [
                            'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80',
                            'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80',
                        ];
                        $fallbackImage = $defaultImages[$i % count($defaultImages)];
                        $imgSrc = $fallbackImage;
                        if (isset($card['image']) && !empty($card['image'])) {
                            if (str_starts_with($card['image'], 'http')) {
                                $imgSrc = $card['image'];
                            } else {
                                $imgSrc = asset('storage/' . $card['image']);
                            }
                        }
                    @endphp
                    <img src="{{ $imgSrc }}" alt="{{ $card['alt'] ?? 'Headline Image' }}" class="headline-card-img">
                    <div class="info">
                        <h3 class="headline-card-title">{{ $card['title'] ?? '' }} @if(!empty($card['subtitle']))<span>({{ $card['subtitle'] }})</span>@endif</h3>
                        @if(!empty($card['degree']))<h4>{{ $card['degree'] }}</h4>@endif
                        @if(!empty($card['description']))<p>{{ $card['description'] }}</p>@endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- destinations Section -->
    <section class="wrapper destinations-section" id="destinations">
        <div class="container container-1 fade-in-1">
            <h2 class="destinations-title fade-in-1">{{ (isset($aboutSetting) && !empty($aboutSetting->destinations_title)) ? $aboutSetting->destinations_title : 'VISITA EL CENTRO DE EXPERIENCIAS TURÍSTICAS' }}</h2>
            @if(isset($aboutSetting) && !empty($aboutSetting->destinations_button_text))
                <button class="cta-button fade-in-1">{{ $aboutSetting->destinations_button_text }}</button>
            @else
                <button class="cta-button fade-in-1">UBICACIÓN</button>
            @endif
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