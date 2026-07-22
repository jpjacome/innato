<!DOCTYPE html>
<html lang="en">
  @php $elpatioSetting = \App\Models\ElPatioSetting::instance(); @endphp
  <x-elpatio.header />
<body>

  <div class="loading-screen fade-in-1">
      <img src="{{ $elpatioSetting->loading_logo ? asset('storage/' . $elpatioSetting->loading_logo) : '/assets/elpatio/imgs/logo1.png' }}" alt="">
    </div>


    <div class="wrapper hero-section">
      <div class="background fadein-2">
        <img src="{{ $elpatioSetting->hero_background ? (str_starts_with($elpatioSetting->hero_background, 'http') ? $elpatioSetting->hero_background : asset('storage/' . $elpatioSetting->hero_background)) : '/assets/elpatio/imgs/photo14.webp' }}" alt="">
      </div>
    </div>

    <!-- Cloudbeds Reservation Widget -->
    <div class="wrapper reservation-section fadein-1">
      <div class="reservation-widget">
        <h2>Book Your Stay</h2>
        <script src="https://hotels.cloudbeds.com/widget/load/NFYXpg/horiz?newWindow=1"></script>
      </div>
    </div>

    <div class="wrapper about-section fadein-4" id="about">
      <div class="container-1">
        @php
          $aboutTitle = $elpatioSetting->about_title ?? 'About our';
          $aboutHighlight = $elpatioSetting->about_title_highlight ?? 'Casa';
        @endphp
        <h2 class="fadein-4">{{ $aboutTitle }} <span class="highlight fadein-1">{{ $aboutHighlight }}</span></h2>
        <p class="fadein-2">{{ $elpatioSetting->about_text ?? 'El Patio Hostel is located two blocks from the heart of La Mariscal, Quito’s most entertaining and diverse area. Is on Luis Cordero street, the most beautiful (spot the lamps hanging over the street) and SAFE street in the neighborhood (police station at the corner). Our house is a typical nineteenth century style building. Reformed but preserving its historical value, it has private rooms and dorms, TV room, breakfast room and kitchen so you can feel at home. Not only that, but many common places and activities where you can share with other travelers and locals all your experiences.' }}</p>
      </div>
      <div class="container-2">
        <svg class="masked-image" id="parallax-svg" width="100%" height="100%" viewBox="0 0 600 400" preserveAspectRatio="xMidYMid slice">
          <defs>
            <mask id="circle-mask">
              <rect width="100%" height="100%" fill="white"/>
              <circle id="parallax-circle" cx="50%" cy="200" r="210" fill="black"/>
            </mask>
          </defs>
          <image href="/assets/elpatio/imgs/photo6.jpg" x="0" y="0" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"/>
          <rect width="100%" height="100%" fill="var(--color-4)" mask="url(#circle-mask)"/>
        </svg>
      </div>
    </div>
    <div class="wrapper about2-section fadein-1">
      <div class="container-1">
        <svg class="masked-image" id="parallax-svg-2" width="100%" height="100%" viewBox="0 0 600 400" preserveAspectRatio="xMidYMid slice">
          <defs>
            <mask id="circle-mask-2">
              <rect width="100%" height="100%" fill="white"/>
              <circle id="parallax-circle-2" cx="290" cy="250" r="140" fill="black"/>
            </mask>
          </defs>
          <image href="/assets/elpatio/imgs/photo2.avif" x="0" y="0" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"/>
          <rect width="100%" height="100%" fill="var(--color-5)" mask="url(#circle-mask-2)"/>
        </svg>
      </div>
      <div class="container-2">
        @php
          $about2Title = $elpatioSetting->about2_title ?? 'Why ';
          $about2Highlight = $elpatioSetting->about2_title_highlight ?? 'El Patio?';
        @endphp
        <h2>{{ $about2Title }} <span class="highlight">{{ $about2Highlight }}</span></h2>
        <p>{{ $elpatioSetting->about2_text ?? 'The main characteristic of these houses is that they have several courtyards that make the family lifestyle flourish around the house. We are more than a noisy rooftop, We have MANY SPACES to hang out: The terrace with a cool urban garden (Spot the hummingbirds’ family living at the tree), The Pergolita to chill and relax, and the big Pergola where you can enjoy a cool drink and listen to good music. Is the perfect place to stay and explore the city, offering comfortable and affordable accommodation.' }}</p>
      </div>
    </div>

