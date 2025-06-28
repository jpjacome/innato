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
        <h1 class="fade-in-2">TURISMO COMUNITARIO</h1>
    </section>

        <div class="icon fade-in-3">
            <img id="icon-fauna" src="../assets/imgs/icon-fauna.svg" alt="Orange vector abstract illustration">
        </div>

    <section class="about-section">
        <h2 class="about-title fade-in-1">¿QUIÉNES SOMOS?</h2>
        <p class="about-description fade-in-1"> Somos un centro de experiencias que ofrece inmersión cultural, compromiso con la sostenibilidad, turismo comunitario y gastronomía con productos locales. Atraer a viajeros conscientes y amantes de la cultura que compartan nuestros mismos valores:</P>
        <div class="about-cards fade-in-2">
            <div class="about-card-container">
                <div class="about-card"><p class='fade-in-3'>Autenticidad</p></div><span class="number">1</span>
            </div>
            <div class="about-card-container">
                <div class="about-card"><p class='fade-in-3'>Sostenibilidad</p></div><span class="number">2</span>
            </div>
            <div class="about-card-container">
                <div class="about-card"><p class='fade-in-3'>Conexión</p></div><span class="number">3</span>
            </div>
            <div class="about-card-container">
                <div class="about-card"><p class='fade-in-3'>Aprendizaje</p></div><span class="number">4</span>
            </div>
        </div>
    </section>

    <!-- Banner Section -->
    <section class="banner-section">
        <h3>"TRAVEL WITH RESPECT FOR NATURE AND CULTURES”</h3>
        <div class="icon fade-in-3">
            <img id="icon-coral" src="../assets/imgs/icon-coral.svg" alt="Orange vector abstract illustration">
        </div>
    </section>

    <!-- Headline Section -->
    <section id="headline" class="wrapper headline-section">
        <h2 class="headline-title fade-in-2">¿QUIÉN ESTÁ DETRÁS DE INNATO?</h2>
        <div class="headline-cards fade-in-1">
            <div class="headline-card">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Coast Nature" class="headline-card-img">
                <div class="info">
                    <h3 class="headline-card-title">JOHANNA VITERI <span>(Founder)</span></h3>
                    <h4>Ms. en Gestión de Destinos Turísticos.</h4>
                    <p>Administración de Empresas Hoteleras y Turísticas. Gest de recursos hotelero y turístico.</p>
                </div>

            </div>
            <div class="headline-card">
                <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80" alt="Andes Nature" class="headline-card-img">
                <div class="info">
                    <h3 class="headline-card-title">CYNTHIA VITERI <span>(Founder)</span></h3>
                    <h4>Ms. en RI en Econ. para el Desarrollo.</h4>
                    <p> Gerencia de proyectos de desarrollo rural, administración y gestión financiera.</p>
                </div>
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
                <span class="destinations-value">TRAVEL WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>            </div>
        </div>

    <!-- Footer -->
    <x-footer />

    <div class="drpixel fade-in-1">
        <x-interactive-icon size="20px" />carefully crafted by <a href="https://drpixel.it.nf/">DR PIXEL</a>    </div>
    <script src="{{ asset('assets/js/home.js') }}"></script>
    
    @stack('scripts')
</body>
</html>