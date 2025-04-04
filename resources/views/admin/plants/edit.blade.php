<x-control-panel-layout>
    <div class="control-panel-card">
        <div class="flex">
            <h2 class="control-panel-title">{{ __('Edit Plant') }}: {{ $plant->name }}</h2>
            <div>
                <a href="{{ route('admin.plants.index') }}" class="control-panel-button">
                    Back to Plants
                </a>
                <a href="{{ route('admin.plants.show', $plant->id) }}" class="control-panel-button">
                    View Plant
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.plants.update', $plant->id) }}" enctype="multipart/form-data" class="control-panel-form">
            @csrf
            @method('PUT')
            
            <!-- Basic Plant Information -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Plant Information</h3>
                
                <div class="control-panel-grid">
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="name">Plant Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $plant->name) }}" class="control-panel-input" required autofocus>
                        @error('name')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="common_names">Common Names</label>
                        <input type="text" id="common_names" name="common_names" value="{{ old('common_names', $plant->common_names) }}" class="control-panel-input" placeholder="Separate multiple names with commas">
                        @error('common_names')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="control-panel-grid">
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="family">Family</label>
                        <input type="text" id="family" name="family" value="{{ old('family', $plant->family) }}" class="control-panel-input">
                        @error('family')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="native_range">Native Range</label>
                        <input type="text" id="native_range" name="native_range" value="{{ old('native_range', $plant->native_range) }}" class="control-panel-input">
                        @error('native_range')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Physical Information -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Physical Characteristics</h3>
                
                <div class="control-panel-grid">
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="age">Age</label>
                        <input type="text" id="age" name="age" value="{{ old('age', $plant->age) }}" class="control-panel-input">
                        @error('age')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="current_height">Current Height</label>
                        <input type="text" id="current_height" name="current_height" value="{{ old('current_height', $plant->current_height) }}" class="control-panel-input">
                        @error('current_height')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="expected_height">Expected Height</label>
                        <input type="text" id="expected_height" name="expected_height" value="{{ old('expected_height', $plant->expected_height) }}" class="control-panel-input">
                        @error('expected_height')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="control-panel-grid">
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="leaf_type">Leaf Type</label>
                        <input type="text" id="leaf_type" name="leaf_type" value="{{ old('leaf_type', $plant->leaf_type) }}" class="control-panel-input">
                        @error('leaf_type')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="bloom_time">Bloom Time</label>
                        <input type="text" id="bloom_time" name="bloom_time" value="{{ old('bloom_time', $plant->bloom_time) }}" class="control-panel-input">
                        @error('bloom_time')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="flower_color">Flower Color</label>
                        <input type="text" id="flower_color" name="flower_color" value="{{ old('flower_color', $plant->flower_color) }}" class="control-panel-input">
                        @error('flower_color')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="control-panel-form-group">
                    <label class="control-panel-label" for="fruit">Fruit</label>
                    <input type="text" id="fruit" name="fruit" value="{{ old('fruit', $plant->fruit) }}" class="control-panel-input">
                    @error('fruit')
                        <span class="control-panel-input-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <!-- Growing Conditions -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Growing Conditions</h3>
                
                <div class="control-panel-grid">
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="light">Light</label>
                        <input type="text" id="light" name="light" value="{{ old('light', $plant->light) }}" class="control-panel-input">
                        @error('light')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="soil">Soil</label>
                        <input type="text" id="soil" name="soil" value="{{ old('soil', $plant->soil) }}" class="control-panel-input">
                        @error('soil')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="control-panel-form-group">
                        <label class="control-panel-label" for="hardiness">Hardiness</label>
                        <input type="text" id="hardiness" name="hardiness" value="{{ old('hardiness', $plant->hardiness) }}" class="control-panel-input">
                        @error('hardiness')
                            <span class="control-panel-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Additional Information -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Additional Information</h3>
                
                <div class="control-panel-form-group">
                    <label class="control-panel-label" for="other_comments">Other Comments</label>
                    <textarea id="other_comments" name="other_comments" rows="4" class="control-panel-input">{{ old('other_comments', $plant->other_comments) }}</textarea>
                    @error('other_comments')
                        <span class="control-panel-input-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <!-- Existing Images -->
            @if($plant->images->isNotEmpty())
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Current Images</h3>
                
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
                    @foreach($plant->images as $image)
                    <div style="position: relative; width: 150px;">
                        <img src="{{ $image->image_path }}" alt="{{ $plant->name }}" style="width: 100%; height: 120px; object-fit: cover; border-radius: 4px;">
                        <form action="{{ route('admin.plants.images.destroy', ['plant' => $plant->id, 'image' => $image->id]) }}" method="POST" style="position: absolute; top: 5px; right: 5px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this image?');" class="control-panel-button control-panel-button-danger" style="padding: 2px 5px; font-size: 0.7rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Upload New Images -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Upload Additional Images</h3>
                
                <div class="control-panel-form-group">
                    <label class="control-panel-label" for="images">Upload Images</label>
                    <input id="images" name="images[]" type="file" multiple accept="image/*" class="control-panel-input">
                    <p style="font-size: 0.875rem; color: var(--accent-color); margin-top: 0.5rem;">You can upload multiple images. Maximum 5MB per image.</p>
                    @error('images')
                        <span class="control-panel-input-error">{{ $message }}</span>
                    @enderror
                    @error('images.*')
                        <span class="control-panel-input-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="control-panel-actions" style="margin-top: 1rem;">
                <button type="submit" class="control-panel-button">Update Plant</button>
            </div>
        </form>
    </div>
</x-control-panel-layout> 