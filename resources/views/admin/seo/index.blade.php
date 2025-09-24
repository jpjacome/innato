<x-control-panel-layout>
    <div class="main-content">
        <div class="seo-page-header">
            <div>
                <h1 class="seo-page-title">Gestión SEO</h1>
                <p class="seo-page-subtitle">Optimiza el SEO de tu sitio web desde aquí. Esta es una interfaz modesta para comenzar.</p>
            </div>
            <a href="{{ route('admin.pages') }}" class="seo-back-button">
                <i class="fas fa-arrow-left"></i>Volver a Páginas
            </a>
        </div>

        <div class="seo-cards-wrapper">
            <div class="seo-card">
                <h3 class="seo-card-title"><i class="fas fa-globe"></i> Configuración global</h3>
                <p class="seo-card-description">Meta tags globales, Google Analytics y ajustes básicos.</p>
                <div class="seo-card-actions">
                    <a href="{{ route('admin.seo.global') }}" class="seo-button"><i class="fas fa-cog"></i> Configurar</a>
                </div>
            </div>

            <div class="seo-card">
                <h3 class="seo-card-title"><i class="fas fa-map-marker-alt"></i> SEO de Destinos</h3>
                <p class="seo-card-description">Gestiona títulos y descripciones para destinos turísticos.</p>
                <div class="seo-card-actions">
                    <a href="{{ route('admin.seo.destinations') }}" class="seo-button"><i class="fas fa-edit"></i> Gestionar</a>
                    <span class="seo-badge">{{ $destinationsCount ?? 0 }} destinos</span>
                </div>
            </div>

            <div class="seo-card">
                <h3 class="seo-card-title"><i class="fas fa-file-alt"></i> SEO de Páginas</h3>
                <p class="seo-card-description">Meta información para páginas estáticas (Inicio, Acerca, Contacto).</p>
                <div class="seo-card-actions">
                    <a href="{{ route('admin.seo.pages') }}" class="seo-button"><i class="fas fa-edit"></i> Gestionar</a>
                    <span class="seo-badge">5 páginas</span>
                </div>
            </div>
        </div>

        <div class="seo-tools-section">
            <h3 class="seo-section-title"><i class="fas fa-tools"></i> Herramientas</h3>
            <div class="seo-cards-wrapper">
                <div class="seo-card">
                    <h4 class="seo-card-title"><i class="fas fa-sitemap"></i> Sitemap XML</h4>
                    <p class="seo-card-description">Generar y ver sitemap.</p>
                    <div class="seo-card-actions">
                        <form method="POST" action="{{ route('admin.seo.sitemap.generate') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="seo-button"><i class="fas fa-sync"></i> Generar</button>
                        </form>
                        <a href="/sitemap.xml" target="_blank" class="seo-button seo-button-secondary"><i class="fas fa-external-link-alt"></i> Ver</a>
                    </div>
                </div>

                <div class="seo-card">
                    <h4 class="seo-card-title"><i class="fas fa-robot"></i> Robots.txt</h4>
                    <p class="seo-card-description">Editar directivas para motores de búsqueda.</p>
                    <div class="seo-card-actions">
                        <a href="{{ route('admin.seo.robots') }}" class="seo-button"><i class="fas fa-edit"></i> Editar</a>
                        <a href="/robots.txt" target="_blank" class="seo-button seo-button-secondary"><i class="fas fa-external-link-alt"></i> Ver</a>
                    </div>
                </div>

                <div class="seo-card">
                    <h4 class="seo-card-title"><i class="fas fa-search-plus"></i> Auditoría SEO</h4>
                    <p class="seo-card-description">Ejecutar una auditoría básica del sitio.</p>
                    <div class="seo-card-actions">
                        <a href="{{ route('admin.seo.audit') }}" class="seo-button"><i class="fas fa-play"></i> Ejecutar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Stats Section -->
        @if(isset($seoStats))
        <div class="seo-stats-grid">
            <h4 class="seo-section-title">
                <i class="fas fa-chart-line"></i>
                Estado SEO Rápido
            </h4>
            
            <div class="seo-stat-item">
                <div class="seo-stat-number optimized">{{ $seoStats['optimized'] }}</div>
                <div class="seo-stat-label">Páginas optimizadas</div>
            </div>
            
            <div class="seo-stat-item">
                <div class="seo-stat-number partial">{{ $seoStats['partial'] }}</div>
                <div class="seo-stat-label">Optimización parcial</div>
            </div>
            
            <div class="seo-stat-item">
                <div class="seo-stat-number missing">{{ $seoStats['missing'] }}</div>
                <div class="seo-stat-label">Sin optimizar</div>
            </div>
            
            <div class="seo-stat-item">
                <div class="seo-stat-number total">{{ $seoStats['total'] }}</div>
                <div class="seo-stat-label">Total de páginas</div>
            </div>
        </div>
        @endif

    </div>
</x-control-panel-layout>