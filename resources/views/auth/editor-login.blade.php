@extends('layouts.editor-guest')

@section('content')
    <!-- Session Status -->
    @if (session('status'))
        <div class="control-panel-message-container">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="control-panel-auth-form">
        @csrf

        <!-- Email Address -->
        <div class="control-panel-form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="control-panel-error-container" />
        </div>

        <!-- Password -->
        <div class="control-panel-form-group">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="control-panel-error-container" />
        </div>

        <!-- Remember Me -->
        <div class="control-panel-checkbox-group">
            <label for="remember_me" class="control-panel-checkbox-label">
                <input id="remember_me" type="checkbox" class="control-panel-checkbox" name="remember">
                <span class="control-panel-checkbox-text">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="control-panel-form-actions">
            @if (Route::has('password.request'))
                <a class="control-panel-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
@endsection
