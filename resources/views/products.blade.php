<!DOCTYPE html>
<html lang="es">
@section('title', 'INNATO – Productos Locales')
@section('products-css')
    <link rel="stylesheet" href="../css/products.css">
@endsection
@include('components.public-head')
<body>
    <!-- Header Component -->
    <x-header />

    <div class="icon fade-in-3">
        <img class="icon-destinations icon-products" id="icon-productos" src="{{ asset('assets/imgs/icon-cacao.svg') }}" alt="Products icon">
    </div>

    <!-- Banner Section -->
    <section class="banner-section">
        <div class="container">
            <h3>{{ $productsSetting->banner_title ?? 'DESCUBRE NUESTROS PRODUCTOS LOCALES' }}</h3>
            <p>{{ $productsSetting->banner_description ?? 'Productos artesanales y naturales elaborados por las comunidades locales. Cada producto cuenta una historia de tradición, cultura y respeto por la naturaleza.' }}</p>
        </div>
    </section>

    <!-- Headline Section -->
    <section id="headline" class="wrapper headline-section">
        <div class="headline-cards fade-in-1">
            @forelse($products as $product)
                <!-- Product Card {{ $loop->iteration }} -->
                <a href="#producto-{{ $product->id }}">
                    <div class="headline-card">
                        <div class="img-container">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="headline-card-img">
                            @else
                                <img src="https://via.placeholder.com/300x200/666666/FFFFFF?text={{ urlencode($product->title) }}" alt="{{ $product->title }}" class="headline-card-img">
                            @endif
                        </div>
                        <div class="info">
                            <div class="title-container">
                                <h3 class="headline-card-title">{{ $product->title }}</h3>
                                <i class="ph ph-arrow-right"></i>
                            </div>
                            <p>{{ $product->description }}</p>
                        </div>
                        <button class="cta-button">CONOCE MÁS</button>
                    </div>
                </a>
            @empty
                <!-- No products message -->
                <div class="no-products-message" style="text-align: center; padding: 2rem; color: #666; grid-column: 1 / -1;">
                    <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <h3>No hay productos disponibles</h3>
                    <p>Los productos se mostrarán aquí una vez que sean agregados por el administrador.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Products Section -->
    <section class="wrapper destinations-section" id="products">
        <div class="container container-1 fade-in-1">
            <h2 class="destinations-title fade-in-1">PRODUCTOS AUTÉNTICOS DE NUESTRAS COMUNIDADES</h2>
            <button class="cta-button fade-in-1">VER CATÁLOGO</button>            
        </div>        
    </section>
        
    <div class="destinations-values">
        <div class="destinations-track">
            <span class="destinations-value">PRODUCTS WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
            <span class="destinations-value">PRODUCTS WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
            <span class="destinations-value">PRODUCTS WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
            <span class="destinations-value">PRODUCTS WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
            <span class="destinations-value">PRODUCTS WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
            <span class="destinations-value">PRODUCTS WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
            <span class="destinations-value">PRODUCTS WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
            <span class="destinations-value">PRODUCTS WITH RESPECT FOR NATURE AND CULTURES<i class="ph ph-minus"></i></span>
        </div>
    </div>

    <!-- Footer -->
    <x-footer />

    <script src="{{ asset('assets/js/home.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
