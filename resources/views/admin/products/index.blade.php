<x-control-panel-layout>
    <div class="control-panel-card">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Products Management</h2>
            <a href="{{ route('admin.products.create') }}" class="control-panel-button">
                <i class="fas fa-plus"></i> Add New Product
            </a>
        </div>
        <p class="control-panel-text-muted">Manage your products catalog. Add, edit, or remove products that appear on your products page.</p>

        @if(session('success'))
            <div class="alert alert-success control-panel-alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($products->count() > 0)
            <div class="control-panel-table-container">
                <table class="control-panel-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->title }}</strong>
                                </td>
                                <td>
                                    <span class="control-panel-text-muted">
                                        {{ Str::limit($product->description, 60) }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->price)
                                        <span class="control-panel-badge control-panel-badge-primary">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="control-panel-badge control-panel-badge-secondary">No price</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="control-panel-badge">{{ $product->order }}</span>
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="control-panel-badge control-panel-badge-success">Active</span>
                                    @else
                                        <span class="control-panel-badge control-panel-badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="control-panel-button-group">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="control-panel-button control-panel-button-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="control-panel-button control-panel-button-sm control-panel-button-danger" 
                                                onclick="deleteProduct({{ $product->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="control-panel-empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No Products Yet</h3>
                <p>Create your first product to get started with your products catalog.</p>
                <a href="{{ route('admin.products.create') }}" class="control-panel-button">
                    <i class="fas fa-plus"></i> Add First Product
                </a>
            </div>
        @endif

        <div class="control-panel-card-actions">
            <a href="/products" target="_blank" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-external-link-alt"></i> View Products Page
            </a>
        </div>
    </div>

    <script>
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                fetch(`/admin/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Error deleting product. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting product. Please try again.');
                });
            }
        }
    </script>
</x-control-panel-layout>