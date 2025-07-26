
<x-control-panel-layout>
    <div class="control-panel-card pages-main-card">
        <h2 class="control-panel-title">Páginas</h2>
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
        </div>
    </div>
</x-control-panel-layout>