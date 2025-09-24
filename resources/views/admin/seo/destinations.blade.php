<x-control-panel-layout>
    <div class="main-content">
        <div class="seo-page-header">
            <div>
                <h1 class="seo-page-title">SEO de Destinos</h1>
                <p class="seo-page-subtitle">Gestiona la optimización SEO de cada destino turístico.</p>
            </div>
            <a href="{{ route('admin.seo.index') }}" class="seo-back-button">
                <i class="fas fa-arrow-left"></i>Volver
            </a>
        </div>

        <div class="seo-table-container">
            <table class="seo-table">
                <thead>
                    <tr>
                        <th>Destino</th>
                        <th>SEO Status</th>
                        <th>Meta Título</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if($destinations->count() > 0)
                        @foreach($destinations as $destination)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">{{ $destination->title }}</div>
                                <div style="color: var(--text-light); font-size: 0.85rem;">{{ $destination->province }}</div>
                            </td>
                            <td>
                                @if($destination->seoMeta && $destination->seoMeta->meta_title)
                                    <span class="seo-status-indicator seo-status-optimized">
                                        <i class="fas fa-check"></i> Optimizado
                                    </span>
                                @else
                                    <span class="seo-status-indicator seo-status-partial">
                                        <i class="fas fa-exclamation"></i> Pendiente
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $destination->seoMeta?->meta_title ?? $destination->getSeoTitle() }}
                            </td>
                            <td>
                                <a href="{{ route('admin.seo.destinations.edit', $destination) }}" class="seo-button">
                                    <i class="fas fa-edit"></i> Editar SEO
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-light);">
                                <i class="fas fa-map-marker-alt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                <p>No hay destinos disponibles.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if($destinations->hasPages())
            <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                {{ $destinations->links() }}
            </div>
        @endif
    </div>
</x-control-panel-layout>