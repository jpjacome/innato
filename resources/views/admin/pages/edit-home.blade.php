<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Edit Homepage</h2>
        </div>
        
        <p class="control-panel-text-muted">Edit the content and settings for your homepage sections.</p>

        @if(session('success'))
            <div class="alert alert-success control-panel-alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error control-panel-alert-error-custom">
                <ul class="control-panel-alert-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="home-edit-form" method="POST" action="{{ route('admin.pages.update-home') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            @method('PUT')

            <!-- Hero Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-play-circle"></i> Hero Section
                </h3>
                <p>Customize the main hero section of your homepage.</p>
                
                <div class="control-panel-form-grid">
                    <div>
                        <label for="hero_title" class="control-panel-label">Hero Title</label>
                        <input 
                            type="text" 
                            id="hero_title" 
                            name="hero_title" 
                            value="{{ old('hero_title', $homeSetting->hero_title) }}"
                            class="control-panel-input"
                            placeholder="Enter hero section title"
                        >
                    </div>
                    
                    <div>
                        <label for="hero_button_text" class="control-panel-label">Hero Button Text</label>
                        <input 
                            type="text" 
                            id="hero_button_text" 
                            name="hero_button_text" 
                            value="{{ old('hero_button_text', $homeSetting->hero_button_text) }}"
                            class="control-panel-input"
                            placeholder="Enter button text"
                        >
                    </div>
                    
                    <div>
                        <label for="hero_video" class="control-panel-label">Hero Video</label>
                        <input 
                            type="file" 
                            id="hero_video" 
                            name="hero_video" 
                            class="control-panel-input"
                            accept="video/*"
                        >
                        <small class="control-panel-small-text">Current: {{ $homeSetting->hero_video_path ? basename($homeSetting->hero_video_path) : 'vid1.mp4 (default)' }}</small>
                    </div>
                </div>
            </div>

            <!-- Headline Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-heading"></i> Headline Section
                </h3>
                <p>Customize the main headline section below the hero.</p>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="headline_title" class="control-panel-label">Headline Title</label>
                        <input 
                            type="text" 
                            id="headline_title" 
                            name="headline_title" 
                            value="{{ old('headline_title', $homeSetting->headline_title) }}"
                            class="control-panel-input"
                            placeholder="Enter headline title"
                        >
                    </div>
                    <div>
                        <label for="headline_description" class="control-panel-label">Headline Description</label>
                        <textarea 
                            id="headline_description" 
                            name="headline_description" 
                            class="control-panel-input"
                            rows="3"
                            placeholder="Enter headline description"
                        >{{ old('headline_description', $homeSetting->headline_description) }}</textarea>
                    </div>
                </div>
                <div class="control-panel-form-grid" style="margin-top: 1.5rem;">
                    <div>
                        <label for="headline_coast_image" class="control-panel-label">Coast Image</label>
                        <input type="file" id="headline_coast_image" name="headline_coast_image" class="control-panel-input" accept="image/*">
                        <small class="control-panel-small-text">Current: {{ $homeSetting->headline_coast_image ? basename($homeSetting->headline_coast_image) : 'Default Unsplash' }}</small>
                    </div>
                    <div>
                        <label for="headline_andes_image" class="control-panel-label">Andes Image</label>
                        <input type="file" id="headline_andes_image" name="headline_andes_image" class="control-panel-input" accept="image/*">
                        <small class="control-panel-small-text">Current: {{ $homeSetting->headline_andes_image ? basename($homeSetting->headline_andes_image) : 'Default Unsplash' }}</small>
                    </div>
                    <div>
                        <label for="headline_amazon_image" class="control-panel-label">Amazon Image</label>
                        <input type="file" id="headline_amazon_image" name="headline_amazon_image" class="control-panel-input" accept="image/*">
                        <small class="control-panel-small-text">Current: {{ $homeSetting->headline_amazon_image ? basename($homeSetting->headline_amazon_image) : 'Default Unsplash' }}</small>
                    </div>
                </div>
            </div>

            <!-- Destinations Section -->
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-map-marked-alt"></i> Destinations Section
                </h3>
                <p>Customize the explore destinations section.</p>
                
                <div class="control-panel-form-grid">
                    <div>
                        <label for="destinations_title" class="control-panel-label">Destinations Title</label>
                        <input 
                            type="text" 
                            id="destinations_title" 
                            name="destinations_title" 
                            value="{{ old('destinations_title', $homeSetting->destinations_title) }}"
                            class="control-panel-input"
                            placeholder="Enter destinations section title"
                        >
                    </div>
                    
                    <div>
                        <label for="destinations_description" class="control-panel-label">Destinations Description</label>
                        <textarea 
                            id="destinations_description" 
                            name="destinations_description" 
                            class="control-panel-input"
                            rows="2"
                            placeholder="Enter destinations description"
                        >{{ old('destinations_description', $homeSetting->destinations_description) }}</textarea>
                    </div>
                    
                    <div>
                        <label for="destinations_button_text" class="control-panel-label">Destinations Button Text</label>
                        <input 
                            type="text" 
                            id="destinations_button_text" 
                            name="destinations_button_text" 
                            value="{{ old('destinations_button_text', $homeSetting->destinations_button_text) }}"
                            class="control-panel-input"
                            placeholder="Enter button text"
                        >
                    </div>
                    <div>
                        <label for="destinations_footer_text" class="control-panel-label">Destinations Footer Text</label>
                        <input 
                            type="text" 
                            id="destinations_footer_text" 
                            name="destinations_footer_text" 
                            value="{{ old('destinations_footer_text', $homeSetting->destinations_footer_text) }}"
                            class="control-panel-input"
                            placeholder="Enter footer text (e.g. Haz clic en una región para observarla más de cerca.)"
                        >
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Fixed Action Buttons -->
    <div class="control-panel-fixed-actions">
        <a href="{{ route('admin.pages') }}" class="control-panel-button">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" form="home-edit-form" class="control-panel-button">
            <i class="fas fa-save"></i> Save Changes
        </button>
        <a href="/home" target="_blank" class="control-panel-button">
            <i class="fas fa-external-link-alt"></i> View Homepage
        </a>
    </div>
</x-control-panel-layout>
