@php
use Illuminate\Support\Facades\Storage;
@endphp
<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Dashboard Settings</h2>
        
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="control-panel-form">
            @csrf
            @method('PUT')
            
            <div class="control-panel-grid">
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Light Theme Colors</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="primary_color">Primary Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="primary_color" id="primary_color" 
                                value="{{ isset($settings) && $settings && isset($settings->primary_color) ? $settings->primary_color : '#4F46E5' }}">
                            <span id="primary_color_value" class="text-white">{{ isset($settings) && $settings && isset($settings->primary_color) ? $settings->primary_color : '#4F46E5' }}</span>
                        </div>
                    </div>

                    <div class="control-panel-form-group mt-4">
                        <label class="control-panel-label" for="secondary_color">Secondary Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="secondary_color" id="secondary_color" 
                                value="{{ isset($settings) && $settings && isset($settings->secondary_color) ? $settings->secondary_color : '#818CF8' }}">
                            <span id="secondary_color_value" class="text-white">{{ isset($settings) && $settings && isset($settings->secondary_color) ? $settings->secondary_color : '#818CF8' }}</span>
                        </div>
                    </div>

                    <div class="control-panel-form-group mt-4">
                        <label class="control-panel-label" for="accent_color">Accent Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="accent_color" id="accent_color" 
                                value="{{ isset($settings) && $settings && isset($settings->accent_color) ? $settings->accent_color : '#6366f1' }}">
                            <span id="accent_color_value" class="text-white">{{ isset($settings) && $settings && isset($settings->accent_color) ? $settings->accent_color : '#6366f1' }}</span>
                        </div>
                    </div>

                    <div class="control-panel-form-group mt-4">
                        <label class="control-panel-label" for="text_color">Text Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="text_color" id="text_color" 
                                value="{{ isset($settings) && $settings && isset($settings->text_color) ? $settings->text_color : '#ffffff' }}">
                            <span id="text_color_value" class="text-white">{{ isset($settings) && $settings && isset($settings->text_color) ? $settings->text_color : '#ffffff' }}</span>
                        </div>
                    </div>
                </div>

                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Dark Theme Colors</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="dark_primary_color">Primary Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="dark_primary_color" id="dark_primary_color" 
                                value="{{ isset($settings) && $settings && isset($settings->dark_primary_color) ? $settings->dark_primary_color : '#6366f1' }}">
                            <span id="dark_primary_color_value" class="text-white">{{ isset($settings) && $settings && isset($settings->dark_primary_color) ? $settings->dark_primary_color : '#6366f1' }}</span>
                        </div>
                    </div>

                    <div class="control-panel-form-group mt-4">
                        <label class="control-panel-label" for="dark_secondary_color">Secondary Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="dark_secondary_color" id="dark_secondary_color" 
                                value="{{ isset($settings) && $settings && isset($settings->dark_secondary_color) ? $settings->dark_secondary_color : '#818CF8' }}">
                            <span id="dark_secondary_color_value" class="text-white">{{ isset($settings) && $settings && isset($settings->dark_secondary_color) ? $settings->dark_secondary_color : '#818CF8' }}</span>
                        </div>
                    </div>

                    <div class="control-panel-form-group mt-4">
                        <label class="control-panel-label" for="dark_accent_color">Accent Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="dark_accent_color" id="dark_accent_color" 
                                value="{{ isset($settings) && $settings && isset($settings->dark_accent_color) ? $settings->dark_accent_color : '#4F46E5' }}">
                            <span id="dark_accent_color_value" class="text-white">{{ isset($settings) && $settings && isset($settings->dark_accent_color) ? $settings->dark_accent_color : '#4F46E5' }}</span>
                        </div>
                    </div>

                    <div class="control-panel-form-group mt-4">
                        <label class="control-panel-label" for="dark_text_color">Text Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="dark_text_color" id="dark_text_color" 
                                value="{{ isset($settings) && $settings && isset($settings->dark_text_color) ? $settings->dark_text_color : '#ffffff' }}">
                            <span id="dark_text_color_value" class="text-white">{{ isset($settings) && $settings && isset($settings->dark_text_color) ? $settings->dark_text_color : '#ffffff' }}</span>
                        </div>
                    </div>
                </div>

                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Dashboard Title</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="dashboard_title">Enter a title for your dashboard</label>
                        <input type="text" name="dashboard_title" id="dashboard_title" 
                               value="{{ isset($settings) && $settings && isset($settings->dashboard_title) ? $settings->dashboard_title : 'Dashboard' }}" 
                               class="control-panel-input">
                    </div>
                </div>

                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Logo</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="logo">Upload a logo</label>
                        <input type="file" name="logo" id="logo" accept="image/*" class="control-panel-input">
                        @if(isset($settings) && $settings && isset($settings->logo) && $settings->logo)
                            <div class="mt-4">
                                <img src="{{ Storage::url($settings->logo) }}" alt="Current Logo" class="control-panel-logo-image">
                            </div>
                        @endif
                        
                        <div class="mt-4">
                            <label class="control-panel-label inline-flex items-center">
                                <input type="checkbox" name="show_logo" id="show_logo" 
                                       class="mr-2" {{ isset($settings) && $settings && isset($settings->show_logo) && $settings->show_logo ? 'checked' : '' }}>
                                <span>Display logo in header</span>
                            </label>
                            <p class="text-white opacity-75 text-sm mt-1">When disabled, only the site name text will be shown.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="control-panel-actions" style="margin-top: 1rem;">
                <button type="submit" class="control-panel-button">Save Changes</button>
            </div>
        </form>
    </div>
    
    <!-- Developer Tools Section -->
    @if(Auth::user()->isAdmin())
    <div class="control-panel-card mt-8">
        <h2 class="control-panel-title">Developer Tools</h2>
        <div class="control-panel-grid">
            <!-- Telescope Card -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Telescope</h3>
                <p class="text-white mb-4">Monitor application requests, exceptions, database queries, and more.</p>
                <a href="{{ route('admin.telescope') }}" class="control-panel-button" target="_blank">Open Telescope</a>
            </div>
            
            <!-- Pulse Card -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Pulse</h3>
                <p class="text-white mb-4">Real-time application metrics and performance monitoring.</p>
                <a href="{{ route('admin.pulse') }}" class="control-panel-button" target="_blank">Open Pulse</a>
            </div>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorInputs = [
                'primary_color',
                'secondary_color',
                'accent_color',
                'dark_primary_color',
                'dark_secondary_color',
                'dark_accent_color',
                'text_color',
                'dark_text_color'
            ];

            colorInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                const valueSpan = document.getElementById(`${inputId}_value`);

                if (input && valueSpan) {
                    input.addEventListener('input', function() {
                        valueSpan.textContent = this.value;
                    });
                }
            });
        });
    </script>
</x-control-panel-layout> 