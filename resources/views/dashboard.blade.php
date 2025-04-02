<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Welcome to the Dashboard</h2>
        
        <div class="control-panel-grid">
            <!-- Quick Stats -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Users</h3>
                <p class="control-panel-stat">{{ \App\Models\User::count() }}</p>
            </div>

            <!-- Recent Activity -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Recent Activity</h3>
                <p>No recent activity</p>
            </div>

            <!-- Quick Actions -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Quick Actions</h3>
                <div class="control-panel-actions">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('users.index') }}" class="control-panel-button">
                            Manage Users
                        </a>
                        <a href="{{ route('settings.index') }}" class="control-panel-button">
                            Settings
                        </a>
                    @elseif(Auth::user()->isEditor())
                        <a href="{{ route('settings.index') }}" class="control-panel-button">
                            Settings
                        </a>
                    @endif
                </div>
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
                        <div class="color-picker-wrapper">
                            <div class="color-preview" style="background-color: {{ $heroSettings->title_color ?? '#FFFFFF' }}">
                                <input type="color" name="title_color" id="title_color" 
                                       value="{{ $heroSettings->title_color ?? '#FFFFFF' }}"
                                       class="color-picker-input">
                            </div>
                            <div class="color-value">{{ $heroSettings->title_color ?? '#FFFFFF' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Title Size -->
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Title Size</h3>
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="title_size">Select the title size</label>
                        <select name="title_size" id="title_size" class="control-panel-input">
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
                        <select name="title_font" id="title_font" class="control-panel-input">
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