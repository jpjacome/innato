<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ session('theme', 'light') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Editor Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- General Styles -->
        <link rel="stylesheet" href="{{ asset('css/general.css') }}">
        
        <!-- Dynamic Control Panel Styles -->
        <link href="{{ route('control-panel.css') }}" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/js/app.js'])

        <style>
            /* Custom editor login styles using general.css colors */
            body {
                background: linear-gradient(to bottom, var(--color-1) 50%, var(--color-3) 50%);
                background-color: var(--color-1);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Franie', sans-serif;
            }

            .editor-login-container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 3rem;
            }

            .editor-logo-container {
                text-align: center;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 2rem;
            }

            .editor-logo-container img {
                width: 300px;
                max-width: 80vw;
                height: auto;
                filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            }

            .editor-form-container {
                background: var(--color-1);
                border: 1px solid var(--color-black);
                border-radius: 0;
                padding: 2.5rem;
                width: 100%;
                max-width: 450px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .editor-form-container .control-panel-form-group {
                margin-bottom: 1.5rem;
            }

            .editor-form-container .control-panel-form-group label {
                font-family: 'Franie Semibold', sans-serif;
                color: var(--color-black);
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
                display: block;
            }

            .editor-form-container input[type="email"],
            .editor-form-container input[type="password"] {
                width: 100%;
                padding: 0.8rem 1rem;
                border: 1px solid var(--color-black);
                background: transparent;
                font-family: 'Noto Serif', serif;
                font-size: 1rem;
                color: var(--color-black);
                transition: border-color 0.2s, box-shadow 0.2s;
            }

            .editor-form-container input[type="email"]:focus,
            .editor-form-container input[type="password"]:focus {
                outline: none;
                border-color: var(--color-4);
                box-shadow: 0 0 0 2px rgba(237, 89, 52, 0.1);
            }

            .editor-form-container .control-panel-checkbox-group {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin: 1.5rem 0;
            }

            .editor-form-container .control-panel-checkbox-group label {
                font-family: 'Noto Serif', serif;
                font-size: 0.9rem;
                color: var(--color-black);
                cursor: pointer;
            }

            .editor-form-container .control-panel-checkbox {
                accent-color: var(--color-4);
            }

            .editor-form-container .control-panel-form-actions {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                margin-top: 2rem;
            }

            .editor-form-container .control-panel-link {
                color: var(--color-5);
                text-decoration: none;
                font-family: 'Noto Serif', serif;
                font-size: 0.9rem;
                text-align: center;
                transition: color 0.2s;
            }

            .editor-form-container .control-panel-link:hover {
                color: var(--color-4);
                text-decoration: underline;
            }

            .editor-form-container button {
                background-color: var(--color-4);
                color: white;
                border: none;
                padding: 1rem 2rem;
                font-family: 'Franie Semibold', sans-serif;
                font-size: 1rem;
                cursor: pointer;
                transition: background-color 0.3s ease;
                width: 100%;
            }

            .editor-form-container button:hover {
                background-color: var(--color-5);
            }

            .control-panel-message-container {
                background-color: var(--color-2);
                color: var(--color-black);
                padding: 1rem;
                border-radius: 0;
                margin-bottom: 1.5rem;
                font-family: 'Franie Semibold', sans-serif;
                font-size: 0.9rem;
                border: 1px solid var(--color-black);
            }

            .control-panel-error-container {
                color: var(--color-4);
                font-family: 'Noto Serif', serif;
                font-size: 0.85rem;
                margin-top: 0.25rem;
            }

            @media (max-width: 768px) {
                .editor-login-container {
                    padding: 1rem;
                    gap: 2rem;
                }

                .editor-logo-container {
                    padding: 1.5rem;
                }

                .editor-logo-container img {
                    width: 250px;
                }

                .editor-form-container {
                    padding: 2rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="editor-login-container">
            <div class="editor-logo-container">
                <a href="/">
                    <img src="{{ asset('assets/imgs/logo.svg') }}" alt="Innato Logo" />
                </a>
            </div>

            <div class="editor-form-container">
                @yield('content')
            </div>
        </div>
    </body>
</html>
