<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>INNATO – Turismo Comunitario</title>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="../css/destinations-style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <!-- Header Component -->
    <x-header />

        <div class="icon fade-in-3">
            <img id="icon-comunidad" src="../assets/imgs/icon-comunidad.svg" alt="Purple vector abstract illustration">
        </div>

    <!-- Banner Section -->
    <section class="banner-section">
        <div class="container">
            <h3> ECUADOR ES UN PARAÍSO, VEÁMOSLO JUNTOS.</h3>
            <p>Encuentra artículos de aventura y actividades al aire libre, artesanías, cultura, festividades, gastronomía, vida silvestre, tradiciones, leyendas, sitios históricos y más.</p>
        </div>
    </section>

    <!-- Headline Section -->
    <section id="headline" class="wrapper headline-section">        
            <div class="headline-cards fade-in-1">
            <a href="/destination">
                <div class="headline-card">
                    <div class="img-container">
                        <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600&h=400&fit=crop&crop=entropy&auto=format" alt="Nature Landscape" class="headline-card-img">
                    </div>
                    <div class="info">
                        <div class="title-container">
                            <h3 class="headline-card-title">YUNGUILLA</h3>
                            <i class="ph ph-arrow-right"></i>
                        </div>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia optio, minima fugiat nihil nemo adipisci omnis.</p>
                    </div>
                    <button class="cta-button">RESERVAR</button>
                </div>
            </a>
            <div class="headline-card">                
                <div class="img-container">
                    <img src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=600&h=400&fit=crop&crop=entropy&auto=format" alt="Nature Forest" class="headline-card-img">
                </div>
                <div class="info">
                    <div class="title-container">
                        <h3 class="headline-card-title">OYACACHI</h3>
                        <i class="ph ph-arrow-right"></i>
                    </div>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia optio, minima fugiat nihil nemo adipisci omnis.</p>
                </div>
                <button class="cta-button">RESERVAR</button>
            </div>
            <div class="headline-card">
                <div class="img-container">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop&crop=entropy&auto=format" alt="Nature Mountains" class="headline-card-img">
                </div>
                <div class="info">
                    <div class="title-container">
                        <h3 class="headline-card-title">AGUA BLANCA</h3>
                        <i class="ph ph-arrow-right"></i>
                    </div>                    
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia optio, minima fugiat nihil nemo adipisci omnis.</p>
                </div>
                <button class="cta-button">RESERVAR</button>
            </div>

        </div>
    </section>

    <!-- destinations Section -->
    <section class="wrapper destinations-section" id="destinations">
        <div class="container container-1 fade-in-1">
            <h2 class="destinations-title fade-in-1">EXPLORA ECUADOR Y SUS COMUNIDADES</h2>
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