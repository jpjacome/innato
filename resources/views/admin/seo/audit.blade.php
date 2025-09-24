<x-control-panel-layout>
    <div class="seo-container">
        <div class="seo-page-header">
            <div class="seo-page-header-content">
                <h2 class="seo-page-title">Auditoría SEO</h2>
                <p class="seo-page-description">Revisa el estado SEO de tu sitio web.</p>
            </div>
            <div class="seo-page-header-actions">
                <a href="{{ route('admin.seo.audit') }}" class="seo-button seo-button-secondary seo-button-small">
                    <i class="fas fa-sync"></i>Actualizar
                </a>
                <a href="{{ route('admin.seo.index') }}" class="seo-button seo-button-secondary seo-button-small">
                    <i class="fas fa-arrow-left"></i>Volver
                </a>
            </div>
        </div>

        <div class="seo-audit-results">
            <h3 class="seo-card-title"><i class="fas fa-search-plus"></i> Resultados de Auditoría</h3>
            <p class="seo-audit-description">
                Esta auditoría básica revisa elementos fundamentales del SEO de tu sitio.
                <small class="seo-audit-timestamp">
                    Última actualización: {{ now()->format('d/m/Y H:i') }}
                </small>
            </p>

            <div class="seo-audit-items">
                @foreach($auditResults as $result)
                    <div class="seo-audit-item seo-audit-item-{{ $result['status'] }}">
                        <div class="seo-audit-icon">
                            @if($result['status'] === 'pass')
                                <i class="fas fa-check-circle"></i>
                            @elseif($result['status'] === 'warning')
                                <i class="fas fa-exclamation-triangle"></i>
                            @else
                                <i class="fas fa-times-circle"></i>
                            @endif
                        </div>
                        <div class="seo-audit-content">
                            <div class="seo-audit-test">{{ $result['test'] }}</div>
                            <div class="seo-audit-message">{{ $result['message'] }}</div>
                        </div>
                        <div class="seo-audit-status">
                            <span class="seo-audit-badge seo-audit-badge-{{ $result['status'] }}">
                                {{ $result['status'] === 'pass' ? 'BIEN' : ($result['status'] === 'warning' ? 'ADVERTENCIA' : 'ERROR') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="seo-quick-actions">
            <h3 class="seo-card-title"><i class="fas fa-bolt"></i> Acciones Rápidas</h3>
            <div class="seo-action-grid">
                
                <div class="seo-action-card">
                    <div class="seo-action-icon"><i class="fas fa-sitemap"></i></div>
                    <div class="seo-action-title">Generar Sitemap</div>
                    <form method="POST" action="{{ route('admin.seo.sitemap.generate') }}">
                        @csrf
                        <button type="submit" class="seo-button seo-action-button">
                            <i class="fas fa-sync"></i>Generar
                        </button>
                    </form>
                </div>

                <div class="seo-action-card">
                    <div class="seo-action-icon"><i class="fas fa-robot"></i></div>
                    <div class="seo-action-title">Editar Robots.txt</div>
                    <a href="{{ route('admin.seo.robots') }}" class="seo-button seo-action-button">
                        <i class="fas fa-edit"></i>Editar
                    </a>
                </div>

                <div class="seo-action-card">
                    <div class="seo-action-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="seo-action-title">SEO Destinos</div>
                    <a href="{{ route('admin.seo.destinations') }}" class="seo-button seo-action-button">
                        <i class="fas fa-edit"></i>Gestionar
                    </a>
                </div>

                <div class="seo-action-card">
                    <div class="seo-action-icon"><i class="fas fa-globe"></i></div>
                    <div class="seo-action-title">SEO Global</div>
                    <a href="{{ route('admin.seo.global') }}" class="seo-button seo-action-button">
                        <i class="fas fa-cog"></i>Configurar
                    </a>
                </div>

            </div>
        </div>

        <!-- Score Summary -->
        @php
            $passCount = collect($auditResults)->where('status', 'pass')->count();
            $totalCount = count($auditResults);
            $scorePercentage = $totalCount > 0 ? round(($passCount / $totalCount) * 100) : 0;
        @endphp
        
        <div class="seo-score-summary seo-score-{{ $scorePercentage >= 80 ? 'good' : ($scorePercentage >= 60 ? 'warning' : 'poor') }}">
            <div class="seo-score-percentage">
                {{ $scorePercentage }}%
            </div>
            <div class="seo-score-title">Puntuación SEO</div>
            <div class="seo-score-details">
                {{ $passCount }} de {{ $totalCount }} pruebas pasadas
            </div>
        </div>

    </div>
</x-control-panel-layout>