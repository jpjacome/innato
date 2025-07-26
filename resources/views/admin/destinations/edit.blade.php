@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-control-panel-layout>
    <div class="control-panel-card destination-card">
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h2 class="control-panel-title">
                        <i class="fas fa-edit"></i>
                        Edit Destination: {{ $destination->title }}
                    </h2>
                    <p class="control-panel-subtitle">Modo edición administrador - Todos los campos disponibles</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('destination.show', $destination->slug) }}" 
                       class="control-panel-button control-panel-button-secondary" target="_blank">
                        <i class="fas fa-eye"></i> View Public Page
                    </a>
                    <a href="{{ route('admin.destinations.index') }}" class="control-panel-button control-panel-button-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Destinations
                    </a>
                </div>
            </div>
        </div>

        @if($destination->assignedEditor)
            <div class="editor-info-card">
                <h3><i class="fas fa-user"></i> Editor asignado</h3>
                <p><strong>{{ $destination->assignedEditor->name }}</strong> ({{ $destination->assignedEditor->email }})</p>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                Por favor corrige los siguientes errores:
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
                Información básica
            </button>
            <button class="tab-button" data-tab="location">
                <i class="ph ph-map-pin"></i>
                Ubicación
            </button>
            <button class="tab-button" data-tab="climate">
                <i class="ph ph-sun"></i>
                Clima
            </button>
            <button class="tab-button" data-tab="access">
                <i class="ph ph-road-horizon"></i>
                Acceso
            </button>
            <button class="tab-button" data-tab="schedule">
                <i class="ph ph-clock"></i>
                Horario
            </button>
            <button class="tab-button" data-tab="contact">
                <i class="ph ph-phone"></i>
                Contacto
            </button>
            <button class="tab-button" data-tab="activities">
                <i class="ph ph-activity"></i>
                Actividades
            </button>
            <button class="tab-button" data-tab="audience">
                <i class="ph ph-users"></i>
                Público objetivo
            </button>
            <button class="tab-button" data-tab="services">
                <i class="ph ph-gear"></i>
                Servicios
            </button>
            <button class="tab-button" data-tab="pricing">
                <i class="ph ph-currency-dollar"></i>
                Precios
            </button>
            <button class="tab-button" data-tab="criteria">
                <i class="ph ph-medal"></i>
                Criterios
            </button>
            <button class="tab-button" data-tab="description">
                <i class="ph ph-file-text"></i>
                Descripción
            </button>
            <button class="tab-button" data-tab="challenges">
                <i class="ph ph-warning"></i>
                Retos
            </button>
            <button class="tab-button" data-tab="gallery">
                <i class="ph ph-images"></i>
                Fotos
            </button>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.destinations.update', $destination) }}" id="destination-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Info Tab -->
            <div class="tab-content active" id="basic-tab">
                <h3 class="tab-title">Información básica</h3>
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
                        <label for="slug">Slug *</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $destination->slug) }}" required>
                        <small class="form-help">Unique identifier for the URL (e.g. playa-mariscal)</small>
                        @error('slug')
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
                <h3 class="tab-title">Detalles de ubicación</h3>
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
                <h3 class="tab-title">Información climática</h3>
                <div class="climate-seasons">
                    <!-- Dry Season -->
                    <div class="season-group">
                        <h4><i class="fas fa-sun"></i> Dry Season</h4>
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
                        <h4><i class="fas fa-cloud-rain"></i> Wet Season</h4>
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
                <h3 class="tab-title">Acceso y transporte</h3>
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
                <h3 class="tab-title">Horario y entrada</h3>
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
                <h3 class="tab-title">Información de contacto</h3>
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
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $destination->contact_email) === 'unknown' ? '' : old('contact_email', $destination->contact_email) }}">
                        @error('contact_email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Activities Tab -->
            <div class="tab-content" id="activities-tab">
                <h3 class="tab-title">Actividades turísticas</h3>
                <div class="dynamic-list" id="activities-list">
                    <div class="list-header">
                        <h4>Activities List</h4>
                        <button type="button" class="control-panel-button add-item-btn" data-list="activities">
                            <i class="fas fa-plus"></i> Add Activity
                        </button>
                        <button type="button" class="control-panel-button" id="open-activities-icons-list-modal">
                            <i class="ph ph-list"></i> Icons List
                        </button>
        <!-- Activities Icons List Modal -->
        <div id="activitiesIconsListModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;">
            <div style="background:#fff; max-width:480px; width:90vw; max-height:80vh; border-radius:12px; box-shadow:0 2px 24px #2225; padding:2rem 1.5rem; overflow:auto; position:relative;">
                <h3 style="margin-top:0; margin-bottom:1rem; font-size:1.3rem;">Phosphor Icon Names</h3>
                <button type="button" id="close-activities-icons-list-modal" style="position:absolute; top:12px; right:16px; background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
                <input type="text" id="activitiesIconFilterInput" placeholder="Filter icons..." style="width:100%; margin-bottom:0.75rem; padding:0.4rem 0.7rem; font-size:1rem; border:1px solid #ddd; border-radius:6px;">
                <div style="max-height:60vh; overflow-y:auto; border:1px solid #eee; border-radius:8px; padding:0.5rem 0.75rem; background:#fafafa;">
                    <ul id="activitiesIconsListUl" style="list-style:none; margin:0; padding:0; font-size:1.05rem;">
                        @foreach(file(public_path('assets/phosphor-icon-names.txt')) as $iconName)
                            <li style="padding:2px 0; border-bottom:1px solid #f0f0f0;">{{ trim($iconName) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
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
                        <input type="text" name="activities[{{ $index }}][name]" value="{{ $activity['name'] ?? $activity }}">
                                        </div>
                                    </div>
                                    <button type="button" class="remove-item-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Audience Tab -->
            <div class="tab-content" id="audience-tab">
                <h3 class="tab-title">Público objetivo</h3>
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
                <h3 class="tab-title">Servicios e instalaciones</h3>
                <div class="dynamic-list" id="services-list">
                    <div class="list-header">
                        <h4>Servicios Disponibles</h4>
                        <button type="button" class="control-panel-button add-item-btn" data-list="services">
                            <i class="fas fa-plus"></i> Agregar Servicio
                        </button>
                        <button type="button" class="control-panel-button" id="open-icons-list-modal">
                            <i class="ph ph-list"></i> Lista de Iconos
                        </button>
        <!-- Icons List Modal -->
        <div id="iconsListModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;">
            <div style="background:#fff; max-width:480px; width:90vw; max-height:80vh; border-radius:12px; box-shadow:0 2px 24px #2225; padding:2rem 1.5rem; overflow:auto; position:relative;">
                <h3 style="margin-top:0; margin-bottom:1rem; font-size:1.3rem;">Nombres de Iconos Phosphor</h3>
                <button type="button" id="close-icons-list-modal" style="position:absolute; top:12px; right:16px; background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
                <input type="text" id="iconFilterInput" placeholder="Filtrar iconos..." style="width:100%; margin-bottom:0.75rem; padding:0.4rem 0.7rem; font-size:1rem; border:1px solid #ddd; border-radius:6px;">
                <div style="max-height:60vh; overflow-y:auto; border:1px solid #eee; border-radius:8px; padding:0.5rem 0.75rem; background:#fafafa;">
                    <ul id="iconsListUl" style="list-style:none; margin:0; padding:0; font-size:1.05rem;">
                        @foreach(file(public_path('assets/phosphor-icon-names.txt')) as $iconName)
                            <li style="padding:2px 0; border-bottom:1px solid #f0f0f0;">{{ trim($iconName) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
                    </div>
                    <div class="items-container">
                        @if($destination->services && count($destination->services) > 0)
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
                                                <option value="1" {{ (isset($service['available']) && $service['available']) ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ (isset($service['available']) && !$service['available']) ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="remove-item-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="dynamic-item">
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label>Service Icon</label>
                                        <input type="text" name="services[0][icon]" value="ph ph-gear" placeholder="ph ph-gear">
                                    </div>
                                    <div class="form-group">
                                        <label>Service Name</label>
                                        <input type="text" name="services[0][name]">
                                    </div>
                                    <div class="form-group">
                                        <label>Available</label>
                                        <select name="services[0][available]">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="remove-item-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pricing Tab -->
            <div class="tab-content" id="pricing-tab">
                <h3 class="tab-title">Precios y capacidad</h3>
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
                <h3 class="tab-title">Criterios turísticos</h3>
                <div class="form-grid">
                    <div class="form-group span-full">
                        <label for="tourism_criteria_access">Acceso a personas de tercera edad y/o con discapacidad</label>
                        <select id="tourism_criteria_access" name="tourism_criteria[access]">
                            <option value="SI" {{ (old('tourism_criteria.access', $destination->tourism_criteria['access'] ?? '') == 'SI') ? 'selected' : '' }}>SI</option>
                            <option value="NO" {{ (old('tourism_criteria.access', $destination->tourism_criteria['access'] ?? '') == 'NO') ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                    <div class="form-group span-full">
                        <label for="tourism_criteria_access_status">Estado del acceso para personas de tercera edad y/o con discapacidad</label>
                        <select id="tourism_criteria_access_status" name="tourism_criteria[access_status]">
                            <option value="SI" {{ (old('tourism_criteria.access_status', $destination->tourism_criteria['access_status'] ?? '') == 'SI') ? 'selected' : '' }}>SI</option>
                            <option value="NO" {{ (old('tourism_criteria.access_status', $destination->tourism_criteria['access_status'] ?? '') == 'NO') ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                    <div class="form-group span-full">
                        <label for="tourism_criteria_security">Seguridad en los alrededores</label>
                        <select id="tourism_criteria_security" name="tourism_criteria[security]">
                            <option value="SI" {{ (old('tourism_criteria.security', $destination->tourism_criteria['security'] ?? '') == 'SI') ? 'selected' : '' }}>SI</option>
                            <option value="NO" {{ (old('tourism_criteria.security', $destination->tourism_criteria['security'] ?? '') == 'NO') ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                    <div class="form-group span-full">
                        <label for="tourism_criteria_personnel">Cordialidad del Personal</label>
                        <input type="text" id="tourism_criteria_personnel" name="tourism_criteria[personnel]" value="{{ old('tourism_criteria.personnel', $destination->tourism_criteria['personnel'] ?? '') }}">
                    </div>
                    <div class="form-group span-full">
                        <label for="tourism_criteria_languages">Desempeño del personal en otros idiomas</label>
                        <select id="tourism_criteria_languages" name="tourism_criteria[languages]">
                            <option value="SI" {{ (old('tourism_criteria.languages', $destination->tourism_criteria['languages'] ?? '') == 'SI') ? 'selected' : '' }}>SI</option>
                            <option value="NO" {{ (old('tourism_criteria.languages', $destination->tourism_criteria['languages'] ?? '') == 'NO') ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                    <div class="form-group span-full">
                        <label for="tourism_criteria_decoration">Concepto en la decoración del sitio</label>
                        <input type="text" id="tourism_criteria_decoration" name="tourism_criteria[decoration]" value="{{ old('tourism_criteria.decoration', $destination->tourism_criteria['decoration'] ?? '') }}">
                    </div>
                    <div class="form-group span-full">
                        <label for="tourism_criteria_waste">Manejo de desechos</label>
                        <select id="tourism_criteria_waste" name="tourism_criteria[waste]">
                            <option value="SI" {{ (old('tourism_criteria.waste', $destination->tourism_criteria['waste'] ?? '') == 'SI') ? 'selected' : '' }}>SI</option>
                            <option value="NO" {{ (old('tourism_criteria.waste', $destination->tourism_criteria['waste'] ?? '') == 'NO') ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                </div>
                </div>
            </div>

            <!-- Description Tab -->
            <div class="tab-content" id="description-tab">
                <h3 class="tab-title">Descripciones</h3>
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
                <h3 class="tab-title">Reto ambiental</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="environmental_challenges_icon">Challenge Icon</label>
                        <input type="text" id="environmental_challenges_icon" name="environmental_challenges[0][icon]" value="{{ old('environmental_challenges.0.icon', $destination->environmental_challenges[0]['icon'] ?? 'ph ph-trash') }}" placeholder="ph ph-trash">
                    </div>
                    <div class="form-group">
                        <label for="environmental_challenges_title">Challenge Title</label>
                        <input type="text" id="environmental_challenges_title" name="environmental_challenges[0][title]" value="{{ old('environmental_challenges.0.title', $destination->environmental_challenges[0]['title'] ?? 'Contaminación') }}" required>
                    </div>
                    <div class="form-group span-full">
                        <label for="environmental_challenges_description">Challenge Description</label>
                        <textarea id="environmental_challenges_description" name="environmental_challenges[0][description]" rows="3" required>{{ old('environmental_challenges.0.description', $destination->environmental_challenges[0]['description'] ?? 'Generación de residuos, especialmente plásticos en feriados que contaminan el entorno natural y marino.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Gallery Tab -->
            <div class="tab-content" id="gallery-tab">
                <h3 class="tab-title">Galería de fotos</h3>
                <div class="form-group">
                    <label for="gallery_images">Subir fotos (máx. 8 fotos, 5MB cada una)</label>
                    <div class="file-upload-area">
                        <input type="file" id="gallery_images" name="gallery_images[]" multiple accept="image/*" class="file-input">
                        <div class="upload-placeholder">
                            <i class="ph ph-upload"></i>
                            <p>Arrastra y suelta fotos aquí o haz clic para buscar</p>
                            <small>JPEG, PNG, JPG, GIF hasta 5MB cada una</small>
                        </div>
                    </div>
                    @error('gallery_images.*')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Preview Area for New Images -->
                <div id="imagePreviewContainer" class="image-preview-container" style="display: none;">
                        <h4>Nuevas imágenes para subir</h4>
                    <div id="imagePreviewGrid" class="gallery-grid"></div>
                </div>

                @if($destination->gallery_images && count($destination->gallery_images) > 0)
                    <div class="existing-gallery">
                        <h4>Fotos actuales</h4>
                    <div style="margin-bottom: 0.5rem; color: #444; font-size: 0.98rem;">
                        <strong>Nota:</strong> El tamaño máximo de imagen es 5MB. La <strong>primera foto</strong> de esta galería se mostrará como imagen principal en la sección hero de la página del destino.
                    </div>
                        <div class="gallery-grid" id="galleryGrid">
                            @foreach($destination->gallery_images as $index => $image)
                                <div class="gallery-item" data-index="{{ $index }}">
                                    <div class="gallery-position-badge" style="position:absolute;top:8px;left:8px;background:#222;color:#fff;padding:2px 8px;border-radius:12px;font-size:0.9rem;z-index:2;">{{ $index + 1 }}</div>
                                    <img src="{{ Storage::url($image) }}" alt="Gallery image {{ $index + 1 }}">
                                    <div class="gallery-item-actions">
                                        <button type="button" class="move-left" data-index="{{ $index }}" @if($index == 0) disabled @endif>
                                            <i class="ph ph-arrow-left"></i>
                                        </button>
                                        <button type="button" class="move-right" data-index="{{ $index }}" @if($index == count($destination->gallery_images) - 1) disabled @endif>
                                            <i class="ph ph-arrow-right"></i>
                                        </button>
                                        <button type="button" class="remove-gallery-image" data-index="{{ $index }}">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="existing_gallery_images[]" value="{{ $image }}">
                                </div>
                            @endforeach
                            <input type="hidden" id="galleryOrderInput" name="gallery_order" value="{{ implode(',', $destination->gallery_images) }}">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="control-panel-button control-panel-button-primary">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
                <button type="button" class="control-panel-button control-panel-button-secondary" onclick="resetForm()">
                    <i class="fas fa-undo"></i> Restablecer
                </button>
                <a href="{{ route('editor.destinations.index') }}" class="control-panel-button control-panel-button-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- External CSS for Edit Form -->
    <link href="{{ asset('css/edit-destination.css') }}" rel="stylesheet">

    <!-- JavaScript for Tab Functionality -->
    <script>
        // Icons List Modal functionality with filter (Services & Activities)
        document.addEventListener('DOMContentLoaded', function() {
            // Services modal
            const openModalBtn = document.getElementById('open-icons-list-modal');
            const closeModalBtn = document.getElementById('close-icons-list-modal');
            const modal = document.getElementById('iconsListModal');
            const filterInput = document.getElementById('iconFilterInput');
            const iconsListUl = document.getElementById('iconsListUl');

            if (openModalBtn && modal) {
                openModalBtn.addEventListener('click', function() {
                    modal.style.display = 'flex';
                    if (filterInput) filterInput.value = '';
                    if (iconsListUl) {
                        Array.from(iconsListUl.children).forEach(li => li.style.display = '');
                    }
                });
            }
            if (closeModalBtn && modal) {
                closeModalBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }
            // Close modal when clicking outside
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.style.display = 'none';
                    }
                });
            }
            // Filter logic
            if (filterInput && iconsListUl) {
                filterInput.addEventListener('input', function() {
                    const filter = this.value.trim().toLowerCase();
                    Array.from(iconsListUl.children).forEach(li => {
                        if (li.textContent.toLowerCase().includes(filter)) {
                            li.style.display = '';
                        } else {
                            li.style.display = 'none';
                        }
                    });
                });
            }

            // Activities modal
            const openActivitiesModalBtn = document.getElementById('open-activities-icons-list-modal');
            const closeActivitiesModalBtn = document.getElementById('close-activities-icons-list-modal');
            const activitiesModal = document.getElementById('activitiesIconsListModal');
            const activitiesFilterInput = document.getElementById('activitiesIconFilterInput');
            const activitiesIconsListUl = document.getElementById('activitiesIconsListUl');

            if (openActivitiesModalBtn && activitiesModal) {
                openActivitiesModalBtn.addEventListener('click', function() {
                    activitiesModal.style.display = 'flex';
                    if (activitiesFilterInput) activitiesFilterInput.value = '';
                    if (activitiesIconsListUl) {
                        Array.from(activitiesIconsListUl.children).forEach(li => li.style.display = '');
                    }
                });
            }
            if (closeActivitiesModalBtn && activitiesModal) {
                closeActivitiesModalBtn.addEventListener('click', function() {
                    activitiesModal.style.display = 'none';
                });
            }
            // Close modal when clicking outside
            if (activitiesModal) {
                activitiesModal.addEventListener('click', function(e) {
                    if (e.target === activitiesModal) {
                        activitiesModal.style.display = 'none';
                    }
                });
            }
            // Filter logic
            if (activitiesFilterInput && activitiesIconsListUl) {
                activitiesFilterInput.addEventListener('input', function() {
                    const filter = this.value.trim().toLowerCase();
                    Array.from(activitiesIconsListUl.children).forEach(li => {
                        if (li.textContent.toLowerCase().includes(filter)) {
                            li.style.display = '';
                        } else {
                            li.style.display = 'none';
                        }
                    });
                });
            }
        });
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

            // Gallery image reordering
            document.getElementById('galleryGrid')?.addEventListener('click', function(e) {
                if (e.target.closest('.move-left')) {
                    const item = e.target.closest('.gallery-item');
                    const index = parseInt(item.dataset.index);
                    if (index > 0) {
                        const grid = document.getElementById('galleryGrid');
                        grid.insertBefore(item, grid.children[index - 1]);
                        updateGalleryOrder();
                    }
                }
                if (e.target.closest('.move-right')) {
                    const item = e.target.closest('.gallery-item');
                    const index = parseInt(item.dataset.index);
                    const grid = document.getElementById('galleryGrid');
                    if (index < grid.children.length - 1) {
                        grid.insertBefore(grid.children[index + 1], item);
                        updateGalleryOrder();
                    }
                }
            });
            function updateGalleryOrder() {
                const grid = document.getElementById('galleryGrid');
                const items = Array.from(grid.querySelectorAll('.gallery-item'));
                // Update data-index only; hidden inputs stay inside .gallery-item
                items.forEach((item, idx) => {
                    item.dataset.index = idx;
                    // Update the position badge
                    const badge = item.querySelector('.gallery-position-badge');
                    if (badge) badge.textContent = idx + 1;

                    // Update arrow button states
                    const leftBtn = item.querySelector('.move-left');
                    const rightBtn = item.querySelector('.move-right');
                    if (leftBtn) leftBtn.disabled = (idx === 0);
                    if (rightBtn) rightBtn.disabled = (idx === items.length - 1);
                });
                // Update the order input
                const orderInput = document.getElementById('galleryOrderInput');
                if (orderInput) {
                    const order = items.map(item => item.querySelector('input[name="existing_gallery_images[]"]').value);
                    orderInput.value = order.join(',');
                }
            }

            // On form submit, re-append .gallery-item elements in their current order to force correct input serialization
            const form = document.getElementById('destination-form');
            if (form) {
                form.addEventListener('submit', function() {
                    const grid = document.getElementById('galleryGrid');
                    const items = Array.from(grid.querySelectorAll('.gallery-item'));
                    items.forEach(item => grid.appendChild(item));
                });
            }
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
                            <i class="fas fa-trash"></i>
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
                            <i class="fas fa-trash"></i>
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
                            <i class="fas fa-trash"></i>
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
                            <i class="fas fa-trash"></i>
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
</x-control-panel-layout>
