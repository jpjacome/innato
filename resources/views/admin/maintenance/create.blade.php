<x-control-panel-layout>
    <div class="control-panel-card">
        <div class="flex">
            <h2 class="control-panel-title">
                @isset($selectedPlant)
                    {{ __('Add Maintenance Log for') }} {{ $selectedPlant->name }}
                @else
                    {{ __('Add New Maintenance Log') }}
                @endisset
            </h2>
            <a href="{{ route('admin.maintenance.index') }}" class="control-panel-button">
                Back to Logs
            </a>
        </div>

        <form method="POST" action="{{ route('admin.maintenance.store') }}" enctype="multipart/form-data" class="control-panel-form">
            @csrf
            
            <!-- Plant Selection -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Plant Selection</h3>
                
                <div class="control-panel-form-group">
                    <label class="control-panel-label" for="plant_id">Select Plant</label>
                    <select id="plant_id" name="plant_id" class="control-panel-select" required>
                        <option value="">-- Select a plant --</option>
                        @foreach($plants as $plant)
                            <option value="{{ $plant->id }}" {{ (old('plant_id') == $plant->id || (isset($selectedPlant) && $selectedPlant->id == $plant->id)) ? 'selected' : '' }}>
                                {{ $plant->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('plant_id')
                        <span class="control-panel-input-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <!-- Watering Schedule -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Watering Schedule</h3>
                
                <div class="control-panel-grid">
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="last_watering">Last Watering</label>
                        <input type="date" id="last_watering" name="last_watering" value="{{ old('last_watering') }}" class="control-panel-input">
                        @error('last_watering')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="next_watering">Next Watering</label>
                        <input type="date" id="next_watering" name="next_watering" value="{{ old('next_watering') }}" class="control-panel-input">
                        @error('next_watering')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Fertilization Schedule -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Fertilization Schedule</h3>
                
                <div class="control-panel-grid">
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="last_fertilization">Last Fertilization</label>
                        <input type="date" id="last_fertilization" name="last_fertilization" value="{{ old('last_fertilization') }}" class="control-panel-input">
                        @error('last_fertilization')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="next_fertilization">Next Fertilization</label>
                        <input type="date" id="next_fertilization" name="next_fertilization" value="{{ old('next_fertilization') }}" class="control-panel-input">
                        @error('next_fertilization')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Pruning Schedule -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Pruning Schedule</h3>
                
                <div class="control-panel-grid">
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="last_pruning">Last Pruning</label>
                        <input type="date" id="last_pruning" name="last_pruning" value="{{ old('last_pruning') }}" class="control-panel-input">
                        @error('last_pruning')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="next_pruning">Next Pruning</label>
                        <input type="date" id="next_pruning" name="next_pruning" value="{{ old('next_pruning') }}" class="control-panel-input">
                        @error('next_pruning')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Pest/Disease Inspection -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Pest/Disease Inspection</h3>
                
                <div class="control-panel-form-group">
                    <label class="control-panel-label" for="pest_disease_inspection">Inspection Notes</label>
                    <textarea id="pest_disease_inspection" name="pest_disease_inspection" rows="4" class="control-panel-input" placeholder="Note any pests, diseases, or other observations">{{ old('pest_disease_inspection') }}</textarea>
                    @error('pest_disease_inspection')
                        <span class="control-panel-input-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <!-- Images -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Maintenance Images</h3>
                
                <div class="control-panel-form-group">
                    <label class="control-panel-label" for="images">Upload Images</label>
                    <input id="images" name="images[]" type="file" multiple accept="image/*" class="control-panel-input">
                    <p style="font-size: 0.875rem; color: var(--accent-color); margin-top: 0.5rem;">You can upload multiple images to document the plant's condition. Maximum 5MB per image.</p>
                    @error('images')
                        <span class="control-panel-input-error">{{ $message }}</span>
                    @enderror
                    @error('images.*')
                        <span class="control-panel-input-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="control-panel-actions" style="margin-top: 1rem;">
                <button type="submit" class="control-panel-button">Save Maintenance Log</button>
            </div>
        </form>
    </div>
</x-control-panel-layout> 