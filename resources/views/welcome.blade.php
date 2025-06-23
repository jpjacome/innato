<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DR PIXEL') }}</title>
    <link rel="stylesheet" href="/css/home.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&family=Montserrat:wght@700&family=Righteous&family=Pacifico&family=Orbitron:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="control-panel-header">
        <div class="control-panel-header-content">
            <div class="control-panel-logo">
                <x-interactive-icon size="40px" />
                @if(isset($settings) && $settings && isset($settings->logo) && $settings->logo && $settings->show_logo)
                    <img src="{{ Storage::url($settings->logo) }}" alt="Logo" class="control-panel-logo-image">
                @else
                    <span class="control-panel-logo-text">{{ isset($settings) && $settings && isset($settings->dashboard_title) ? $settings->dashboard_title : config('app.name', 'Control Panel') }}</span>
                @endif
            </div>
        </div>
</div>
    <div class="wrapper-1">
        <div class="main main1">
            <div class="page page-1">
                <div class="logo">
                    <div class="icon-container">
                        <x-interactive-icon size="31vmin" />
                    </div>
                    <div class="logo-text">
                        <h1>DR PIXEL</h1>
                        <h3>Brand Healthcare</h3>
                    </div>
                </div>
            </div>
            <div class="page page-2">
                    <form method="POST" action="{{ route('login') }}" class="welcome-login-form" id="login-form">
                        @csrf
                        <h2>Login</h2>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" required autofocus autocomplete="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password">
                        </div>
                        <div class="form-group form-remember">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember Me</label>
                        </div>
                        <button type="submit" class="login-btn">Login</button>
                        <div class="form-links">
                            <a href="{{ route('password.request') }}">Forgot your password?</a>
                        </div>
                    </form>
                </div>
        </div>
        <footer>
            <div class="footer">
                <img src="/test/assets/logo1.png" alt="">
                <div class="footer-info">
                    <div class="footer-container">
                        <p>© 2025 - DR PIXEL</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Theme detection and application
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-theme', 'dark');
        }

        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            var nav = document.querySelector('.control-panel-nav');
            nav.classList.toggle('show');
        });
    </script>
</body>
</html>

