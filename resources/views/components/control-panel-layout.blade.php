@props(['title' => null])

@php
use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? (isset($settings) && $settings && isset($settings->dashboard_title) ? $settings->dashboard_title : config('app.name', 'Laravel')) }} - Control Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Dynamic Control Panel Styles -->
    <link href="{{ route('control-panel.css') }}" rel="stylesheet">
</head>
<body class="control-panel">
    <header class="control-panel-header">
        <div class="control-panel-header-content">
            <div class="control-panel-logo">
            <x-interactive-icon size="40px" />
                @if(isset($settings) && $settings && isset($settings->logo) && $settings->logo && $settings->show_logo)
                    <img src="{{ Storage::url($settings->logo) }}" alt="Logo" class="control-panel-logo-image">
                @else
                    <span class="control-panel-logo-text">{{ isset($settings) && $settings && isset($settings->dashboard_title) ? $settings->dashboard_title : config('app.name', 'Control Panel') }}</span>
                @endif
            </div>
            
            <!-- Hamburger Menu Icon -->
            <div class="hamburger-menu-icon" id="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <nav class="control-panel-nav">
                <a href="{{ route('welcome') }}" class="control-panel-button  header-nav-button" target="_blank">Homepage</a>
                <a href="{{ route('admin.dashboard') }}" class="control-panel-button {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}  header-nav-button">Panel</a>
                
                @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isEditor()))
                <a href="{{ route('admin.pages') }}" class="control-panel-button {{ request()->routeIs('admin.pages') ? 'active' : '' }} header-nav-button">Páginas</a>
                @endif
                
                @if (Auth::check() && Auth::user()->isAdmin())
                <div class="control-panel-dropdown">
                    <button class="control-panel-button header-nav-button dropdown-trigger {{ request()->routeIs('admin.components.*') ? 'active' : '' }}">
                        Componentes <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="control-panel-dropdown-menu">
                        <a href="{{ route('admin.components.edit-header') }}" class="control-panel-dropdown-item {{ request()->routeIs('admin.components.edit-header') ? 'active' : '' }}">Encabezado</a>
                        <a href="{{ route('admin.components.edit-footer') }}" class="control-panel-dropdown-item {{ request()->routeIs('admin.components.edit-footer') ? 'active' : '' }}">Pie de página</a>
                        <a href="{{ route('admin.components.edit-reviews') }}" class="control-panel-dropdown-item {{ request()->routeIs('admin.components.edit-reviews') ? 'active' : '' }}">Reseñas</a>
                    </div>
                </div>

                <a href="{{ route('admin.destinations.index') }}" class="control-panel-button {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }} header-nav-button">Destinos</a>
                <a href="{{ route('admin.maintenance.index') }}" class="control-panel-button {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }} header-nav-button">Mantenimiento</a>
                <a href="{{ route('admin.settings') }}" class="control-panel-button {{ request()->routeIs('admin.settings') ? 'active' : '' }} header-nav-button">Configuración</a>
                @endif
            </nav>
            
            <!-- Mobile Menu (hidden by default) -->
            <div class="control-panel-mobile-menu" id="mobile-menu">
                <a href="{{ route('welcome') }}" class="control-panel-button">Inicio</a>
                <a href="{{ route('admin.dashboard') }}" class="control-panel-button {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Panel</a>
                
                @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isEditor()))
                <a href="{{ route('admin.pages') }}" class="control-panel-button {{ request()->routeIs('admin.pages') ? 'active' : '' }}">Páginas</a>
                @endif
                
                @if (Auth::check() && Auth::user()->isAdmin())
                <div class="control-panel-mobile-section">
                    <span class="control-panel-mobile-section-title">Componentes</span>
                    <a href="{{ route('admin.components.edit-header') }}" class="control-panel-button {{ request()->routeIs('admin.components.edit-header') ? 'active' : '' }}">Encabezado</a>
                    <a href="{{ route('admin.components.edit-footer') }}" class="control-panel-button {{ request()->routeIs('admin.components.edit-footer') ? 'active' : '' }}">Pie de página</a>
                    <a href="{{ route('admin.components.edit-reviews') }}" class="control-panel-button {{ request()->routeIs('admin.components.edit-reviews') ? 'active' : '' }}">Reseñas</a>
                </div>
                
                <a href="{{ route('admin.destinations.index') }}" class="control-panel-button {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">Destinos</a>
                <a href="{{ route('admin.maintenance.index') }}" class="control-panel-button {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">Mantenimiento</a>
                <a href="{{ route('admin.settings') }}" class="control-panel-button {{ request()->routeIs('admin.settings') ? 'active' : '' }}">Configuración</a>
                @endif
            </div>
            
            <button onclick="toggleTheme()" class="control-panel-theme-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon dark-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon light-icon" viewBox="0 0 20 20" fill="currentColor" style="display: none;">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <!-- Mobile Theme Toggle -->
            <button onclick="toggleTheme()" class="control-panel-theme-toggle-mobile">
                <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon dark-icon-mobile" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon light-icon-mobile" viewBox="0 0 20 20" fill="currentColor" style="display: none;">
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
        
        <!-- Output raw JSON for Alpine to read safely (now in layout, before slot) -->
        @if(View::hasSection('reviews_json_data'))
            @yield('reviews_json_data')
        @endif
        {{ $slot }}
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize theme icons based on current theme
            const currentTheme = document.documentElement.getAttribute('data-theme');
            updateThemeIcon(currentTheme);
            // Mobile menu toggle
            document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.toggle('active');
                this.classList.toggle('active');
            });
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
            const moonIconMobile = document.querySelector('.dark-icon-mobile');
            const sunIconMobile = document.querySelector('.light-icon-mobile');
            if (theme === 'dark') {
                moonIcon.style.display = 'block';
                sunIcon.style.display = 'none';
                moonIconMobile.style.display = 'block';
                sunIconMobile.style.display = 'none';
            } else {
                moonIcon.style.display = 'none';
                sunIcon.style.display = 'block';
                moonIconMobile.style.display = 'none';
                sunIconMobile.style.display = 'block';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
