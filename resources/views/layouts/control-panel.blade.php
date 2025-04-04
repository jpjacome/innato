@php
use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($settings) && $settings && isset($settings->dashboard_title) ? $settings->dashboard_title : config('app.name', 'Laravel') }} - Control Panel</title>

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
            <x-interactive-icon size="40px" borderScale="0.05" />
                @if(isset($settings) && $settings && isset($settings->logo) && $settings->logo && $settings->show_logo)
                    <img src="{{ Storage::url($settings->logo) }}" alt="Logo" class="control-panel-logo-image">
                @else
                    <span class="control-panel-logo-text">{{ isset($settings) && $settings && isset($settings->dashboard_title) ? $settings->dashboard_title : config('app.name', 'Control Panel') }}</span>
                @endif
            </div>
            
            <nav class="control-panel-nav">
                <a href="{{ route('welcome') }}" class="control-panel-button" target="_blank">Homepage</a>
                <a href="{{ route('admin.dashboard') }}" class="control-panel-button {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                
                @if(Auth::user()->isAdmin() || Auth::user()->isEditor())
                <a href="{{ route('admin.pages') }}" class="control-panel-button {{ request()->routeIs('admin.pages') ? 'active' : '' }}">Pages</a>
                @endif
                
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="control-panel-button">Users</a>
                    <a href="{{ route('admin.settings') }}" class="control-panel-button control-panel-button-secondary {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif
                
                <button onclick="toggleTheme()" class="control-panel-button control-panel-button-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon dark-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon light-icon" viewBox="0 0 20 20" fill="currentColor" style="display: none;">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
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
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize theme icons based on current theme
            const currentTheme = document.documentElement.getAttribute('data-theme');
            updateThemeIcon(currentTheme);
        });
        
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            updateThemeIcon(newTheme);
            
            fetch('/theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ theme: newTheme })
            });
        }
        
        function updateThemeIcon(theme) {
            const moonIcon = document.querySelector('.dark-icon');
            const sunIcon = document.querySelector('.light-icon');
            
            if (theme === 'dark') {
                moonIcon.style.display = 'block';
                sunIcon.style.display = 'none';
            } else {
                moonIcon.style.display = 'none';
                sunIcon.style.display = 'block';
            }
        }
    </script>
</body>
</html> 