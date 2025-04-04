<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Boreal – Plants Database</title>
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
            max-width: 1200px;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem 2rem;
        }

        .plant-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .plant-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            animation: fadeIn 1s ease;
        }

        .plant-card:hover {
            transform: translateY(-5px);
        }

        .plant-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .plant-info {
            padding: 1rem;
        }

        .plant-name {
            font-size: 1.2rem;
            margin: 0 0 0.5rem;
            color: #333;
        }

        .plant-family {
            font-size: 0.9rem;
            color: #666;
            margin: 0 0 0.8rem;
        }

        .plant-link {
            display: inline-block;
            background: #4a7bca;
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .plant-link:hover {
            background: #3a6ab0;
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
            .plant-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            .main-title {
                font-size: 1.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header>
        <div class="header-container">
            <img src="/plants/assets/imgs/logo-boreal-black.png" alt="Boreal Logo" class="logo">
            <a href="/" class="home-icon"><i class="fas fa-home"></i></a>
        </div>
    </header>

    <div class="container">
        <h1 class="main-title">Plants Database</h1>
        
        <div class="plant-grid">
            @forelse($plants as $plant)
                <div class="plant-card">
                    @if($plant->images->isNotEmpty())
                        <img src="{{ $plant->images->first()->image_path }}" alt="{{ $plant->name }}" class="plant-image">
                    @else
                        <div class="plant-image" style="background-color: #eee; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-leaf" style="font-size: 3rem; color: #ccc;"></i>
                        </div>
                    @endif
                    <div class="plant-info">
                        <h3 class="plant-name">{{ $plant->name }}</h3>
                        @if($plant->family)
                            <p class="plant-family">{{ $plant->family }}</p>
                        @endif
                        <a href="{{ route('public.plants.show', $plant->id) }}" class="plant-link">View Details</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 0;">
                    <p>No plants found in the database yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation on scroll could be added here
        });
    </script>
</body>
</html> 