<div class="wrapper rooms-section fadein-1" id="rooms">
  @php
    $roomsTitle = $elpatioSetting->rooms_title ?? 'We provide the ';
    $roomsHighlight = $elpatioSetting->rooms_title_highlight ?? 'best facilities';
  @endphp
  <h2>{{ $roomsTitle }} <span class="highlight">{{ $roomsHighlight }}</span></h2>
  <div class="amenities">
    <ul class="amenities-list">
    @php
    // Support both array-cast (new) and legacy JSON string for amenities_list
    $amenities = [];
    $rawAmenities = $elpatioSetting->amenities_list ?? [];
    if (is_string($rawAmenities)) {
      $amenities = json_decode($rawAmenities, true) ?: [];
    } else {
      $amenities = $rawAmenities ?: [];
    }
        if (empty($amenities)) {
            $amenities = [
                ['icon' => 'ph ph-coffee', 'text' => 'BREAKFAST INCLUDED'],
                ['icon' => 'ph ph-cooking-pot', 'text' => 'FULLY EQUIPPED KITCHEN'],
                ['icon' => 'ph ph-bed', 'text' => 'SOLID WOOD BUNK BEDS (KING SINGLE 105X190CM)'],
                ['icon' => 'ph ph-t-shirt', 'text' => 'BEST-QUALITY COTTON LINENS'],
                ['icon' => 'ph ph-sim-card', 'text' => 'ECUADORIAN CELL PHONE SIM CARDS, ACTIVATED WITH YOUR INFO.'],
                ['icon' => 'ph ph-credit-card', 'text' => 'CREDIT CARD ACCEPTED'],
                ['icon' => 'ph ph-shield', 'text' => 'BIG STORAGE LOCKERS'],
                ['icon' => 'ph ph-user', 'text' => 'PERSONAL ACCESS'],
                ['icon' => 'ph ph-bathtub', 'text' => 'TIDY BATHROOMS'],
                ['icon' => 'ph ph-thermometer-hot', 'text' => 'HOT WATER'],
                ['icon' => 'ph ph-airplane', 'text' => 'AIRPORT TRANSFER'],
                ['icon' => 'ph ph-clock', 'text' => 'LATE CHECK IN'],
                ['icon' => 'ph ph-wifi-high', 'text' => 'FREE HIGH-SPEED WI-FI'],
                ['icon' => 'ph ph-television', 'text' => 'TV ROOM'],
                ['icon' => 'ph ph-suitcase', 'text' => 'LUGGAGE STORE SERVICE'],
                ['icon' => 'ph ph-calendar', 'text' => 'DAY-USE SERVICE'],
                ['icon' => 'ph ph-t-shirt', 'text' => 'LAUNDRY SERVICE'],
            ];
        }
      @endphp
      @foreach($amenities as $a)
        <li><i class="{{ $a['icon'] ?? ($a['class'] ?? 'ph ph-dot') }}"></i>{{ $a['text'] ?? $a['label'] ?? '' }}</li>
      @endforeach
    </ul>
  </div>
  <svg class="triangle-svg fade-in-2" width="200" height="200" viewBox="0 0 200 200">
    <polygon points="0,0 200,0 200,200" fill="var(--color-4)" stroke="none" stroke-width="0"/>
    <foreignObject  x="30" y="0" width="160" height="120">
      <div class="triangle-text" xmlns="http://www.w3.org/1999/xhtml">
        Not a common Hostel<br>more like your<br>home in Quito
      </div>
    </foreignObject>
  </svg>
