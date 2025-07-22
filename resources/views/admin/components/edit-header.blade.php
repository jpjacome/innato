<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Edit Header Component</h2>
        </div>
        <p class="control-panel-text-muted">Edit the content and settings for your site's header.</p>

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

        <form id="header-edit-form" method="POST" action="{{ route('admin.components.update-header') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            @method('PUT')

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-image"></i> Logo
                </h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="header_logo" class="control-panel-label">Logo Image</label>
                        <div style="margin-bottom: 10px;">
                            <strong>Current:</strong> {{ asset('assets/imgs/logo.svg') }}
                        </div>
                        <img src="{{ asset('assets/imgs/logo.svg') }}" alt="Current Logo" style="max-width:120px; margin-bottom: 10px;">
                        <input type="file" id="header_logo" name="header_logo" class="control-panel-input" accept="image/*">
                        <small class="control-panel-text-muted">Upload a new logo to replace the current one</small>
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-bars"></i> Navigation Menu
                </h3>
                <p class="control-panel-text-muted">Current navigation items in your header:</p>
                
                <div class="control-panel-form-grid">
                    <div>
                        <label class="control-panel-label">About Us</label>
                        <input type="text" name="nav_about_text" class="control-panel-input" value="{{ old('nav_about_text', $headerSetting->nav_about_text ?? 'About Us') }}" placeholder="About Us">
                        <small class="control-panel-text-muted">Link: /about | Icon: ph-users-three</small>
                    </div>
                    <div>
                        <label class="control-panel-label">Destinations</label>
                        <input type="text" name="nav_destinations_text" class="control-panel-input" value="{{ old('nav_destinations_text', $headerSetting->nav_destinations_text ?? 'Destinations') }}" placeholder="Destinations">
                        <small class="control-panel-text-muted">Link: /destinations | Icon: ph-path</small>
                    </div>
                    <div>
                        <label class="control-panel-label">Tourist Experience Center</label>
                        <input type="text" name="nav_experience_text" class="control-panel-input" value="{{ old('nav_experience_text', $headerSetting->nav_experience_text ?? 'Tourist Experience Center') }}" placeholder="Tourist Experience Center">
                        <small class="control-panel-text-muted">Link: /experience-center | Icon: ph-buildings</small>
                    </div>
                    <div>
                        <label class="control-panel-label">Hostal</label>
                        <input type="text" name="nav_hostal_text" class="control-panel-input" value="{{ old('nav_hostal_text', $headerSetting->nav_hostal_text ?? 'Hostal') }}" placeholder="Hostal">
                        <small class="control-panel-text-muted">Link: /hostal | Icon: ph-house-simple</small>
                    </div>
                    <div>
                        <label class="control-panel-label">Contact</label>
                        <input type="text" name="nav_contact_text" class="control-panel-input" value="{{ old('nav_contact_text', $headerSetting->nav_contact_text ?? 'Contact') }}" placeholder="Contact">
                        <small class="control-panel-text-muted">Link: /contact | Icon: ph-envelope-simple</small>
                    </div>
                    <div>
                        <label class="control-panel-label">Reviews</label>
                        <input type="text" name="nav_reviews_text" class="control-panel-input" value="{{ old('nav_reviews_text', $headerSetting->nav_reviews_text ?? 'Reviews') }}" placeholder="Reviews">
                        <small class="control-panel-text-muted">Link: /reviews | Icon: ph-star</small>
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-search"></i> Search & Mobile Menu
                </h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="search_placeholder" class="control-panel-label">Search Placeholder Text</label>
                        <input type="text" id="search_placeholder" name="search_placeholder" class="control-panel-input" value="{{ old('search_placeholder', $headerSetting->search_placeholder ?? 'Search...') }}" placeholder="Search...">
                    </div>
                    <div>
                        <label class="control-panel-label">Features</label>
                        <div style="margin-top: 10px;">
                            <div style="margin-bottom: 5px;">✓ Search toggle (magnifying glass icon)</div>
                            <div style="margin-bottom: 5px;">✓ Hamburger menu for mobile</div>
                            <div style="margin-bottom: 5px;">✓ Mobile menu with same navigation items</div>
                        </div>
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
        <button type="submit" form="header-edit-form" class="control-panel-button">
            <i class="fas fa-save"></i> Save Changes
        </button>
        <a href="/" target="_blank" class="control-panel-button">
            <i class="fas fa-external-link-alt"></i> View Site
        </a>
    </div>
</x-control-panel-layout>
