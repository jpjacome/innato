
<x-control-panel-layout>
    <div class="control-panel-card pages-main-card">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem;">
            <h2 class="control-panel-title" style="margin:0">Páginas</h2>
            <a href="{{ route('admin.seo.index') }}" class="control-panel-button" style="font-size:0.9rem; padding:0.4rem 0.8rem; white-space:nowrap;">
                <i class="fas fa-search"></i>&nbsp;SEO
            </a>
        </div>
        <p class="text-white opacity-75">Esta es la sección de gestión de páginas. El contenido se añadirá aquí en el futuro.</p>



        <!-- Home Management Card -->
         <div class="cards-wrapper">

        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-home"></i> 
                <a href="/home" target="_blank" style="color:inherit;text-decoration:underline;">Inicio</a>
            </h3>
            <p>Gestiona el contenido y las estadísticas de tu página de inicio.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-home') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('admin.pages.home-stats') }}" class="control-panel-button control-panel-button-secondary">
                    <i class="fas fa-chart-bar"></i> Estadísticas
                </a>
            </div>
        </div>

        <!-- About Management Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-info-circle"></i>
                <a href="/about" target="_blank" style="color:inherit;text-decoration:underline;">Acerca de</a>
            </h3>
            <p>Gestiona el contenido de tu página Acerca de.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-about') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>

        <!-- Destinations Management Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-map-marker-alt"></i>
                <a href="/destinations" target="_blank" style="color:inherit;text-decoration:underline;">Destinos</a>
            </h3>
            <p>Gestiona el contenido de tu página de Destinos.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-destinations') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>

        <!-- Experience Center Management Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-university"></i>
                <a href="/experience-center" target="_blank" style="color:inherit;text-decoration:underline;">Centro de Experiencias</a>
            </h3>
            <p>Gestiona el contenido de tu página Centro de Experiencias.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.experience-center.edit') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>

        <!-- Products Management Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-box"></i>
                <a href="/products" target="_blank" style="color:inherit;text-decoration:underline;">Productos</a>
            </h3>
            <p>Gestiona el contenido y catálogo de tu página de Productos Locales.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.products.index') }}" class="control-panel-button">
                    <i class="fas fa-cogs"></i> Gestionar Catálogo
                </a>
                <a href="{{ route('admin.pages.edit-products') }}" class="control-panel-button control-panel-button-secondary">
                    <i class="fas fa-edit"></i> Editar Página
                </a>
            </div>
        </div>

        <!-- Contact Management Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-envelope"></i>
                <a href="/contact" target="_blank" style="color:inherit;text-decoration:underline;">Contacto</a>
            </h3>
            <p>Gestiona el contenido de tu página de Contacto.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.contact.edit') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>

        <!-- Components Section -->
        <h2 class="control-panel-title" style="margin-top: 3rem;">Componentes</h2>

        <!-- Header Component Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-heading"></i>
                Encabezado
            </h3>
            <p>Gestiona el componente Encabezado de tu sitio.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.components.edit-header') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>

        <!-- Footer Component Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-shoe-prints"></i>
                Pie de página
            </h3>
            <p>Gestiona el componente Pie de página de tu sitio.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.components.edit-footer') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>

        <!-- Reviews Component Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-star"></i>
                Reseñas
            </h3>
            <p>Gestiona el componente Reseñas de tu sitio.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.components.edit-reviews') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>

        <!-- El Patio Section -->
        <h2 class="control-panel-title" style="margin-top: 3rem;">El Patio</h2>

        <!-- El Patio - Inicio Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-home"></i>
                Inicio
            </h3>
            <p>Gestiona la página de inicio de El Patio.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-elpatio') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="/elpatio" target="_blank" class="control-panel-button control-panel-button-secondary">
                    <i class="fas fa-eye"></i> Ver sitio
                </a>
            </div>
        </div>

        <!-- El Patio - Header Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-heading"></i>
                Encabezado
            </h3>
            <p>Gestiona el encabezado específico de El Patio (logo, nav, redes).</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-elpatio-header') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>

        <!-- El Patio - Footer Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-shoe-prints"></i>
                Pie de página
            </h3>
            <p>Gestiona el pie de página específico de El Patio (contacto, redes, copyright).</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-elpatio-footer') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>
        

        <!-- El Patio - Blog Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-th-large"></i>
                Blog
            </h3>
            <p>Gestiona la sección de blog y listas de entradas.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-elpatio-blog') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>
        </div>
    </div>
</x-control-panel-layout>