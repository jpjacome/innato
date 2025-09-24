<x-control-panel-layout>
    <div class="main-content">
        <div class="seo-page-header">
            <div>
                <h1 class="seo-page-title">Configuración SEO Global</h1>
                <p class="seo-page-subtitle">Configuraciones SEO que afectan todo el sitio web.</p>
            </div>
            <a href="{{ route('admin.seo.index') }}" class="seo-back-button">
                <i class="fas fa-arrow-left"></i>Volver
            </a>
        </div>

        @if(session('success'))
            <div class="seo-success-message">
                <i class="fas fa-check-circle"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.seo.global.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Site Information -->
            <div class="seo-form-section">
                <h3 class="seo-card-title"><i class="fas fa-globe"></i> Información Básica del Sitio</h3>
                
                <div class="seo-form-grid">
                    <div class="seo-form-group">
                        <label class="seo-form-label">Título del Sitio</label>
                        <input type="text" name="site_title" value="{{ old('site_title', $settings->site_title) }}"
                               class="seo-form-input"
                               placeholder="INNATO - Turismo y Naturaleza en Ecuador">
                    </div>
                    
                    <div class="seo-form-group">
                        <label class="seo-form-label">Descripción del Sitio</label>
                        <textarea name="site_description" rows="3" 
                                  class="seo-form-textarea"
                                  placeholder="Descripción que aparecerá en motores de búsqueda">{{ old('site_description', $settings->site_description) }}</textarea>
                    </div>

                    <div class="seo-form-group">
                        <label class="seo-form-label">Palabras Clave</label>
                        <input type="text" name="site_keywords" value="{{ old('site_keywords', $settings->site_keywords) }}"
                               class="seo-form-input"
                               placeholder="turismo, ecuador, naturaleza, destinos">
                    </div>

                    <div class="seo-form-grid-2">
                        <div class="seo-form-group">
                            <label class="seo-form-label">Autor</label>
                            <input type="text" name="author" value="{{ old('author', $settings->author) }}"
                                   class="seo-form-input"
                                   placeholder="INNATO">
                        </div>
                        
                        <div class="seo-form-group">
                            <label class="seo-form-label">Idioma del Sitio</label>
                            <select name="site_language" class="seo-form-select">
                                <option value="es" {{ old('site_language', $settings->site_language) == 'es' ? 'selected' : '' }}>Español</option>
                                <option value="en" {{ old('site_language', $settings->site_language) == 'en' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Open Graph Settings -->
            <div class="seo-form-section">
                <h3 class="seo-card-title"><i class="fab fa-facebook"></i> Open Graph (Facebook/WhatsApp)</h3>
                
                <div class="seo-form-grid">
                    <div class="seo-form-group">
                        <label class="seo-form-label">Nombre del Sitio (OG)</label>
                        <input type="text" name="og_site_name" value="{{ old('og_site_name', $settings->og_site_name) }}"
                               class="seo-form-input"
                               placeholder="INNATO">
                    </div>

                    <div class="seo-form-group">
                        <label class="seo-form-label">Imagen OG Global</label>
                        <input type="file" name="og_image" accept="image/*" class="seo-form-input seo-form-file">
                        @if($settings->og_image)
                            <div class="seo-image-preview">
                                <img src="{{ asset('storage/' . $settings->og_image) }}" alt="OG Image">
                            </div>
                        @endif
                    </div>

                    <div class="seo-form-group">
                        <label class="seo-form-label">Tipo de Contenido OG</label>
                        <select name="og_type" class="seo-form-select">
                            <option value="website" {{ old('og_type', $settings->og_type) == 'website' ? 'selected' : '' }}>Website</option>
                            <option value="article" {{ old('og_type', $settings->og_type) == 'article' ? 'selected' : '' }}>Article</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Twitter Settings -->
            <div class="seo-form-section">
                <h3 class="seo-card-title"><i class="fab fa-twitter"></i> Twitter Cards</h3>
                
                <div class="seo-form-grid">
                    <div class="seo-form-group">
                        <label class="seo-form-label">Tipo de Twitter Card</label>
                        <select name="twitter_card" class="seo-form-select">
                            <option value="summary" {{ old('twitter_card', $settings->twitter_card) == 'summary' ? 'selected' : '' }}>Summary</option>
                            <option value="summary_large_image" {{ old('twitter_card', $settings->twitter_card) == 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
                        </select>
                    </div>

                    <div class="seo-form-grid-2">
                        <div class="seo-form-group">
                            <label class="seo-form-label">Twitter Site (@username)</label>
                            <input type="text" name="twitter_site" value="{{ old('twitter_site', $settings->twitter_site) }}"
                                   class="seo-form-input"
                                   placeholder="@innato_ecuador">
                        </div>
                        
                        <div class="seo-form-group">
                            <label class="seo-form-label">Twitter Creator (@username)</label>
                            <input type="text" name="twitter_creator" value="{{ old('twitter_creator', $settings->twitter_creator) }}"
                                   class="seo-form-input"
                                   placeholder="@creator_username">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics & Tracking -->
            <div class="seo-form-section">
                <h3 class="seo-card-title"><i class="fas fa-chart-line"></i> Analytics y Seguimiento</h3>
                
                <div class="seo-form-grid-2">
                    <div class="seo-form-group">
                        <label class="seo-form-label">Google Analytics ID</label>
                        <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $settings->google_analytics_id) }}"
                               class="seo-form-input"
                               placeholder="GA4-XXXXXXXXX">
                    </div>
                    
                    <div class="seo-form-group">
                        <label class="seo-form-label">Google Tag Manager ID</label>
                        <input type="text" name="google_tag_manager_id" value="{{ old('google_tag_manager_id', $settings->google_tag_manager_id) }}"
                               class="seo-form-input"
                               placeholder="GTM-XXXXXXX">
                    </div>
                </div>

                <div class="seo-form-grid-3">
                    <div class="seo-form-group">
                        <label class="seo-form-label">Google Site Verification</label>
                        <input type="text" name="google_site_verification" value="{{ old('google_site_verification', $settings->google_site_verification) }}"
                               class="seo-form-input"
                               placeholder="código de verificación">
                    </div>
                    
                    <div class="seo-form-group">
                        <label class="seo-form-label">Bing Site Verification</label>
                        <input type="text" name="bing_site_verification" value="{{ old('bing_site_verification', $settings->bing_site_verification) }}"
                               class="seo-form-input"
                               placeholder="código de verificación">
                    </div>

                    <div class="seo-form-group">
                        <label class="seo-form-label">Yandex Verification</label>
                        <input type="text" name="yandex_site_verification" value="{{ old('yandex_site_verification', $settings->yandex_site_verification) }}"
                               class="seo-form-input"
                               placeholder="código de verificación">
                    </div>
                </div>
            </div>

            <!-- Custom Scripts -->
            <div class="seo-form-section">
                <h3 class="seo-card-title"><i class="fas fa-code"></i> Scripts Personalizados</h3>
                
                <div class="seo-form-grid-2">
                    <div class="seo-form-group">
                        <label class="seo-form-label">Scripts en &lt;head&gt;</label>
                        <textarea name="head_scripts" rows="6" 
                                  class="seo-form-textarea seo-form-code"
                                  placeholder="<!-- Scripts que van en el head -->">{{ old('head_scripts', $settings->head_scripts) }}</textarea>
                    </div>
                    
                    <div class="seo-form-group">
                        <label class="seo-form-label">Scripts en &lt;body&gt;</label>
                        <textarea name="body_scripts" rows="6" 
                                  class="seo-form-textarea seo-form-code"
                                  placeholder="<!-- Scripts que van antes del cierre del body -->">{{ old('body_scripts', $settings->body_scripts) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- SEO Features -->
            <div class="seo-form-section">
                <h3 class="seo-card-title"><i class="fas fa-toggle-on"></i> Características SEO</h3>
                
                <div class="seo-form-grid-2">
                    <label class="seo-form-checkbox-group">
                        <input type="checkbox" name="enable_canonical_urls" value="1" 
                               {{ old('enable_canonical_urls', $settings->enable_canonical_urls) ? 'checked' : '' }}
                               class="seo-form-checkbox">
                        <span>Habilitar URLs Canónicas</span>
                    </label>
                    
                    <label class="seo-form-checkbox-group">
                        <input type="checkbox" name="enable_og_tags" value="1" 
                               {{ old('enable_og_tags', $settings->enable_og_tags) ? 'checked' : '' }}
                               class="seo-form-checkbox">
                        <span>Habilitar Open Graph Tags</span>
                    </label>
                    
                    <label class="seo-form-checkbox-group">
                        <input type="checkbox" name="enable_twitter_cards" value="1" 
                               {{ old('enable_twitter_cards', $settings->enable_twitter_cards) ? 'checked' : '' }}
                               class="seo-form-checkbox">
                        <span>Habilitar Twitter Cards</span>
                    </label>
                    
                    <label class="seo-form-checkbox-group">
                        <input type="checkbox" name="enable_schema_markup" value="1" 
                               {{ old('enable_schema_markup', $settings->enable_schema_markup) ? 'checked' : '' }}
                               class="seo-form-checkbox">
                        <span>Habilitar Schema Markup</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="seo-form-actions">
                <button type="submit" class="seo-button">
                    <i class="fas fa-save"></i>Guardar Configuración Global
                </button>
                <a href="{{ route('admin.seo.index') }}" class="seo-button seo-button-secondary">
                    <i class="fas fa-times"></i>Cancelar
                </a>
            </div>

        </form>
    </div>
</x-control-panel-layout>