<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&family=Montserrat:wght@700&family=Righteous&family=Pacifico&family=Orbitron:wght@700&display=swap" rel="stylesheet">
            <style>
            :root {
                --primary: #3d1b4d;
                --primary-mid: #5a2b72;
                --primary-light: #8d4ba8;
                --text: #1f2937;
                --text-light: #6b7280;
                --bg: #f9fafb;
                --card: #ffffff;
                --border: #e5e7eb;
            }

            [data-theme="dark"] {
                --primary: #6d28d9;
                --primary-mid: #5b21b6;
                --primary-light: #8b5cf6;
                --text: #f9fafb;
                --text-light: #d1d5db;
                --bg: #111827;
                --card: #1f2937;
                --border: #374151;
            }

            body {
                margin: 0;
                padding: 0;
                min-height: 100vh;
                font-family: 'Inter', sans-serif;
                color: var(--text);
                background-color: var(--bg);
                transition: background-color 0.3s, color 0.3s;
            }

            .hero {
                background-color: var(--primary);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 2rem;
                position: relative;
            }

            .hero-content {
                max-width: 800px;
                margin: 0 auto;
            }

            .hero-title {
                font-size: {{ $settings->title_size ?? '4rem' }};
                color: {{ $settings->title_color ?? '#FFFFFF' }};
                font-family: {{ $settings->title_font ?? 'Arial' }};
                margin: 0;
                line-height: 1.2;
            }

            .hero-subtitle {
                font-size: 1.5rem;
                color: rgba(255, 255, 255, 0.9);
                margin-top: 1rem;
            }

            .hero-buttons {
                margin-top: 2rem;
                display: flex;
                gap: 1rem;
                justify-content: center;
            }

            .hero-button {
                padding: 0.75rem 1.5rem;
                border-radius: 0.375rem;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.2s;
                color: white;
            }

            .login-button {
                background-color: var(--primary-mid);
            }

            .login-button:hover {
                background-color: var(--primary-light);
            }

            .register-button {
                background-color: transparent;
                border: 2px solid white;
            }

            .register-button:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }

            .users-section {
                min-height: 100vh;
                background-color: var(--primary);
                color: white;
                padding: 4rem 2rem;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .users-content {
                max-width: 1200px;
                width: 100%;
                text-align: center;
            }

            .kings-title {
                font-family: Verdana, sans-serif;
                font-size: 3.5rem;
                margin-bottom: 1rem;
                color: white;
            }

            .kings-list {
                font-family: Verdana, sans-serif;
                font-size: 2.5rem;
                margin-bottom: 3rem;
                color: white;
            }

            .princes-title {
                font-family: Impact, sans-serif;
                font-size: 3rem;
                margin-bottom: 1rem;
                color: white;
            }

            .princes-list {
                font-family: Impact, sans-serif;
                font-size: 2rem;
                color: white;
            }

            .user-name {
                margin: 0.5rem 0;
            }
            </style>
    </head>
    <body>
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">{{ $settings->title_text ?? 'WELCOME' }}</h1>
                <p class="hero-subtitle">Your journey begins here</p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="hero-button login-button">Log in</a>
                    <a href="{{ route('register') }}" class="hero-button register-button">Register</a>
                </div>
            </div>
        </section>

        <section class="users-section">
            <div class="users-content">
                <h2 class="kings-title">Kings:</h2>
                <div class="kings-list">
                    @forelse($adminUsers as $admin)
                        <div class="user-name">{{ $admin->name }}</div>
                    @empty
                        <div class="user-name">No Kings found</div>
                    @endforelse
                </div>
                
                <h2 class="princes-title">Princes:</h2>
                <div class="princes-list">
                    @forelse($regularUsers as $user)
                        <div class="user-name">{{ $user->name }}</div>
                    @empty
                        <div class="user-name">No Princes found</div>
                    @endforelse
                </div>
        </div>
        </section>

        <script>
            // Theme detection and application
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        </script>
    </body>
</html>

