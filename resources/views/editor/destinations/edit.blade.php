@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-editor-layout>
    <div class="control-panel-card">
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h2 class="control-panel-title">
                        <i class="ph ph-pencil-simple"></i>
                        Edit Destination: {{ $destination->title }}
                    </h2>
                    <p class="control-panel-subtitle">Manage all content for this destination</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('editor.destinations.index') }}" class="control-panel-button control-panel-button-secondary">
                        <i class="ph ph-arrow-left"></i> Back to Destinations
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="ph ph-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="ph ph-warning"></i>
                Please fix the following errors:
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-button active" data-tab="basic">
                <i class="ph ph-info"></i>
                Basic Info
            </button>
            <button class="tab-button" data-tab="location">
                <i class="ph ph-map-pin"></i>
                Location
            </button>
            <button class="tab-button" data-tab="climate">
                <i class="ph ph-sun"></i>
                Climate
            </button>
            <button class="tab-button" data-tab="access">
                <i class="ph ph-road-horizon"></i>
                Access
            </button>
            <button class="tab-button" data-tab="schedule">
                <i class="ph ph-clock"></i>
                Schedule
            </button>
            <button class="tab-button" data-tab="contact">
                <i class="ph ph-phone"></i>
                Contact
            </button>
            <button class="tab-button" data-tab="activities">
                <i class="ph ph-activity"></i>
                Activities
            </button>
            <button class="tab-button" data-tab="audience">
                <i class="ph ph-users"></i>
                Audience
            </button>
            <button class="tab-button" data-tab="services">
                <i class="ph ph-gear"></i>
                Services
            </button>
            <button class="tab-button" data-tab="pricing">
                <i class="ph ph-currency-dollar"></i>
                Pricing
            </button>
            <button class="tab-button" data-tab="criteria">
                <i class="ph ph-medal"></i>
                Criteria
            </button>
            <button class="tab-button" data-tab="description">
                <i class="ph ph-file-text"></i>
                Description
            </button>
            <button class="tab-button" data-tab="challenges">
                <i class="ph ph-warning"></i>
                Challenges
            </button>
            <button class="tab-button" data-tab="gallery">
                <i class="ph ph-images"></i>
                Fotos
            </button>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('editor.destinations.update', $destination) }}" id="destination-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Info Tab -->
            <div class="tab-content active" id="basic-tab">
                <h3 class="tab-title">Basic Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="title">Destination Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $destination->title) }}" required>
                        @error('title')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="subtitle">Subtitle/Category</label>
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $destination->subtitle) }}">
                        @error('subtitle')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="coordinates">GPS Coordinates</label>
                        <input type="text" id="coordinates" name="coordinates" value="{{ old('coordinates', $destination->coordinates) }}">
                        <small class="form-help">Format: S 1°52'56" W 80°44'03" - 0 M.S.N.M</small>
                        @error('coordinates')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="conservation_status">Conservation Status</label>
                        <input type="text" id="conservation_status" name="conservation_status" value="{{ old('conservation_status', $destination->conservation_status) }}">
                        @error('conservation_status')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Location Tab -->
            <div class="tab-content" id="location-tab">
                <h3 class="tab-title">Location Details</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="province">Province</label>
                        <input type="text" id="province" name="province" value="{{ old('province', $destination->province) }}">
                        @error('province')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="canton">Canton</label>
                        <input type="text" id="canton" name="canton" value="{{ old('canton', $destination->canton) }}">
                        @error('canton')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="parish">Parish</label>
                        <input type="text" id="parish" name="parish" value="{{ old('parish', $destination->parish) }}">
                        @error('parish')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="sector">Sector</label>
                        <input type="text" id="sector" name="sector" value="{{ old('sector', $destination->sector) }}">
                        @error('sector')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group span-full">
                        <label for="reference_distance">Reference Distance</label>
                        <input type="text" id="reference_distance" name="reference_distance" value="{{ old('reference_distance', $destination->reference_distance) }}">
                        <small class="form-help">Example: 49.9 KM del GAD de Santa Elena</small>
                        @error('reference_distance')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Climate Tab -->
            <div class="tab-content" id="climate-tab">
                <h3 class="tab-title">Climate Information</h3>
                <div class="climate-seasons">
                    <!-- Dry Season -->
                    <div class="season-group">
                        <h4><i class="ph ph-sun"></i> Dry Season</h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="dry_season_name">Season Name</label>
                                <input type="text" id="dry_season_name" name="climate_dry_season[name]" value="{{ old('climate_dry_season.name', $destination->climate_dry_season['name'] ?? 'Época Seca') }}">
                            </div>
                            <div class="form-group">
                                <label for="dry_season_months">Months</label>
                                <input type="text" id="dry_season_months" name="climate_dry_season[months]" value="{{ old('climate_dry_season.months', $destination->climate_dry_season['months'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="dry_season_temperature">Temperature</label>
                                <input type="text" id="dry_season_temperature" name="climate_dry_season[temperature]" value="{{ old('climate_dry_season.temperature', $destination->climate_dry_season['temperature'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Wet Season -->
                    <div class="season-group">
                        <h4><i class="ph ph-cloud-rain"></i> Wet Season</h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="wet_season_name">Season Name</label>
                                <input type="text" id="wet_season_name" name="climate_wet_season[name]" value="{{ old('climate_wet_season.name', $destination->climate_wet_season['name'] ?? 'Época Húmeda') }}">
                            </div>
                            <div class="form-group">
                                <label for="wet_season_months">Months</label>
                                <input type="text" id="wet_season_months" name="climate_wet_season[months]" value="{{ old('climate_wet_season.months', $destination->climate_wet_season['months'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="wet_season_temperature">Temperature</label>
                                <input type="text" id="wet_season_temperature" name="climate_wet_season[temperature]" value="{{ old('climate_wet_season.temperature', $destination->climate_wet_season['temperature'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Access Tab -->
            <div class="tab-content" id="access-tab">
                <h3 class="tab-title">Access & Transportation</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="access_from">Access From</label>
                        <input type="text" id="access_from" name="access_from" value="{{ old('access_from', $destination->access_from) }}">
                        @error('access_from')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="access_route">Route Description</label>
                        <input type="text" id="access_route" name="access_route" value="{{ old('access_route', $destination->access_route) }}">
                        @error('access_route')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="access_transport">Transport Options</label>
                        <input type="text" id="access_transport" name="access_transport" value="{{ old('access_transport', $destination->access_transport) }}">
                        @error('access_transport')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="access_time">Travel Time</label>
                        <input type="text" id="access_time" name="access_time" value="{{ old('access_time', $destination->access_time) }}">
                        @error('access_time')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Schedule Tab -->
            <div class="tab-content" id="schedule-tab">
                <h3 class="tab-title">Schedule & Entry</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="schedule_hours">Operating Hours</label>
                        <input type="text" id="schedule_hours" name="schedule_hours" value="{{ old('schedule_hours', $destination->schedule_hours) }}">
                        @error('schedule_hours')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="entry_fee">Entry Fee</label>
                        <input type="text" id="entry_fee" name="entry_fee" value="{{ old('entry_fee', $destination->entry_fee) }}">
                        @error('entry_fee')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="season_availability">Season Availability</label>
                        <input type="text" id="season_availability" name="season_availability" value="{{ old('season_availability', $destination->season_availability) }}">
                        @error('season_availability')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="requirements">Entry Requirements</label>
                        <input type="text" id="requirements" name="requirements" value="{{ old('requirements', $destination->requirements) }}">
                        @error('requirements')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Tab -->
            <div class="tab-content" id="contact-tab">
                <h3 class="tab-title">Contact Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="contact_person">Contact Person</label>
                        <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person', $destination->contact_person) }}">
                        @error('contact_person')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_role">Role/Position</label>
                        <input type="text" id="contact_role" name="contact_role" value="{{ old('contact_role', $destination->contact_role) }}">
                        @error('contact_role')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_phone">Phone Number</label>
                        <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $destination->contact_phone) }}">
                        @error('contact_phone')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_email">Email Address</label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $destination->contact_email) }}">
                        @error('contact_email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Activities Tab -->
            <div class="tab-content" id="activities-tab">
                <h3 class="tab-title">Tourist Activities</h3>
                <div class="dynamic-list" id="activities-list">
                    <div class="list-header">
                        <h4>Activities List</h4>
                        <button type="button" class="control-panel-button add-item-btn" data-list="activities">
                            <i class="ph ph-plus"></i> Add Activity
                        </button>
                    </div>
                    <div class="items-container">
                        @if($destination->activities)
                            @foreach($destination->activities as $index => $activity)
                                <div class="dynamic-item">
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label>Activity Icon</label>
                                            <input type="text" name="activities[{{ $index }}][icon]" value="{{ $activity['icon'] ?? 'ph ph-activity' }}" placeholder="ph ph-activity">
                                        </div>
                                        <div class="form-group">
                                            <label>Activity Name</label>
                                            <input type="text" name="activities[{{ $index }}][name]" value="{{ $activity['name'] ?? $activity }}" required>
                                        </div>
                                    </div>
                                    <button type="button" class="remove-item-btn">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Audience Tab -->
            <div class="tab-content" id="audience-tab">
                <h3 class="tab-title">Target Audience</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="target_audience_type">Audience Type</label>
                        <input type="text" id="target_audience_type" name="target_audience_type" value="{{ old('target_audience_type', $destination->target_audience_type) }}">
                        @error('target_audience_type')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="target_audience_origin">Origin</label>
                        <input type="text" id="target_audience_origin" name="target_audience_origin" value="{{ old('target_audience_origin', $destination->target_audience_origin) }}">
                        @error('target_audience_origin')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="target_audience_age">Age Range</label>
                        <input type="text" id="target_audience_age" name="target_audience_age" value="{{ old('target_audience_age', $destination->target_audience_age) }}">
                        @error('target_audience_age')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="target_audience_transport">Preferred Transport</label>
                        <input type="text" id="target_audience_transport" name="target_audience_transport" value="{{ old('target_audience_transport', $destination->target_audience_transport) }}">
                        @error('target_audience_transport')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="target_audience_stay">Typical Stay Duration</label>
                        <input type="text" id="target_audience_stay" name="target_audience_stay" value="{{ old('target_audience_stay', $destination->target_audience_stay) }}">
                        @error('target_audience_stay')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Services Tab -->
            <div class="tab-content" id="services-tab">
                <h3 class="tab-title">Services & Facilities</h3>
                <div class="dynamic-list" id="services-list">
                    <div class="list-header">
                        <h4>Available Services</h4>
                        <button type="button" class="control-panel-button add-item-btn" data-list="services">
                            <i class="ph ph-plus"></i> Add Service
                        </button>
                    </div>
                    <div class="items-container">
                        @if($destination->services)
                            @foreach($destination->services as $index => $service)
                                <div class="dynamic-item">
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label>Service Icon</label>
                                            <input type="text" name="services[{{ $index }}][icon]" value="{{ $service['icon'] ?? 'ph ph-gear' }}" placeholder="ph ph-gear">
                                        </div>
                                        <div class="form-group">
                                            <label>Service Name</label>
                                            <input type="text" name="services[{{ $index }}][name]" value="{{ $service['name'] ?? $service }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Available</label>
                                            <select name="services[{{ $index }}][available]">
                                                <option value="1" {{ ($service['available'] ?? true) ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ !($service['available'] ?? true) ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="remove-item-btn">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pricing Tab -->
            <div class="tab-content" id="pricing-tab">
                <h3 class="tab-title">Pricing & Capacity</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="average_price">Average Price</label>
                        <input type="text" id="average_price" name="average_price" value="{{ old('average_price', $destination->average_price) }}">
                        <small class="form-help">Example: $33 USD/persona</small>
                        @error('average_price')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="capacity">Maximum Capacity</label>
                        <input type="text" id="capacity" name="capacity" value="{{ old('capacity', $destination->capacity) }}">
                        <small class="form-help">Example: 40 PAX</small>
                        @error('capacity')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="payment_methods">Payment Methods</label>
                        <input type="text" id="payment_methods" name="payment_methods" value="{{ old('payment_methods', $destination->payment_methods) }}">
                        @error('payment_methods')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="mobile_coverage">Mobile Coverage</label>
                        <input type="text" id="mobile_coverage" name="mobile_coverage" value="{{ old('mobile_coverage', $destination->mobile_coverage) }}">
                        @error('mobile_coverage')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Criteria Tab -->
            <div class="tab-content" id="criteria-tab">
                <h3 class="tab-title">Tourism Criteria</h3>
                <div class="dynamic-list" id="criteria-list">
                    <div class="list-header">
                        <h4>Tourism Criteria</h4>
                        <button type="button" class="control-panel-button add-item-btn" data-list="criteria">
                            <i class="ph ph-plus"></i> Add Criteria
                        </button>
                    </div>
                    <div class="items-container">
                        @if($destination->tourism_criteria)
                            @foreach($destination->tourism_criteria as $index => $criteria)
                                <div class="dynamic-item">
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label>Criteria Name</label>
                                            <input type="text" name="tourism_criteria[{{ $index }}][name]" value="{{ $criteria['name'] }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="tourism_criteria[{{ $index }}][status]" required>
                                                <option value="positive" {{ $criteria['status'] === 'positive' ? 'selected' : '' }}>Positive</option>
                                                <option value="neutral" {{ $criteria['status'] === 'neutral' ? 'selected' : '' }}>Neutral</option>
                                                <option value="negative" {{ $criteria['status'] === 'negative' ? 'selected' : '' }}>Negative</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="remove-item-btn">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description Tab -->
            <div class="tab-content" id="description-tab">
                <h3 class="tab-title">Descriptions</h3>
                <div class="form-grid">
                    <div class="form-group span-full">
                        <label for="main_description">Main Description</label>
                        <textarea id="main_description" name="main_description" rows="4">{{ old('main_description', $destination->main_description) }}</textarea>
                        @error('main_description')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group span-full">
                        <label for="secondary_description">Secondary Description</label>
                        <textarea id="secondary_description" name="secondary_description" rows="4">{{ old('secondary_description', $destination->secondary_description) }}</textarea>
                        @error('secondary_description')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group span-full">
                        <label for="strengths_benefits">Strengths & Benefits</label>
                        <textarea id="strengths_benefits" name="strengths_benefits" rows="4">{{ old('strengths_benefits', $destination->strengths_benefits) }}</textarea>
                        @error('strengths_benefits')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Challenges Tab -->
            <div class="tab-content" id="challenges-tab">
                <h3 class="tab-title">Environmental Challenges</h3>
                <div class="dynamic-list" id="challenges-list">
                    <div class="list-header">
                        <h4>Environmental Challenges</h4>
                        <button type="button" class="control-panel-button add-item-btn" data-list="challenges">
                            <i class="ph ph-plus"></i> Add Challenge
                        </button>
                    </div>
                    <div class="items-container">
                        @if($destination->environmental_challenges)
                            @foreach($destination->environmental_challenges as $index => $challenge)
                                <div class="dynamic-item">
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label>Challenge Icon</label>
                                            <input type="text" name="environmental_challenges[{{ $index }}][icon]" value="{{ $challenge['icon'] ?? 'ph ph-warning' }}" placeholder="ph ph-warning">
                                        </div>
                                        <div class="form-group">
                                            <label>Challenge Title</label>
                                            <input type="text" name="environmental_challenges[{{ $index }}][title]" value="{{ $challenge['title'] }}" required>
                                        </div>
                                        <div class="form-group span-full">
                                            <label>Challenge Description</label>
                                            <textarea name="environmental_challenges[{{ $index }}][description]" rows="3" required>{{ $challenge['description'] }}</textarea>
                                        </div>
                                    </div>
                                    <button type="button" class="remove-item-btn">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Gallery Tab -->
            <div class="tab-content" id="gallery-tab">
                <h3 class="tab-title">Photo Gallery</h3>
                <div class="form-group">
                    <label for="gallery_images">Upload Photos (Max 8 photos, 5MB each)</label>
                    <div class="file-upload-area">
                        <input type="file" id="gallery_images" name="gallery_images[]" multiple accept="image/*" class="file-input">
                        <div class="upload-placeholder">
                            <i class="ph ph-upload"></i>
                            <p>Drag & drop photos here or click to browse</p>
                            <small>JPEG, PNG, JPG, GIF up to 5MB each</small>
                        </div>
                    </div>
                    @error('gallery_images.*')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Preview Area for New Images -->
                <div id="imagePreviewContainer" class="image-preview-container" style="display: none;">
                    <h4>New Images to Upload</h4>
                    <div id="imagePreviewGrid" class="gallery-grid"></div>
                </div>

                @if($destination->gallery_images && count($destination->gallery_images) > 0)
                    <div class="existing-gallery">
                        <h4>Current Photos</h4>
                        <div class="gallery-grid">
                            @foreach($destination->gallery_images as $index => $image)
                                <div class="gallery-item" data-index="{{ $index }}">
                                    <img src="{{ Storage::url($image) }}" alt="Gallery image {{ $index + 1 }}">
                                    <div class="gallery-item-actions">
                                        <button type="button" class="remove-gallery-image" data-index="{{ $index }}">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="existing_gallery_images[]" value="{{ $image }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="control-panel-button control-panel-button-primary">
                    <i class="ph ph-floppy-disk"></i> Save Changes
                </button>
                <button type="button" class="control-panel-button control-panel-button-secondary" onclick="resetForm()">
                    <i class="ph ph-arrow-counter-clockwise"></i> Reset
                </button>
                <a href="{{ route('editor.destinations.index') }}" class="control-panel-button control-panel-button-secondary">
                    <i class="ph ph-x"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- External CSS for Edit Form -->
    <link href="{{ asset('css/edit-destination.css') }}" rel="stylesheet">

    <!-- JavaScript for Tab Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.dataset.tab + '-tab';

                    // Remove active class from all tabs and buttons
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked button and corresponding content
                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                });
            });

            // Dynamic list functionality
            const addButtons = document.querySelectorAll('.add-item-btn');
            addButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const listType = this.dataset.list;
                    addListItem(listType);
                });
            });

            // Remove item functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item-btn') || e.target.closest('.remove-item-btn')) {
                    e.target.closest('.dynamic-item').remove();
                }
            });
        });

        function addListItem(listType) {
            const container = document.querySelector(`#${listType}-list .items-container`);
            const itemCount = container.children.length;
            
            let itemHTML = '';
            
            if (listType === 'activities') {
                itemHTML = `
                    <div class="dynamic-item">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Activity Icon</label>
                                <input type="text" name="activities[${itemCount}][icon]" value="ph ph-activity" placeholder="ph ph-activity">
                            </div>
                            <div class="form-group">
                                <label>Activity Name</label>
                                <input type="text" name="activities[${itemCount}][name]" required>
                            </div>
                        </div>
                        <button type="button" class="remove-item-btn">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                `;
            } else if (listType === 'services') {
                itemHTML = `
                    <div class="dynamic-item">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Service Icon</label>
                                <input type="text" name="services[${itemCount}][icon]" value="ph ph-gear" placeholder="ph ph-gear">
                            </div>
                            <div class="form-group">
                                <label>Service Name</label>
                                <input type="text" name="services[${itemCount}][name]" required>
                            </div>
                            <div class="form-group">
                                <label>Available</label>
                                <select name="services[${itemCount}][available]">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="remove-item-btn">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                `;
            } else if (listType === 'criteria') {
                itemHTML = `
                    <div class="dynamic-item">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Criteria Name</label>
                                <input type="text" name="tourism_criteria[${itemCount}][name]" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="tourism_criteria[${itemCount}][status]" required>
                                    <option value="positive">Positive</option>
                                    <option value="neutral">Neutral</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="remove-item-btn">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                `;
            } else if (listType === 'challenges') {
                itemHTML = `
                    <div class="dynamic-item">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Challenge Icon</label>
                                <input type="text" name="environmental_challenges[${itemCount}][icon]" value="ph ph-warning" placeholder="ph ph-warning">
                            </div>
                            <div class="form-group">
                                <label>Challenge Title</label>
                                <input type="text" name="environmental_challenges[${itemCount}][title]" required>
                            </div>
                            <div class="form-group span-full">
                                <label>Challenge Description</label>
                                <textarea name="environmental_challenges[${itemCount}][description]" rows="3" required></textarea>
                            </div>
                        </div>
                        <button type="button" class="remove-item-btn">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                `;
            }
            
            container.insertAdjacentHTML('beforeend', itemHTML);
        }

        function resetForm() {
            if (confirm('Are you sure you want to reset all changes? This action cannot be undone.')) {
                document.getElementById('destination-form').reset();
            }
        }

        // Gallery functionality
        function initGallery() {
            const fileInput = document.getElementById('gallery_images');
            const uploadArea = document.querySelector('.file-upload-area');
            
            if (!fileInput || !uploadArea) return;

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    if (validateGalleryFiles(files)) {
                        fileInput.files = files;
                        showImagePreviews(files);
                    }
                }
            });

            // File input change
            fileInput.addEventListener('change', function() {
                if (!validateGalleryFiles(this.files)) {
                    this.value = ''; // Clear the input if validation fails
                    clearPreviews();
                } else {
                    showImagePreviews(this.files);
                }
            });

            // Remove gallery image functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-gallery-image')) {
                    e.preventDefault();
                    const button = e.target.closest('.remove-gallery-image');
                    const galleryItem = button.closest('.gallery-item');
                    const index = button.dataset.index;
                    
                    if (confirm('Are you sure you want to remove this image?')) {
                        galleryItem.remove();
                        
                        // Add hidden input to mark image for removal
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'remove_gallery_images[]';
                        hiddenInput.value = index;
                        document.getElementById('destination-form').appendChild(hiddenInput);
                    }
                }
            });
        }

        function validateGalleryFiles(files) {
            const maxFiles = 8;
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            
            // Count existing images
            const existingImages = document.querySelectorAll('.gallery-item').length;
            const totalImages = existingImages + files.length;
            
            if (totalImages > maxFiles) {
                alert(`You can only have a maximum of ${maxFiles} images total. You currently have ${existingImages} images.`);
                return false;
            }
            
            for (let file of files) {
                if (!allowedTypes.includes(file.type)) {
                    alert(`File "${file.name}" is not a valid image type. Please use JPEG, PNG, JPG, or GIF.`);
                    return false;
                }
                
                if (file.size > maxSize) {
                    alert(`File "${file.name}" is too large. Maximum size is 5MB.`);
                    return false;
                }
            }
            
            return true;
        }

        // Image preview functions
        function showImagePreviews(files) {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewGrid = document.getElementById('imagePreviewGrid');
            
            // Clear existing previews
            previewGrid.innerHTML = '';
            
            if (files.length === 0) {
                previewContainer.style.display = 'none';
                return;
            }
            
            previewContainer.style.display = 'block';
            
            Array.from(files).forEach((file, index) => {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.innerHTML = `
                    <div class="preview-loading">Loading...</div>
                    <div class="preview-item-actions">
                        <button type="button" class="remove-preview-image" onclick="removePreviewImage(${index})">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                `;
                
                previewGrid.appendChild(previewItem);
                
                // Create image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${index + 1}">
                        <div class="preview-item-actions">
                            <button type="button" class="remove-preview-image" onclick="removePreviewImage(${index})">
                                <i class="ph ph-trash"></i>
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            });
        }
        
        function removePreviewImage(index) {
            const fileInput = document.getElementById('gallery_images');
            const dt = new DataTransfer();
            
            // Add all files except the one to remove
            Array.from(fileInput.files).forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });
            
            fileInput.files = dt.files;
            showImagePreviews(fileInput.files);
        }
        
        function clearPreviews() {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewGrid = document.getElementById('imagePreviewGrid');
            previewGrid.innerHTML = '';
            previewContainer.style.display = 'none';
        }

        // Initialize gallery when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initGallery();
        });
    </script>
</x-editor-layout>
