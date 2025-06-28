<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>INNATO – Turismo Comunitario</title>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="../css/contact-style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <!-- Header Component -->
    <x-header />


    <!-- Banner Section -->
    <section class="banner-section">
        <div class="container container-1">
            <h1 class='fade-in-2'> CONTÁCTANOS Y VIAJEMOS JUNTOS POR EL ECUADOR.</h1>
            <p class='fade-in-1'>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Architecto, exercitationem ex. In veritatis saepe numquam, dolor itaque suscipit fuga tempore?</p>
            <div class="icon fade-in-3">
                <img id="icon-mano" src="../assets/imgs/icon-cacao.svg" alt="Orange vector illustration of a hand">
            </div>
        </div>
        <div class="container container-2">
            <img src="../assets/imgs/edge3.svg" alt="">
            <div class="form-container">
                <form class="contact-form fade-in-2">
                    <div class="form-group">
                        <label for="nombre">Nombre y Apellido</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="newsletter" name="newsletter">
                            <span class="checkmark"></span>
                            Agregarme al newsletter
                        </label>
                    </div>
                </form>
            </div>
            <button class="cta-button fade-in-1">ENVIAR</button>
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