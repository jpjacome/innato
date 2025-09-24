<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $post['title'] ?? 'Blog Post' }} | El Patio Hostel Blog</title>
  <meta name="description" content="{{ Str::limit(strip_tags($post['excerpt'] ?? ''), 160) }}">
  <link rel="canonical" href="{{ url()->current() }}" />
  <link rel="stylesheet" href="/css/elpatio-test.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/phosphor-icons@1.4.2/src/css/icons.min.css" />
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{ addslashes($post['title'] ?? '') }}",
    "datePublished": "{{ $post['published_at'] ?? '' }}",
    "image": "{{ !empty($post['featured_image']) ? asset('storage/' . $post['featured_image']) : asset('/assets/elpatio/imgs/photo1.avif') }}",
    "author": {"@type": "Person","name": "El Patio"}
  }
  </script>
</head>
<body>
  <header class="header fadein-2">
        <a href="https://elpatiohostels.com/" class="logo fadein-2">
            <img class="logo-img" src="/assets/elpatio/imgs/logo4.png" alt="">
        </a>
    <nav class="nav fadein-2" id="nav">
      <a href="{{ route('elpatio') }}#about" class="menu-item" id="menu-item-1">ABOUT US</a>
      <a href="{{ route('elpatio') }}#rooms" class="menu-item" id="menu-item-2">ROOMS</a>
      <a href="{{ route('elpatio') }}#gallery" class="menu-item" id="menu-item-3">PHOTO GALLERY</a>
      <a href="{{ route('elpatio') }}#blog" class="menu-item" id="menu-item-4">BLOG</a>
      <a href="https://innatotravel.com/" class="menu-item" id="menu-item-5">TOURS</a>
    </nav>
    <div class="social-media fadein-3">
      <a href=""><img class="social-media-icon" src="/assets/elpatio/imgs/icon-instagram.svg" alt="Instagram"></a>
      <a href=""><img class="social-media-icon" src="/assets/elpatio/imgs/icon-tiktok.svg" alt="TikTok"></a>
      <a href=""><img class="social-media-icon" src="/assets/elpatio/imgs/icon-facebook.svg" alt="Facebook"></a>
    </div>
    <div class="hamburger" id="hamburger">&#9776;</div>
    <a href="" class="whatsapp-icon fadein-1"><img class="whatsapp" src="/assets/elpatio/imgs/icon-whatsapp.png" alt="WhatsApp"></a>
  </header>

  <div class="loading-screen fade-in-1">
    <img src="/assets/elpatio/imgs/logo1.png" alt="Loading...">
  </div>

  <main class="single-post-section fadein-1">
    <article class="single-blog-post fade-in-1">
      <div class="blog-card-img-masked">
        <div class="blog-card-img" style="background-image:url('{{ !empty($post['featured_image']) ? asset('storage/' . $post['featured_image']) : asset('/assets/elpatio/imgs/photo1.avif') }}');"></div>
        <svg class="blog-card-mask" width="100%" height="100%" viewBox="0 0 700 320" preserveAspectRatio="xMidYMid slice">
          <defs>
            <mask id="blog-circle-mask-single">
              <rect width="100%" height="100%" fill="white"/>
              <circle id="blog-single-mask-circle" cx="210" cy="160" r="200" fill="black"/>
            </mask>
          </defs>
          <rect width="100%" height="100%" fill="var(--color-3)" mask="url(#blog-circle-mask-single)"/>
        </svg>
      </div>
      <div class="blog-card-content">
        <h1 class="blog-card-title">{{ $post['title'] ?? 'Blog Post' }}</h1>
        <p class="blog-card-meta">{{ isset($post['published_at']) ? \Carbon\Carbon::parse($post['published_at'])->format('F j, Y') : '' }} &bull; by Staff</p>
        <div class="blog-card-excerpt">
          {!! nl2br(e($post['excerpt'] ?? '')) !!}
        </div>
        <div class="blog-post-body">
          {!! $post['body'] ?? '' !!}
        </div>
      </div>
    </article>
  </main>

  <footer>
    <div class="footer-wrapper fadein-1">
      <div class="footer-logo"></div>
      <div class="footer-column about fadein-2">
        <p>Luis Corder E5-58 y Reina Victoria</p>
        <p>Quito - Ecuador, EC170143</p>
        <p>info@elpatiohostels.com</p>
      </div>
      <div class="footer-column contact fadein-2">
        <p>Telephone: +(593) 2 2526 342</p>
        <p>WhatsApp: +(593) 992748998</p>
        <p>WhatsApp: +(593) 991448525</p>
      </div>
      <div class="social-media fadein-3">
        <a href=""><img class="social-media-icon" src="/assets/elpatio/imgs/icon-instagram.svg" alt="Instagram"></a>
        <a href=""><img class="social-media-icon" src="/assets/elpatio/imgs/icon-tiktok.svg" alt="TikTok"></a>
        <a href=""><img class="social-media-icon" src="/assets/elpatio/imgs/icon-facebook.svg" alt="Facebook"></a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 El Patio Hostel - Ecuador. All rights reserved.</p>
      <p class="made-by">Carefully crafted by <a href="http://drpixel.it.nf" target="_blank">Dr. Pixel</a></p>
    </div>
  </footer>

  <script src="{{ asset('assets/js/elpatio-test.js') }}"></script>
</body>
</html>
