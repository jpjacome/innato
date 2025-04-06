<x-control-panel-layout>
    <div class="control-panel-card welcome-card">
        <h2 class="control-panel-title">Welcome, {{ Auth::user()->name }}</h2>
        
        <div class="control-panel-grid" id="control-panel-grid-1">
            <!-- Quick Stats -->
            <div class="control-panel-card stats-card user-stats-card">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-people-fill"></i>
                </h3>
                <p class="control-panel-stat">{{ \App\Models\User::count() }}</p>
            </div>
            
            @if(Auth::user()->isAdmin() || Auth::user()->isEditor())
            <div class="control-panel-card stats-card plants-stats-card">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-tree"></i>
                </h3>
                <p class="control-panel-stat">{{ \App\Models\Plant::count() }}</p>
            </div>
            @endif
        </div>
    </div>

    @if(Auth::user()->isAdmin() || Auth::user()->isEditor())
    <!-- Plant Management Module Card -->
    <div class="control-panel-card plants-management-card">
        <h2 class="control-panel-title">Plant Management</h2>
        
        <div class="control-panel-grid">
            <!-- Plants List -->
            <a href="{{ route('admin.plants.index') }}" class="control-panel-card" style="text-decoration: none; color: inherit; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-database-fill"></i>
                    Plants Database
                </h3>
                <p>Manage plant information, images, and maintenance records.</p>
            </a>
            
            <!-- Add New Plant -->
            <a href="{{ route('admin.plants.create') }}" class="control-panel-card" style="text-decoration: none; color: inherit; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-tree"></i>
                    Add New Plant
                </h3>
                <p>Create a new plant record with detailed information and images.</p>
            </a>
            
            <!-- Maintenance Logs -->
            <a href="{{ route('admin.maintenance.index') }}" class="control-panel-card" style="text-decoration: none; color: inherit; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-journal-check"></i>
                    Maintenance Logs
                </h3>
                <p>Track watering, fertilization, pruning, and other plant care activities.</p>
            </a>
        </div>
    </div>
    
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
                            <option value="Arial" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Arial' ? 'selected' : '' }}>Arial</option>
                            <option value="Helvetica" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Helvetica' ? 'selected' : '' }}>Helvetica</option>
                            <option value="Verdana" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Verdana' ? 'selected' : '' }}>Verdana</option>
                            <option value="Georgia" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Georgia' ? 'selected' : '' }}>Georgia</option>
                            <option value="Times New Roman" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Times New Roman' ? 'selected' : '' }}>Times New Roman</option>
                            <option value="Courier New" {{ ($heroSettings->title_font ?? 'Playfair Display') === 'Courier New' ? 'selected' : '' }}>Courier New</option>
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
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</x-control-panel-layout> 