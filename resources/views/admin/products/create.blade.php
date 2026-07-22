<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.products.index') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Add New Product</h2>
        </div>
        <p class="control-panel-text-muted">Create a new product for your products catalog.</p>

        @if($errors->any())
            <div class="alert alert-error control-panel-alert-error-custom">
                <ul class="control-panel-alert-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-box"></i> Product Information</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="title" class="control-panel-label">Product Title <span class="control-panel-required">*</span></label>
                        <input type="text" id="title" name="title" class="control-panel-input" value="{{ old('title') }}" required>
                    </div>
                    <div class="control-panel-form-grid-full">
                        <label for="description" class="control-panel-label">Product Description <span class="control-panel-required">*</span></label>
                        <textarea id="description" name="description" class="control-panel-input" rows="4" required>{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label for="price" class="control-panel-label">Price (USD)</label>
                        <input type="number" id="price" name="price" class="control-panel-input" value="{{ old('price') }}" step="0.01" min="0" placeholder="0.00">
                        <small class="control-panel-help-text">Enter price in USD (optional)</small>
                    </div>
                    <div>
                        <label for="image" class="control-panel-label">Product Image</label>
                        <div style="margin-bottom:8px">
                            <img id="imagePreview" src="{{ asset('assets/imgs/placeholder-300.png') }}" alt="Product image preview" style="max-width:200px; border-radius: 4px; display: none;">
                        </div>
                        <input type="file" id="image" name="image" class="control-panel-input" accept="image/*">
                        <small class="control-panel-help-text">Recommended size: 300x300px or larger. Max file size: 2MB</small>
                    </div>
                    <div>
                        <label for="order" class="control-panel-label">Display Order</label>
                        <input type="number" id="order" name="order" class="control-panel-input" value="{{ old('order', 0) }}" min="0">
                        <small class="control-panel-help-text">Lower numbers appear first</small>
                    </div>
                    <div class="control-panel-form-grid-full">
                        <div class="control-panel-checkbox-wrapper">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="control-panel-checkbox-label">
                                <i class="fas fa-check"></i> Active (visible on products page)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="control-panel-fixed-actions">
                <a href="{{ route('admin.products.index') }}" class="control-panel-button">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="control-panel-button">
                    <i class="fas fa-save"></i> Create Product
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('image');
            const preview = document.getElementById('imagePreview');
            
            if (!input || !preview) return;
            
            input.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) {
                    preview.style.display = 'none';
                    return;
                }
                
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select a valid image file');
                    this.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                // Validate file size (2MB = 2048KB)
                if (file.size > 2048 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function (ev) {
                    preview.src = ev.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
</x-control-panel-layout>