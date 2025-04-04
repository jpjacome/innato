<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Boreal – {{ $plant->name }}</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9f9f9;
      color: #333;
      line-height: 1.6;
      overflow-x: hidden;
    }

    header {
      background: #e7eef9;
      animation: fadeInDown 1s ease-in-out;
      padding: 1rem 0;
    }

    .header-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      max-width: 120px;
      height: auto;
    }

    .home-icon {
      font-size: 1.5rem;
      color: #333;
    }

    .main-title {
      text-align: left;
      margin: 2rem 0;
      font-size: 2rem;
      font-weight: 500;
      letter-spacing: 1px;
      animation: fadeIn 1.5s ease;
    }
    .container {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 1rem 2rem;
    }

    section {
      margin-bottom: 2rem;
      animation: fadeIn 1.5s ease-in;
    }

    h2 {
      font-size: 1.4rem;
      color: #444;
      border-bottom: 1px solid #ddd;
      padding-bottom: 0.4rem;
      margin-bottom: 1rem;
    }

    .log-table {
      width: 100%;
      border-collapse: collapse;
    }

    .log-table td {
      padding: 0.5rem 1rem;
      border-bottom: 1px solid #e0e0e0;
    }

    .thumbnail-container {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .thumbnail {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 4px;
      cursor: pointer;
      border: 1px solid #ddd;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .thumbnail:hover {
      transform: scale(1.05);
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .info-card p {
      margin: 0.3rem 0;
    }

    .slider {
      position: relative;
      width: 100%;
      overflow: hidden;
      border-radius: 8px;
    }

    .slide-wrapper {
      display: flex;
      transition: transform 0.5s ease;
      width: 100%;
    }

    .slide {
      min-width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .slide img {
      max-width: 100%;
      max-height: 400px;
      object-fit: contain;
      cursor: pointer;
      border-radius: 8px;
    }

    .nav-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255, 255, 255, 0.8);
      border: none;
      font-size: 2rem;
      cursor: pointer;
      z-index: 2;
      padding: 0 0.5rem;
      border-radius: 5px;
    }

    .prev { left: 10px; }
    .next { right: 10px; }

    .fade-in {
      animation: fadeIn 1.5s ease;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.85);
      justify-content: center;
      align-items: center;
    }

    .modal img {
      max-width: 90%;
      max-height: 90%;
      border-radius: 10px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
      .main-title { font-size: 1.5rem; }
      .logo { max-width: 100px; }
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

  <header>
    <div class="header-container">
      <a href="{{ url('/') }}">
        <img src="{{ asset('plantas/assets/imgs/logo-boreal-black.png') }}" alt="Boreal Logo" class="logo">
      </a>
      <a href="{{ route('public.plants.index') }}">
        <i class="fas fa-home home-icon"></i>
      </a>
    </div>
  </header>

  <div class="container">
    <h1 class="main-title">{{ $plant->name }}</h1>
    
    @if($plant->maintenanceLogs->isNotEmpty())
    <section>
      <h2>Maintenance Log</h2>
      <table class="log-table">
        @php $latestLog = $plant->maintenanceLogs->first(); @endphp
        <tr><td><strong>Last Watering:</strong></td><td>{{ $latestLog->last_watering ? $latestLog->last_watering->format('F j, Y') : 'Not recorded' }}</td></tr>
        <tr><td><strong>Next Watering:</strong></td><td>{{ $latestLog->next_watering ? $latestLog->next_watering->format('F j, Y') : 'Not scheduled' }}</td></tr>
        <tr><td><strong>Last Fertilization:</strong></td><td>{{ $latestLog->last_fertilization ? $latestLog->last_fertilization->format('F j, Y') : 'Not recorded' }}</td></tr>
        <tr><td><strong>Next Fertilization:</strong></td><td>{{ $latestLog->next_fertilization ? $latestLog->next_fertilization->format('F j, Y') : 'Not scheduled' }}</td></tr>
        <tr><td><strong>Last Pruning:</strong></td><td>{{ $latestLog->last_pruning ? $latestLog->last_pruning->format('F j, Y') : 'Not recorded' }}</td></tr>
        <tr><td><strong>Next Pruning:</strong></td><td>{{ $latestLog->next_pruning ? $latestLog->next_pruning->format('F j, Y') : 'Not scheduled' }}</td></tr>
        <tr><td><strong>Pest/Disease Inspection:</strong></td><td>{{ $latestLog->pest_disease_inspection ?? 'No inspections recorded' }}</td></tr>
        @if($latestLog->images->isNotEmpty())
        <tr>
          <td><strong>Latest Images:</strong></td>
          <td>
            <div class="thumbnail-container">
              @foreach($latestLog->images as $image)
              <img src="{{ $image->image_path }}" alt="{{ $plant->name }} Maintenance Image" class="thumbnail">
              @endforeach
            </div>
          </td>
        </tr>
        @endif
      </table>
    </section>
    @endif

    @if($plant->images->isNotEmpty())
    <section class="slider-section">
      <h2>Images</h2>
      <div class="slider">
        <button class="nav-btn prev">&#10094;</button>
        <div class="slide-wrapper" id="slideWrapper">          
          @foreach($plant->images as $image)
          <div class="slide"><img src="{{ $image->image_path }}" alt="{{ $plant->name }}"></div>
          @endforeach
        </div>
        <button class="nav-btn next">&#10095;</button>
      </div>
    </section>
    @endif

    <section class="info-card fade-in">
      <h2>Botanical Information</h2>
      <p><strong>Common Names:</strong> {{ $plant->common_names ?? 'Not specified' }}</p>
      <p><strong>Family:</strong> {{ $plant->family ?? 'Not specified' }}</p>
      <p><strong>Native Range:</strong> {{ $plant->native_range ?? 'Not specified' }}</p>
      <p><strong>Age:</strong> {{ $plant->age ?? 'Not specified' }}</p>
      <p><strong>Current Height:</strong> {{ $plant->current_height ?? 'Not specified' }}</p>
      <p><strong>Expected Height:</strong> {{ $plant->expected_height ?? 'Not specified' }}</p>
      <p><strong>Leaf Type:</strong> {{ $plant->leaf_type ?? 'Not specified' }}</p>
      <p><strong>Bloom Time:</strong> {{ $plant->bloom_time ?? 'Not specified' }}</p>
      <p><strong>Flower Color:</strong> {{ $plant->flower_color ?? 'Not specified' }}</p>
      <p><strong>Fruit:</strong> {{ $plant->fruit ?? 'Not specified' }}</p>
      <p><strong>Light:</strong> {{ $plant->light ?? 'Not specified' }}</p>
      <p><strong>Soil:</strong> {{ $plant->soil ?? 'Not specified' }}</p>
      <p><strong>Hardiness:</strong> {{ $plant->hardiness ?? 'Not specified' }}</p>
    </section>

    @if($plant->other_comments)
    <section>
      <h2>Other Comments</h2>
      <p>{{ $plant->other_comments }}</p>
    </section>
    @endif

  </div>

  <!-- Modal for full-screen images -->
  <div class="modal" id="imageModal">
    <img id="modalImg" src="" alt="Full View">
  </div>

  <script>
    const wrapper = document.querySelector('.slide-wrapper');
    const slides = document.querySelectorAll('.slide');
    const prev = document.querySelector('.prev');
    const next = document.querySelector('.next');
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');
    let index = 0;

    if (wrapper && slides.length > 0) {
      function updateSlider() {
        wrapper.style.transform = `translateX(-${index * 100}%)`;
      }

      if (prev) {
        prev.addEventListener('click', () => {
          index = (index <= 0) ? slides.length - 1 : index - 1;
          updateSlider();
        });
      }

      if (next) {
        next.addEventListener('click', () => {
          index = (index + 1) % slides.length;
          updateSlider();
        });
      }

      slides.forEach(slide => {
        const img = slide.querySelector('img');
        if (img) {
          img.addEventListener('click', () => {
            modal.style.display = 'flex';
            modalImg.src = img.src;
          });
        }
      });
    }

    // Add click event for thumbnails
    document.querySelectorAll('.thumbnail').forEach(thumbnail => {
      thumbnail.addEventListener('click', () => {
        modal.style.display = 'flex';
        modalImg.src = thumbnail.src;
      });
    });

    if (modal) {
      modal.addEventListener('click', () => {
        modal.style.display = 'none';
      });
    }
  </script>
</body>
</html> 