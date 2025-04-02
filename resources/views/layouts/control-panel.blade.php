@php
use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Control Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Dynamic Control Panel Styles -->
    <link href="{{ route('control-panel.css') }}" rel="stylesheet">
</head>
<body class="control-panel">
    <header class="control-panel-header">
        <div class="control-panel-header-content">
            <div class="control-panel-logo">
                @if(isset($settings) && $settings->logo)
                    <img src="{{ Storage::url($settings->logo) }}" alt="Logo" class="control-panel-logo-image">
                @else
                    <span class="control-panel-logo-text">{{ config('app.name', 'Control Panel') }}</span>
                @endif
            </div>
            
            <nav class="control-panel-nav">
                <a href="{{ route('welcome') }}" class="control-panel-button" target="_blank">Homepage</a>
                <a href="{{ route('dashboard') }}" class="control-panel-button">Dashboard</a>
                
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="control-panel-button">Manage Users</a>
                    <a href="{{ route('settings.index') }}" class="control-panel-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @elseif (Auth::user()->isEditor())
                    <a href="{{ route('settings.index') }}" class="control-panel-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif
                
                <button onclick="toggleTheme()" class="control-panel-button control-panel-button-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                </button>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="control-panel-button control-panel-button-secondary">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="control-panel-main">
        @if(session('success'))
            <div class="control-panel-alert control-panel-alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="control-panel-alert control-panel-alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        {{ $slot }}
    </main>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            
            fetch('/theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ theme: newTheme })
            });
        }
    </script>
</body>
</html> 