</div>

  <div class="photo-gallery fadein-1" id="gallery">
  <div class="swiper swiper-main">
      <div class="swiper-wrapper main">
        @php
          // Ensure gallery is an array. Support both array-cast (new) and legacy JSON string.
          $rawGallery = $elpatioSetting->gallery ?? [];
          if (is_string($rawGallery)) {
              $galleryItems = json_decode($rawGallery, true) ?: [];
          } else {
              $galleryItems = $rawGallery ?: [];
          }
        @endphp
        @if(is_array($galleryItems) && count($galleryItems))
          @foreach($galleryItems as $g)
            @php $img = is_string($g) ? $g : ($g['image'] ?? null); $txt = is_string($g) ? '' : ($g['text'] ?? ''); @endphp
            @if($img)
              <div class="swiper-slide">
                <img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}" alt="{{ e($txt) }}">
                @if($txt)
                  <div class="slide-caption">{{ $txt }}</div>
                @endif
              </div>
            @endif
          @endforeach
        @endif
      </div>
    <!-- Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
  <div class="swiper swiper-thumbs">
    <div class="swiper-wrapper thumbs">
      @if(is_array($galleryItems) && count($galleryItems))
        @foreach($galleryItems as $g)
          @php $img = is_string($g) ? $g : ($g['image'] ?? null); @endphp
          @if($img)
            <div class="swiper-slide thumb-slide"><img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}" alt=""></div>
          @endif
        @endforeach
      @endif
    </div>
  </div>
</div>


<div class="wrapper latest-posts-section fadein-1" id="blog">
  <h2>Latest <span class="highlight">Blog Posts</span></h2>
  <div class="latest-posts">
    @php
      $latest = \App\Models\ElPatioPost::orderByDesc('published_at')->limit(3)->get();
    @endphp
    @foreach($latest as $lp)
      @php
        // Cycle three mask variants to mimic the original design
        $variant = ($loop->index % 3) + 1;
        $maskId = 'blog-circle-mask-' . $loop->index;
        // positions: 1 => 30%, 2 => 50%, 3 => 70%
        $cx = $variant === 1 ? '30%' : ($variant === 2 ? '50%' : '70%');
        $fillVar = $variant === 1 ? '--color-3' : ($variant === 2 ? '--color-2' : '--color-5');
      @endphp
      <a href="/elpatio/blog/{{ $lp->slug }}" class="blog-card">
        <div class="blog-card-img-masked">
          <div class="blog-card-img" style="background-image:url('{{ $lp->featured_image ? asset('storage/' . $lp->featured_image) : '/assets/elpatio/imgs/photo1.avif' }}');"></div>
          <svg class="blog-card-mask" width="100%" height="100%" viewBox="0 0 340 180" preserveAspectRatio="xMidYMid slice">
            <defs>
              <mask id="{{ $maskId }}">
                <rect width="100%" height="100%" fill="white"/>
                <circle cx="{{ $cx }}" cy="50%" r="100" fill="black"/>
              </mask>
            </defs>
            <rect width="100%" height="100%" fill="var({{ $fillVar }})" mask="url(#{{ $maskId }})"/>
          </svg>
        </div>
        <div class="blog-card-content">
          <h3 class="blog-card-title">{{ $lp->title }}</h3>
          <p class="blog-card-meta">{{ $lp->published_at ? $lp->published_at->format('F j, Y') : '' }} &bull; by Staff</p>
          <p class="blog-card-excerpt">{{ Str::limit(strip_tags($lp->excerpt ?? ''), 140) }}</p>
        </div>
      </a>
    @endforeach
  </div>
</div>


  <x-elpatio.footer />

  @php
    // Support both array-cast (new) and legacy JSON string for gallery
    $galleryItems = [];
    $rawGallery = $elpatioSetting->gallery ?? [];
    if (is_string($rawGallery)) {
        $galleryItems = json_decode($rawGallery, true) ?: [];
    } else {
        $galleryItems = $rawGallery ?: [];
    }
  @endphp
  <script>
    window.ElPatioGallery = {!! json_encode($galleryItems) !!};
  </script>
  <script src="{{ asset('assets/js/elpatio-test.js') }}?v={{ file_exists(public_path('assets/js/elpatio-test.js')) ? filemtime(public_path('assets/js/elpatio-test.js')) : time() }}"></script>
  <!-- Swiper.js -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>