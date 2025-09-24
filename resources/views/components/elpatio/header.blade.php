
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Best Hostel in Quito - El Patio Hostel</title>
  <link rel="stylesheet" href="/css/elpatio-test.css">
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/elpatio/imgs/logo4.png') }}" type="image/png">
  <link rel="apple-touch-icon" href="{{ asset('assets/elpatio/imgs/logo4.png') }}">

  <!-- Meta / Social -->
  <meta name="description" content="El Patio Hostel — comfortable, friendly hostel in the heart of Quito. Private rooms and dorms, social spaces, and tours nearby.">
  <meta name="theme-color" content="#ffffff">

  <!-- Open Graph -->
  <meta property="og:title" content="El Patio Hostel - Quito">
  <meta property="og:description" content="Comfortable, friendly hostel in the heart of Quito. Private rooms, dorms and local tours.">
  <meta property="og:image" content="{{ asset('assets/elpatio/imgs/logo4.png') }}">
  <meta property="og:type" content="website">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="El Patio Hostel - Quito">
  <meta name="twitter:description" content="Comfortable, friendly hostel in the heart of Quito. Private rooms, dorms and local tours.">
  <meta name="twitter:image" content="{{ asset('assets/elpatio/imgs/logo4.png') }}">

  <!-- Swiper.js CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/phosphor-icons@1.4.2/src/css/icons.min.css" />
</head>
<header class="header fadein-2">
    <a href="https://elpatiohostels.com/" class="logo fadein-2">
      <img class="logo-img" src="/assets/elpatio/imgs/logo4.png" alt="">
    </a>
    @php
      $elpatioMenu = \App\Models\ElPatioSetting::instance()->header_menu ?? [];
    @endphp
    <nav class="nav fadein-2" id="nav">
      @if(is_array($elpatioMenu) && count($elpatioMenu))
        @foreach($elpatioMenu as $i => $item)
          <a href="{{ $item['url'] ?? '#' }}" class="menu-item" id="menu-item-{{ $i+1 }}">{{ $item['label'] ?? '' }}</a>
        @endforeach
      @else
        <a href="#about" class="menu-item" id="menu-item-3">ABOUT US</a>
        <a href="#rooms" class="menu-item" id="menu-item-2">ROOMS</a>
        <a href="#gallery" class="menu-item" id="menu-item-4">PHOTO GALLERY</a>
        <a href="#blog" class="menu-item" id="menu-item-5">BLOG</a>
        <a href="https://innatotravel.com/" class="menu-item" id="menu-item-6">TOURS</a>
      @endif
    </nav>  
    @php $social = \App\Models\ElPatioSetting::instance()->social_links ?? []; @endphp
    <div class="social-media fadein-3">
      <a href="{{ $social['instagram'] ?? '' }}"><img class="social-media-icon" src="/assets/elpatio/imgs/icon-instagram.svg" alt="Instagram"></a>
      <a href="{{ $social['tiktok'] ?? '' }}"><img class="social-media-icon" src="/assets/elpatio/imgs/icon-tiktok.svg" alt="TikTok"></a>
      <a href="{{ $social['facebook'] ?? '' }}"><img class="social-media-icon" src="/assets/elpatio/imgs/icon-facebook.svg" alt="Facebook"></a>
    </div>
    <div class="hamburger" id="hamburger">&#9776;</div>
    <a href="" class="whatsapp-icon fadein-1"><img class="whatsapp" src="/assets/elpatio/imgs/icon-whatsapp.png" alt=""></a>
    <!-- Hamburger Fullscreen Menu Overlay -->
    <div class="hamburger-menu" id="hamburger-menu">
      <nav class="hamburger-nav">
        @if(is_array($elpatioMenu) && count($elpatioMenu))
          @foreach($elpatioMenu as $item)
            <a href="{{ $item['url'] ?? '#' }}" class="hamburger-menu-item">{{ $item['label'] ?? '' }}</a>
          @endforeach
        @else
          <a href="#about" class="hamburger-menu-item">ABOUT US</a>
          <a href="#rooms" class="hamburger-menu-item">ROOMS</a>
          <a href="#gallery" class="hamburger-menu-item">PHOTO GALLERY</a>
          <a href="#blog" class="hamburger-menu-item">BLOG</a>
          <a href="https://innatotravel.com/" class="hamburger-menu-item">TOURS</a>
        @endif
      </nav>
      <div class="hamburger-social">
        <a href="{{ $social['instagram'] ?? '' }}"><img class="social-media-icon" src="/assets/elpatio/imgs/icon-instagram.svg" alt="Instagram"></a>
        <a href="{{ $social['tiktok'] ?? '' }}"><img class="social-media-icon" src="/assets/elpatio/imgs/icon-tiktok.svg" alt="TikTok"></a>
        <a href="{{ $social['facebook'] ?? '' }}"><img class="social-media-icon" src="/assets/elpatio/imgs/icon-facebook.svg" alt="Facebook"></a>
      </div>
      <button class="hamburger-close" id="hamburger-close" aria-label="Close menu">&times;</button>
    </div>
      <script>
        // Highlight nav menu items while scrolling to sections.
        document.addEventListener('DOMContentLoaded', function () {
          const links = Array.from(document.querySelectorAll('nav a.menu-item'));
          const sections = links.map(a => {
            const hash = a.getAttribute('href') || '';
            if (!hash.startsWith('#')) return null;
            return document.getElementById(hash.slice(1));
          });

          function updateActive() {
            let currentId = null;
            for (const s of sections) {
              if (!s) continue;
              const rect = s.getBoundingClientRect();
              // If the section top is near the top half of the viewport, mark it
              if (rect.top <= window.innerHeight * 0.45 && rect.bottom > window.innerHeight * 0.15) {
                currentId = s.id;
                break;
              }
            }
            links.forEach(l => l.classList.toggle('active', currentId && l.getAttribute('href') === ('#' + currentId)));
          }

          // Update on load and on scroll (passive listener)
          updateActive();
          window.addEventListener('scroll', updateActive, { passive: true });
          window.addEventListener('resize', updateActive);

          // Ensure clicking anchors sets active immediately
          links.forEach(l => l.addEventListener('click', () => setTimeout(updateActive, 50)));
          // Also handle direct hash navigation
          window.addEventListener('hashchange', updateActive);
        });
      </script>
  </header>
