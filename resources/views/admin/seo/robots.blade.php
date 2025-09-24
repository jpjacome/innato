<x-control-panel-layout>
    <div class="seo-container">
        <div class="seo-page-header">
            <div class="seo-page-header-content">
                <h2 class="seo-page-title">Gestión de Robots.txt</h2>
                <p class="seo-page-description">Configura las directivas para motores de búsqueda.</p>
            </div>
            <a href="{{ route('admin.seo.index') }}" class="seo-button seo-button-secondary seo-button-small">
                <i class="fas fa-arrow-left"></i>Volver
            </a>
        </div>

        @if(session('success'))
            <div class="seo-alert seo-alert-success">
                <i class="fas fa-check-circle"></i>{{ session('success') }}
            </div>
        @endif

        <div class="seo-form-section">
            <form action="{{ route('admin.seo.robots.update') }}" method="POST" class="seo-robots-form">
                @csrf
                @method('PUT')
                
                <div class="seo-robots-editor">
                    <div class="seo-robots-header">
                        <h3 class="seo-card-title">
                            <i class="fas fa-robot"></i> Contenido de Robots.txt
                        </h3>
                        <div class="seo-robots-actions">
                            <a href="/robots.txt" target="_blank" class="seo-button seo-button-secondary seo-button-small">
                                <i class="fas fa-external-link-alt"></i>Ver actual
                            </a>
                        </div>
                    </div>
                    
                    <textarea 
                        name="robots_content" 
                        rows="15" 
                        class="seo-form-textarea seo-form-code seo-robots-textarea"
                        placeholder="User-agent: *&#10;Allow: /&#10;&#10;Sitemap: {{ url('/sitemap.xml') }}"
                        required
                    >{{ old('robots_content', $robotsContent) }}</textarea>
                    
                    @error('robots_content')
                        <div class="seo-form-error">
                            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="seo-form-actions">
                    <button type="submit" class="seo-button">
                        <i class="fas fa-save"></i>Guardar Robots.txt
                    </button>
                    <button type="button" onclick="resetToDefault()" class="seo-button seo-button-secondary">
                        <i class="fas fa-undo"></i>Restaurar por defecto
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="seo-help-section">
            <h3 class="seo-card-title"><i class="fas fa-info-circle"></i> Ayuda</h3>
            <div class="seo-help-content">
                <p><strong>Directivas comunes:</strong></p>
                <ul class="seo-help-list">
                    <li><code>User-agent: *</code> - Aplica a todos los robots</li>
                    <li><code>Allow: /</code> - Permite el acceso a todo el sitio</li>
                    <li><code>Disallow: /admin</code> - Bloquea el acceso a /admin</li>
                    <li><code>Sitemap: URL</code> - Indica la ubicación del sitemap</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function resetToDefault() {
            const textarea = document.querySelector('textarea[name="robots_content"]');
            const defaultContent = `User-agent: *
Allow: /

Sitemap: {{ url('/sitemap.xml') }}`;
            textarea.value = defaultContent;
        }
    </script>
</x-control-panel-layout>