<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Edit Products Page</h2>
        </div>
        <p class="control-panel-text-muted">Edit the content and settings for your Products page.</p>

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

        <form id="products-edit-form" method="POST" action="{{ route('admin.pages.update-products') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            @method('PUT')
            
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-box"></i> Banner Section</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="banner_title" class="control-panel-label">Título del Banner</label>
                        <input type="text" id="banner_title" name="banner_title" class="control-panel-input" value="{{ old('banner_title', $productsSetting->banner_title ?? 'PRODUCTOS LOCALES AUTÉNTICOS') }}">
                    </div>
                    <div>
                        <label for="banner_description" class="control-panel-label">Descripción del Banner</label>
                        <textarea id="banner_description" name="banner_description" class="control-panel-input" rows="3">{{ old('banner_description', $productsSetting->banner_description ?? 'Descubre la autenticidad de Ecuador a través de nuestros productos locales, cuidadosamente seleccionados por su calidad y tradición.') }}</textarea>
                    </div>
                    <div>
                        <label for="banner_image" class="control-panel-label">Imagen del Banner</label>
                        <div style="margin-bottom:8px">
                            @php
                                $bannerImgPath = null;
                                if (!empty($productsSetting->banner_image ?? null)) {
                                    $bannerImgPath = asset('storage/' . ltrim($productsSetting->banner_image, '/\\'));
                                } else {
                                    $bannerImgPath = asset('assets/imgs/bg5.png');
                                }
                            @endphp
                            <img src="{{ $bannerImgPath }}" alt="Banner Image" style="max-width:200px;">
                        </div>
                        <input type="file" id="banner_image" name="banner_image" class="control-panel-input" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-th-large"></i> Product Cards Section</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="section_title" class="control-panel-label">Título de la Sección</label>
                        <input type="text" id="section_title" name="section_title" class="control-panel-input" value="{{ old('section_title', $productsSetting->section_title ?? 'NUESTROS PRODUCTOS DESTACADOS') }}">
                    </div>
                    <div>
                        <label for="section_description" class="control-panel-label">Descripción de la Sección</label>
                        <textarea id="section_description" name="section_description" class="control-panel-input" rows="3">{{ old('section_description', $productsSetting->section_description ?? 'Cada producto cuenta una historia de tradición, calidad y el amor por nuestra tierra ecuatoriana.') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-seedling"></i> Product 1 - Cacao Orgánico</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="product1_title" class="control-panel-label">Título</label>
                        <input type="text" id="product1_title" name="product1_title" class="control-panel-input" value="{{ old('product1_title', $productsSetting->product1_title ?? 'CACAO ORGÁNICO') }}">
                    </div>
                    <div>
                        <label for="product1_description" class="control-panel-label">Descripción</label>
                        <textarea id="product1_description" name="product1_description" class="control-panel-input" rows="3">{{ old('product1_description', $productsSetting->product1_description ?? 'Cacao de origen ecuatoriano, cultivado de manera orgánica en las mejores tierras del país.') }}</textarea>
                    </div>
                    <div>
                        <label for="product1_image" class="control-panel-label">Imagen</label>
                        <div style="margin-bottom:8px">
                            @php
                                $product1ImgPath = asset('assets/imgs/cacao.jpg');
                                if (!empty($productsSetting->product1_image ?? null)) {
                                    $product1ImgPath = asset('storage/' . ltrim($productsSetting->product1_image, '/\\'));
                                }
                            @endphp
                            <img src="{{ $product1ImgPath }}" alt="Cacao Orgánico" style="max-width:150px;">
                        </div>
                        <input type="file" id="product1_image" name="product1_image" class="control-panel-input" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-coffee"></i> Product 2 - Café de Altura</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="product2_title" class="control-panel-label">Título</label>
                        <input type="text" id="product2_title" name="product2_title" class="control-panel-input" value="{{ old('product2_title', $productsSetting->product2_title ?? 'CAFÉ DE ALTURA') }}">
                    </div>
                    <div>
                        <label for="product2_description" class="control-panel-label">Descripción</label>
                        <textarea id="product2_description" name="product2_description" class="control-panel-input" rows="3">{{ old('product2_description', $productsSetting->product2_description ?? 'Café cultivado en las montañas andinas, con notas únicas que reflejan la riqueza de nuestros suelos.') }}</textarea>
                    </div>
                    <div>
                        <label for="product2_image" class="control-panel-label">Imagen</label>
                        <div style="margin-bottom:8px">
                            @php
                                $product2ImgPath = asset('assets/imgs/cafe.jpg');
                                if (!empty($productsSetting->product2_image ?? null)) {
                                    $product2ImgPath = asset('storage/' . ltrim($productsSetting->product2_image, '/\\'));
                                }
                            @endphp
                            <img src="{{ $product2ImgPath }}" alt="Café de Altura" style="max-width:150px;">
                        </div>
                        <input type="file" id="product2_image" name="product2_image" class="control-panel-input" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-cut"></i> Product 3 - Textiles Artesanales</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="product3_title" class="control-panel-label">Título</label>
                        <input type="text" id="product3_title" name="product3_title" class="control-panel-input" value="{{ old('product3_title', $productsSetting->product3_title ?? 'TEXTILES ARTESANALES') }}">
                    </div>
                    <div>
                        <label for="product3_description" class="control-panel-label">Descripción</label>
                        <textarea id="product3_description" name="product3_description" class="control-panel-input" rows="3">{{ old('product3_description', $productsSetting->product3_description ?? 'Textiles tradicionales tejidos a mano, preservando técnicas ancestrales de nuestras comunidades.') }}</textarea>
                    </div>
                    <div>
                        <label for="product3_image" class="control-panel-label">Imagen</label>
                        <div style="margin-bottom:8px">
                            @php
                                $product3ImgPath = asset('assets/imgs/textiles.jpg');
                                if (!empty($productsSetting->product3_image ?? null)) {
                                    $product3ImgPath = asset('storage/' . ltrim($productsSetting->product3_image, '/\\'));
                                }
                            @endphp
                            <img src="{{ $product3ImgPath }}" alt="Textiles Artesanales" style="max-width:150px;">
                        </div>
                        <input type="file" id="product3_image" name="product3_image" class="control-panel-input" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-tint"></i> Product 4 - Miel de Abeja</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="product4_title" class="control-panel-label">Título</label>
                        <input type="text" id="product4_title" name="product4_title" class="control-panel-input" value="{{ old('product4_title', $productsSetting->product4_title ?? 'MIEL DE ABEJA') }}">
                    </div>
                    <div>
                        <label for="product4_description" class="control-panel-label">Descripción</label>
                        <textarea id="product4_description" name="product4_description" class="control-panel-input" rows="3">{{ old('product4_description', $productsSetting->product4_description ?? 'Miel pura y natural, recolectada de colmenas ubicadas en ecosistemas diversos y pristinos.') }}</textarea>
                    </div>
                    <div>
                        <label for="product4_image" class="control-panel-label">Imagen</label>
                        <div style="margin-bottom:8px">
                            @php
                                $product4ImgPath = asset('assets/imgs/miel.jpg');
                                if (!empty($productsSetting->product4_image ?? null)) {
                                    $product4ImgPath = asset('storage/' . ltrim($productsSetting->product4_image, '/\\'));
                                }
                            @endphp
                            <img src="{{ $product4ImgPath }}" alt="Miel de Abeja" style="max-width:150px;">
                        </div>
                        <input type="file" id="product4_image" name="product4_image" class="control-panel-input" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="control-panel-fixed-actions">
                <a href="{{ route('admin.pages') }}" class="control-panel-button">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="control-panel-button">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="/products" target="_blank" class="control-panel-button">
                    <i class="fas fa-external-link-alt"></i> View Products Page
                </a>
            </div>
        </form>
    </div>
</x-control-panel-layout>
