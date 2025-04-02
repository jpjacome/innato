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
                    <h3 class="control-panel-subtitle">Primary Color</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="primary_color">Choose a primary color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="primary_color" id="primary_color" 
                                value="{{ $settings->primary_color ?? '#4F46E5' }}">
                            <span id="primary_color_value" class="text-white">{{ $settings->primary_color ?? '#4F46E5' }}</span>
                        </div>
                    </div>
                </div>

                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Secondary Color</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="secondary_color">Choose a secondary color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="secondary_color" id="secondary_color" 
                                value="{{ $settings->secondary_color ?? '#818CF8' }}">
                            <span id="secondary_color_value" class="text-white">{{ $settings->secondary_color ?? '#818CF8' }}</span>
                        </div>
                    </div>
                </div>

                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Accent Color</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="accent_color">Choose an accent color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="accent_color" id="accent_color" 
                                value="{{ $settings->accent_color ?? '#6366f1' }}">
                            <span id="accent_color_value" class="text-white">{{ $settings->accent_color ?? '#6366f1' }}</span>
                        </div>
                    </div>
                </div>

                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Dashboard Title</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="dashboard_title">Enter a title for your dashboard</label>
                        <input type="text" name="dashboard_title" id="dashboard_title" 
                               value="{{ $settings->dashboard_title ?? 'Dashboard' }}" 
                               class="control-panel-input">
                    </div>
                </div>

                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Logo</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="logo">Upload a logo</label>
                        <input type="file" name="logo" id="logo" accept="image/*" class="control-panel-input">
                        @if($settings->logo)
                            <div class="mt-4">
                                <img src="{{ Storage::url($settings->logo) }}" alt="Current Logo" class="control-panel-logo-image">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="control-panel-actions" style="margin-top: 1rem;">
                <button type="submit" class="control-panel-button">Save Changes</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorInputs = document.querySelectorAll('input[type="color"]');
            
            colorInputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Update the text value
                    const valueElement = document.getElementById(this.id + '_value');
                    if (valueElement) {
                        valueElement.textContent = this.value;
                    }
                });
            });
        });
    </script>
</x-control-panel-layout> 