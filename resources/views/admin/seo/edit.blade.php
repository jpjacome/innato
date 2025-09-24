<x-control-panel-layout>
    <div class="seo-container">
        <div class="seo-page-header">
            <div class="seo-page-header-content">
                <h2 class="seo-page-title">Editar SEO</h2>
                <p class="seo-page-description">Edita las meta etiquetas y la vista previa social para este recurso.</p>
            </div>
            <a href="{{ $backUrl ?? route('admin.seo.index') }}" class="seo-button seo-button-secondary seo-button-small">
                <i class="fas fa-arrow-left"></i>Volver
            </a>
        </div>

        <form method="POST" action="{{ $resourceType === 'destination' ? route('admin.seo.destinations.update', $resource) : '#' }}" class="seo-edit-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="seo-edit-layout">
                <div class="seo-edit-main">
                    <div class="seo-form-section">
                        <h3 class="seo-card-title"><i class="fas fa-heading"></i> Meta información</h3>

                        <div class="seo-form-group">
                            <label for="meta_title" class="seo-form-label">Título SEO <span id="title-count" class="seo-char-count">(0/60)</span></label>
                            <input id="meta_title" name="meta_title" type="text" maxlength="60" placeholder="Título SEO (máx 60 caracteres)" class="seo-form-input" value="{{ old('meta_title', $resource->seoMeta?->meta_title) }}">
                            <div class="seo-form-hint">Recomendado: 50-60 caracteres</div>
                        </div>

                        <div class="seo-form-group">
                            <label for="meta_description" class="seo-form-label">Descripción SEO <span id="desc-count" class="seo-char-count">(0/160)</span></label>
                            <textarea id="meta_description" name="meta_description" rows="4" maxlength="160" placeholder="Descripción meta (máx 160 caracteres)" class="seo-form-textarea">{{ old('meta_description', $resource->seoMeta?->meta_description) }}</textarea>
                            <div class="seo-form-hint">Recomendado: 150-160 caracteres</div>
                        </div>

                        <div class="seo-form-group">
                            <label for="meta_keywords" class="seo-form-label">Palabras clave (opcional)</label>
                            <input id="meta_keywords" name="meta_keywords" type="text" placeholder="turismo, ecuador, naturaleza" class="seo-form-input" value="{{ old('meta_keywords', $resource->seoMeta?->meta_keywords) }}">
                        </div>

                        <div class="seo-form-group">
                            <label for="canonical_url" class="seo-form-label">URL Canónica (opcional)</label>
                            <input id="canonical_url" name="canonical_url" type="url" placeholder="https://example.com/destino" class="seo-form-input" value="{{ old('canonical_url', $resource->seoMeta?->canonical_url) }}">
                        </div>

                        <div class="seo-form-group">
                            <label for="og_image" class="seo-form-label">Imagen Open Graph (opcional)</label>
                            <input id="og_image" name="og_image" type="file" accept="image/*" class="seo-form-input">
                            <div class="seo-form-hint">Recomendado: 1200x630px, menores a 2MB</div>
                            @if($resource->seoMeta?->og_image)
                                <div class="seo-image-preview">
                                    <img src="{{ asset('storage/' . $resource->seoMeta->og_image) }}" alt="OG Image" class="seo-preview-image">
                                </div>
                            @endif
                        </div>

                        <label class="seo-form-checkbox-group">
                            <input type="checkbox" name="robots_index" value="1" {{ old('robots_index', $resource->seoMeta?->robots_index ?? true) ? 'checked' : '' }} 
                                   class="seo-form-checkbox"> 
                            <span>Permitir indexación en buscadores</span>
                        </label>

                        <label class="seo-form-checkbox-group">
                            <input type="checkbox" name="robots_follow" value="1" {{ old('robots_follow', $resource->seoMeta?->robots_follow ?? true) ? 'checked' : '' }}
                                   class="seo-form-checkbox">
                            <span>Permitir seguir enlaces</span>
                        </label>

                        <div class="seo-form-actions">
                            <button type="submit" class="seo-button"><i class="fas fa-save"></i>Guardar</button>
                            <button type="reset" class="seo-button seo-button-secondary"><i class="fas fa-eraser"></i>Restablecer</button>
                        </div>
                    </div>
                </div>

                <aside class="seo-edit-sidebar">
                    <div class="seo-preview-card">
                        <h3 class="seo-card-title"><i class="fab fa-google"></i> Vista previa en Google</h3>
                        <div class="seo-google-preview">
                            <div id="preview-title" class="seo-preview-title">{{ $resource->getSeoTitle() }}</div>
                            <div id="preview-url" class="seo-preview-url">{{ url()->current() }}</div>
                            <div id="preview-description" class="seo-preview-description">{{ $resource->getSeoDescription() }}</div>
                        </div>
                    </div>

                    <div class="seo-preview-card">
                        <h3 class="seo-card-title"><i class="fab fa-facebook"></i> Vista previa social</h3>
                        <div class="seo-social-preview">
                            <div class="seo-social-image">
                                @if($resource->seoMeta?->og_image)
                                    <img src="{{ asset('storage/' . $resource->seoMeta->og_image) }}" alt="OG" class="seo-social-img">
                                @else
                                    OG Image
                                @endif
                            </div>
                            <div class="seo-social-content">
                                <div id="social-title" class="seo-social-title">{{ $resource->seoMeta?->og_title ?? $resource->getSeoTitle() }}</div>
                                <div id="social-description" class="seo-social-description">{{ $resource->seoMeta?->og_description ?? $resource->getSeoDescription() }}</div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </form>
    </div>
</x-control-panel-layout>