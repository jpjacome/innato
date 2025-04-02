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
                        <div class="color-picker-wrapper">
                            <div class="color-preview" style="background-color: {{ $settings->primary_color ?? '#4F46E5' }}">
                                <input type="color" name="primary_color" id="primary_color" 
                                    value="{{ $settings->primary_color ?? '#4F46E5' }}"
                                    class="color-picker-input">
                            </div>
                            <div class="color-value">{{ $settings->primary_color ?? '#4F46E5' }}</div>
                        </div>
                    </div>
                </div>

                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Secondary Color</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="secondary_color">Choose a secondary color</label>
                        <div class="color-picker-wrapper">
                            <div class="color-preview" style="background-color: {{ $settings->secondary_color ?? '#818CF8' }}">
                                <input type="color" name="secondary_color" id="secondary_color" 
                                    value="{{ $settings->secondary_color ?? '#818CF8' }}"
                                    class="color-picker-input">
                            </div>
                            <div class="color-value">{{ $settings->secondary_color ?? '#818CF8' }}</div>
                        </div>
                    </div>
                </div>

                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Accent Color</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="accent_color">Choose an accent color</label>
                        <div class="color-picker-wrapper">
                            <div class="color-preview" style="background-color: {{ $settings->accent_color ?? '#6366f1' }}">
                                <input type="color" name="accent_color" id="accent_color" 
                                    value="{{ $settings->accent_color ?? '#6366f1' }}"
                                    class="color-picker-input">
                            </div>
                            <div class="color-value">{{ $settings->accent_color ?? '#6366f1' }}</div>
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
            const colorInputs = document.querySelectorAll('.color-picker-input');
            
            colorInputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Update the preview (which is the parent)
                    this.parentElement.style.backgroundColor = this.value;
                    
                    // Update the text value
                    const valueDisplay = this.parentElement.parentElement.querySelector('.color-value');
                    valueDisplay.textContent = this.value;
                });
            });
        });
    </script>
</x-control-panel-layout> 