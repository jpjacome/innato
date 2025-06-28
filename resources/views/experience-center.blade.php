<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>INNATO – Turismo Comunitario</title>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="../css/experience-center-style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <!-- Header Component -->
    <x-header />


    <!-- Banner Section -->
    <section class="banner-section">
        <div class="container container-1">
            <h1 class='fade-in-2'>VISITA NUESTRO LOCAL Y DISFRUTA DE UN CAFE.</h1>
            <p class='fade-in-1'>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Architecto, exercitationem ex. In veritatis saepe numquam, dolor itaque suscipit fuga tempore?</p>
            <button class="cta-button fade-in-1">CONOCE MÁS</button>
            <div class="icon fade-in-3">
                <img id="icon-cacao" src="../assets/imgs/icon-cacao.svg" alt="Green vector illustration of a cacao pod">
            </div>
        </div>
        <div class="container container-2">
            <video class="" autoplay muted loop>
                <source src="{{ asset('assets/vids/coffee.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <img src="../assets/imgs/edge1.svg" alt="">
        </div>
        <div class="container container-3">            
            <img src="../assets/imgs/edge2.svg" alt="">
            <img class="bg fade-img" src="../assets/imgs/bg2.png" alt="">
        </div>
        <div class="container container-4">
            <h2 class='fade-in-2'>VISÍTANOS Y DESCUBRE NUESTROS PRODUCTOS LOCALES.</h1>
            <p class='fade-in-1'>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Architecto, exercitationem ex. In veritatis saepe numquam, dolor itaque suscipit fuga tempore?</p>
            <button class="cta-button fade-in-1">CONOCE MÁS</button>
            <div class="icon fade-in-1">
                <img id="icon-comunidad" src="../assets/imgs/icon-comunidad.svg" alt="Purple vector abstract illustration">
            </div>
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