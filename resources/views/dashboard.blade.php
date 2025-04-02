<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Welcome to the Dashboard</h2>
        
        <div class="control-panel-grid" id="control-panel-grid-1">
            <!-- Quick Stats -->
            <div class="control-panel-card user-stats-card">
                <h3 class="control-panel-subtitle">Users</h3>
                <p class="control-panel-stat">{{ \App\Models\User::count() }}</p>
            </div>
        </div>
    </div>

    @if(Auth::user()->isAdmin() || Auth::user()->isEditor())
    <div class="control-panel-card">
        <h2 class="control-panel-title">Homepage Hero Settings</h2>
        
        <form action="{{ route('hero-settings.update') }}" method="POST" class="control-panel-form">
            @csrf
            @method('PUT')
            
            <div class="control-panel-grid">
                <!-- Title Text -->
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Title Text</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="title_text">Enter text for the homepage title</label>
                        <input type="text" name="title_text" id="title_text" 
                               value="{{ $heroSettings->title_text ?? 'WELCOME' }}" 
                               class="control-panel-input">
                    </div>
                </div>

                <!-- Title Color -->
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Title Color</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="title_color">Choose the title color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="title_color" id="title_color" 
                                   value="{{ $heroSettings->title_color ?? '#FFFFFF' }}">
                            <span id="title_color_value" class="text-white">{{ $heroSettings->title_color ?? '#FFFFFF' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Background Color -->
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Background Color</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="background_color">Choose the background color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="background_color" id="background_color" 
                                   value="{{ $heroSettings->background_color ?? '#6366f1' }}">
                            <span id="background_color_value" class="text-white">{{ $heroSettings->background_color ?? '#6366f1' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Title Size -->
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Title Size</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="title_size">Select the title size</label>
                        <select name="title_size" id="title_size" class="control-panel-select">
                            <option value="2rem" {{ ($heroSettings->title_size ?? '4rem') == '2rem' ? 'selected' : '' }}>Small</option>
                            <option value="3rem" {{ ($heroSettings->title_size ?? '4rem') == '3rem' ? 'selected' : '' }}>Medium</option>
                            <option value="4rem" {{ ($heroSettings->title_size ?? '4rem') == '4rem' ? 'selected' : '' }}>Large</option>
                            <option value="5rem" {{ ($heroSettings->title_size ?? '4rem') == '5rem' ? 'selected' : '' }}>Extra Large</option>
                        </select>
                    </div>
                </div>

                <!-- Title Font -->
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Title Font</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="title_font">Select the title font</label>
                        <select name="title_font" id="title_font" class="control-panel-select">
                            <option value="Playfair Display" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Playfair Display' ? 'selected' : '' }}>Playfair Display</option>
                            <option value="Montserrat" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                            <option value="Righteous" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Righteous' ? 'selected' : '' }}>Righteous</option>
                            <option value="Pacifico" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Pacifico' ? 'selected' : '' }}>Pacifico</option>
                            <option value="Orbitron" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Orbitron' ? 'selected' : '' }}>Orbitron</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="control-panel-actions" style="margin-top: 1rem;">
                <button type="submit" class="control-panel-button">Save Hero Settings</button>
            </div>
        </form>
    </div>
    @endif

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