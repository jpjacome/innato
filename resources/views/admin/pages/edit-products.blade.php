<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Páginas
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Editar Página de Productos</h2>
        </div>
        <p class="control-panel-text-muted">Edita el contenido y la configuración de tu página de Productos.</p>

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
                <h3 class="control-panel-subtitle"><i class="fas fa-box"></i> Sección del Banner</h3>
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
                <h3 class="control-panel-subtitle"><i class="fas fa-th-large"></i> Sección de Tarjetas de Productos</h3>
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
                <h3 class="control-panel-subtitle"><i class="fas fa-info-circle"></i> Gestión de Productos</h3>
                <div class="control-panel-form-grid-full">
                    <div class="control-panel-info-box">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <i class="fas fa-lightbulb" style="color: #3B82F6; font-size: 1.5rem;"></i>
                            <div>
                                <h4 style="margin: 0; color: #1F2937;">Gestión Individual de Productos</h4>
                                <p style="margin: 0; color: #6B7280; font-size: 0.9rem;">Los productos ahora se gestionan individualmente a través del sistema de catálogo dinámico.</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <a href="{{ route('admin.products.index') }}" class="control-panel-button">
                                <i class="fas fa-cogs"></i> Gestionar Catálogo de Productos
                            </a>
                            <a href="{{ route('admin.products.create') }}" class="control-panel-button control-panel-button-secondary">
                                <i class="fas fa-plus"></i> Agregar Nuevo Producto
                            </a>
                        </div>
                        <div style="margin-top: 1rem; padding: 1rem; background: #F3F4F6; border-radius: 6px;">
                            <p style="margin: 0; font-size: 0.85rem; color: #4B5563;">
                                <strong>Nota:</strong> Este formulario ahora solo gestiona el banner de la página y los títulos de sección. 
                                Los productos individuales (títulos, descripciones, imágenes) se gestionan a través del Catálogo de Productos de arriba.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="control-panel-fixed-actions">
                <a href="{{ route('admin.pages') }}" class="control-panel-button">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="control-panel-button">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="/products" target="_blank" class="control-panel-button">
                    <i class="fas fa-external-link-alt"></i> Ver Página
                </a>
            </div>
        </form>
    </div>
</x-control-panel-layout>
