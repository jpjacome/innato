<!-- Unified public head partial for all public-facing Blade views -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="INNATO – Turismo Comunitario. Vive experiencias auténticas, sostenibles y culturales en Ecuador.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/imgs/favicon.png') }}">
    <!-- Social sharing images -->
    <meta property="og:image" content="{{ asset('assets/imgs/favicon.png') }}">
    <meta property="og:image:alt" content="INNATO logo">
    <meta name="twitter:image" content="{{ asset('assets/imgs/favicon.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <title>@yield('title', 'INNATO – Turismo Comunitario')</title>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <!-- Page-specific CSS -->
    @stack('public-css')
    <!-- About -->
    @hasSection('about-css')
        @yield('about-css')
    @endif
    <!-- Contact -->
    @hasSection('contact-css')
        @yield('contact-css')
    @endif
    <!-- Destinations -->
    @hasSection('destinations-css')
        @yield('destinations-css')
    @endif
    <!-- Experience Center -->
    @hasSection('experience-center-css')
        @yield('experience-center-css')
    @endif
    <!-- Home -->
    @hasSection('home-css')
        @yield('home-css')
    @endif
    <!-- Single Destination -->
    @hasSection('single-destination-css')
        @yield('single-destination-css')
    @endif
    <!-- JS dependencies -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Single Destination Alpine fallback -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Page-specific JS -->
    @stack('public-js')
    @stack('public-head')
</head>
