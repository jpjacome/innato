@php
    $headerSetting = \App\Models\HeaderSetting::instance();
@endphp

@php
    // Helper for active nav
    function navActive($paths) {
        $current = request()->path();
        foreach ((array)$paths as $p) {
            if ($p === '' && $current === '/') return 'active';
            if ($p !== '' && (stripos($current, $p) === 0 || $current === $p)) return 'active';
        }
        return '';
    }
@endphp


<!-- Header Component -->
<header class="fade-in-1">
    <div class="header-bar">
        <div class="logo fade-in-1">
            @php
                $logoPath = null;
                $logoExtensions = ['svg','png','jpg','jpeg','gif'];
                $latestTime = 0;
                foreach ($logoExtensions as $ext) {
                    $candidate = public_path('assets/imgs/logo.' . $ext);
                    if (file_exists($candidate)) {
                        $fileTime = filemtime($candidate);
                        if ($fileTime > $latestTime) {
                            $latestTime = $fileTime;
                            $logoPath = asset('assets/imgs/logo.' . $ext);
                        }
                    }
                }
            @endphp
            <a href="/"><img src="{{ $logoPath ?? asset('assets/imgs/logo.png') }}" alt="logo-image"></a>
        </div>
        <nav class="main-nav fade-in-2">
            <ul class="nav-list">
                <li><a href="/about" class="{{ navActive('about') }}"><span class="nav-icon ph ph-users-three"></span><span class="nav-text">{{ $headerSetting->nav_about_text }}</span></a></li>
                <li class="nav-dropdown {{ navActive(['destinations','destinations/costa','destinations/sierra','destinations/amazonia','destinations/galapagos']) }}" x-data="{ open: false }" @mouseleave="open = false" style="position: relative;">
                    <a @mouseenter="open = true" @click.prevent="open = !open" class="{{ navActive(['destinations','destinations/costa','destinations/sierra','destinations/amazonia','destinations/galapagos']) }}">
                        <span class="nav-icon ph ph-path"></span>
                        <span class="nav-text">{{ $headerSetting->nav_destinations_text }}</span>
                        <span class="nav-dropdown-arrow ph ph-caret-down"></span>
                    </a>
                    <ul class="nav-dropdown-menu" x-show="open" x-transition>
                        <li><a href="/destinations/costa" class="{{ navActive('destinations/costa') }}">Costa</a></li>
                        <li><a href="/destinations/sierra" class="{{ navActive('destinations/sierra') }}">Sierra</a></li>
                        <li><a href="/destinations/amazonia" class="{{ navActive('destinations/amazonia') }}">Amazonia</a></li>
                        <li><a href="/destinations/galapagos" class="{{ navActive('destinations/galapagos') }}">Galapagos</a></li>
                    </ul>
                </li>
                <li><a href="/experience-center" class="{{ navActive('experience-center') }}"><span class="nav-icon ph ph-buildings"></span><span class="nav-text">{{ $headerSetting->nav_experience_text }}</span></a></li>
                <li><a href="/hostal" class="{{ navActive('hostal') }}"><span class="nav-icon ph ph-house-simple"></span><span class="nav-text">{{ $headerSetting->nav_hostal_text }}</span></a></li>
                <li><a href="/contact" class="{{ navActive('contact') }}"><span class="nav-icon ph ph-envelope-simple"></span><span class="nav-text">{{ $headerSetting->nav_contact_text }}</span></a></li>
            </ul>
            <i id="search-toggle" class="ph ph-magnifying-glass"></i>
            <a href="/login" id="login-link" class="header-login-link" title="Login"><i class="ph ph-user"></i></a>
            <i id="hamburger-toggle" class="ph ph-list hamburger-icon"></i>
        </nav>
    </div>
</header>

<div id="search-bar-container" class="search-bar-container fade-in-1">
    <form action="/destinations" method="GET" style="width:100%;display:flex;align-items:center;gap:0.5rem;">
        <input type="text" name="search" placeholder="{{ $headerSetting->search_placeholder }}" class="search-bar-input" value="{{ request('search') }}" />
        <button type="submit" class="search-bar-btn" title="Buscar">
            <i class="ph ph-magnifying-glass"></i>
        </button>
    </form>
</div>

<!-- Mobile Menu -->
<div id="mobile-menu" class="mobile-menu">
    <ul>
        <li><a href="/about" class="{{ navActive('about') }}">{{ $headerSetting->nav_about_text }}</a></li>
        <li><a href="/destinations" class="{{ navActive('destinations') }}">{{ $headerSetting->nav_destinations_text }}</a></li>
        <li><a href="/experience-center" class="{{ navActive('experience-center') }}">{{ $headerSetting->nav_experience_text }}</a></li>
        <li><a href="/hostal" class="{{ navActive('hostal') }}">{{ $headerSetting->nav_hostal_text }}</a></li>
        <li><a href="/contact" class="{{ navActive('contact') }}">{{ $headerSetting->nav_contact_text }}</a></li>
    </ul>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchToggle = document.getElementById('search-toggle');
        const searchBar = document.getElementById('search-bar-container');
        let searchOpen = false;
        if (searchToggle && searchBar) {
            searchToggle.addEventListener('click', function() {
                searchOpen = !searchOpen;
                if (searchOpen) {
                    searchBar.classList.add('show');
                    setTimeout(() => { searchBar.querySelector('input').focus(); }, 350);
                } else {
                    searchBar.classList.remove('show');
                }
            });
        }

        // Hamburger menu logic
        const hamburger = document.getElementById('hamburger-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        let menuOpen = false;
        if (hamburger && mobileMenu) {
            hamburger.addEventListener('click', function() {
                menuOpen = !menuOpen;
                if (menuOpen) {
                    mobileMenu.classList.add('show');
                    hamburger.classList.remove('ph-list');
                    hamburger.classList.add('ph-x-circle');
                } else {
                    mobileMenu.classList.remove('show');
                    hamburger.classList.remove('ph-x-circle');
                    hamburger.classList.add('ph-list');
                }
            });
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('show');
                    hamburger.classList.remove('ph-x-circle');
                    hamburger.classList.add('ph-list');
                    menuOpen = false;
                });
            });
        }
        // Highlight active nav item (JS fallback)
        var currentUrl = window.location.pathname;
        document.querySelectorAll('.nav-list a').forEach(function(a) {
            if (a.getAttribute('href') === currentUrl || (currentUrl.startsWith(a.getAttribute('href')) && a.getAttribute('href') !== '/')) {
                a.classList.add('active');
            }
        });
        document.querySelectorAll('#mobile-menu a').forEach(function(a) {
            if (a.getAttribute('href') === currentUrl || (currentUrl.startsWith(a.getAttribute('href')) && a.getAttribute('href') !== '/')) {
                a.classList.add('active');
            }
        });
    });
</script>
@endpush
