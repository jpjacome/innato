<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ session('theme', 'light') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Dynamic Control Panel Styles -->
        <link href="{{ route('control-panel.css') }}" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/js/app.js'])
    </head>
    <body class="control-panel-auth-body">
        <div class="control-panel-auth-container">
            <div class="control-panel-auth-logo-container">
                <a href="/" style="display: block;">
                    <x-interactive-icon size="150px" borderScale="0.05" class="control-panel-auth-logo" />
                </a>
            </div>

            <div class="control-panel-auth-form-container">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
