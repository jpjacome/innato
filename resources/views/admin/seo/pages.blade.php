<x-control-panel-layout>
    <div class="seo-container">
        <div class="seo-page-header">
            <div class="seo-page-header-content">
                <h2 class="seo-page-title">SEO de Páginas Estáticas</h2>
                <p class="seo-page-description">Gestiona el SEO de páginas como Inicio, Acerca, Contacto.</p>
            </div>
            <a href="{{ route('admin.seo.index') }}" class="seo-button seo-button-secondary seo-button-small">
                <i class="fas fa-arrow-left"></i>Volver
            </a>
        </div>

        <div class="seo-coming-soon">
            <h3 class="seo-card-title"><i class="fas fa-file-alt"></i> Próximamente</h3>
            <p class="seo-coming-soon-message">
                La gestión SEO de páginas estáticas estará disponible próximamente.<br>
                Aquí podrás optimizar el SEO de Inicio, Acerca, Contacto y otras páginas.
            </p>
        </div>
    </div>
</x-control-panel-layout>