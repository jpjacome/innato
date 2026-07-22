<x-control-panel-layout>
    <div cl                        @if($product->image)
                            <div style="margin-bottom: 10px;">
                                <strong>Current Image:</strong><br>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="max-width:200px; border-radius: 4px;">
                            </div>
                        @endif
                        <input type="file" id="image" name="image" class="control-panel-input" accept="image/*">
                        <div id="imagePreview" style="margin-top: 10px; display: none;">
                            <strong>New Image Preview:</strong><br>
                            <img src="" alt="Preview" style="max-width: 200px; height: auto; border-radius: 4px; border: 1px solid #ddd;">
                        </div>
                        <small class="control-panel-help-text">Leave empty to keep current image. Recommended size: 300x300px or larger. Max file size: 2MB</small>ntrol-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.products.index') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Edit Product: {{ $product->title }}</h2>
        </div>
        <p class="control-panel-text-muted">Update the product information.</p>

        @if($errors->any())
            <div class="alert alert-error control-panel-alert-error-custom">
                <ul class="control-panel-alert-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            @method('PUT')
            
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-box"></i> Product Information</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="title" class="control-panel-label">Product Title <span class="control-panel-required">*</span></label>
                        <input type="text" id="title" name="title" class="control-panel-input" value="{{ old('title', $product->title) }}" required>
                    </div>
                    <div class="control-panel-form-grid-full">
                        <label for="description" class="control-panel-label">Product Description <span class="control-panel-required">*</span></label>
                        <textarea id="description" name="description" class="control-panel-input" rows="4" required>{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div>
                        <label for="price" class="control-panel-label">Price (USD)</label>
                        <input type="number" id="price" name="price" class="control-panel-input" value="{{ old('price', $product->price) }}" step="0.01" min="0" placeholder="0.00">
                        <small class="control-panel-help-text">Enter price in USD (optional)</small>
                    </div>
                    <div>
                        <label for="image" class="control-panel-label">Product Image</label>
                        @if($product->image)
                            <div style="margin-bottom:8px">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="max-width:200px; border-radius: 4px;">
                            </div>
                        @endif
                        <input type="file" id="image" name="image" class="control-panel-input" accept="image/*">
                        <small class="control-panel-help-text">Leave empty to keep current image. Recommended size: 300x300px or larger. Max file size: 2MB</small>
                    </div>
                    <div>
                        <label for="order" class="control-panel-label">Display Order</label>
                        <input type="number" id="order" name="order" class="control-panel-input" value="{{ old('order', $product->order) }}" min="0">
                        <small class="control-panel-help-text">Lower numbers appear first</small>
                    </div>
                    <div class="control-panel-form-grid-full">
                        <div class="control-panel-checkbox-wrapper">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
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
                    <i class="fas fa-save"></i> Update Product
                </button>
                <a href="/products" target="_blank" class="control-panel-button control-panel-button-secondary">
                    <i class="fas fa-external-link-alt"></i> View Products Page
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('image');
            const preview = document.getElementById('imagePreview');
            const previewImg = preview?.querySelector('img');
            
            if (!input || !preview || !previewImg) return;
            
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
                    previewImg.src = ev.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
</x-control-panel-layout>