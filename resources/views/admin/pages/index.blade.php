
<x-control-panel-layout>
    <div class="control-panel-card pages-main-card">
        <h2 class="control-panel-title">Pages</h2>
        <p class="text-white opacity-75">This is the Pages management section. Content will be added here in the future.</p>



        <!-- Home Management Card -->
         <div class="cards-wrapper">

        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-home"></i> 
                <a href="/home" target="_blank" style="color:inherit;text-decoration:underline;">Home</a>
            </h3>
            <p>Manage the content and statistics of your homepage.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-home') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.pages.home-stats') }}" class="control-panel-button control-panel-button-secondary">
                    <i class="fas fa-chart-bar"></i> Stats
                </a>
            </div>
        </div>

        <!-- About Management Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-info-circle"></i>
                <a href="/about" target="_blank" style="color:inherit;text-decoration:underline;">About</a>
            </h3>
            <p>Manage the content of your About page.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-about') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <!-- Destinations Management Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-map-marker-alt"></i>
                <a href="/destinations" target="_blank" style="color:inherit;text-decoration:underline;">Destinations</a>
            </h3>
            <p>Manage the content of your Destinations page.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.pages.edit-destinations') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <!-- Experience Center Management Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-university"></i>
                <a href="/experience-center" target="_blank" style="color:inherit;text-decoration:underline;">Experience Center</a>
            </h3>
            <p>Manage the content of your Experience Center page.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.experience-center.edit') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>


        <!-- Contact Management Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-envelope"></i>
                <a href="/contact" target="_blank" style="color:inherit;text-decoration:underline;">Contact</a>
            </h3>
            <p>Manage the content of your Contact page.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.contact.edit') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <!-- Components Section -->
        <h2 class="control-panel-title" style="margin-top: 3rem;">Components</h2>

        <!-- Header Component Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-heading"></i>
                Header
            </h3>
            <p>Manage the Header component of your site.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.components.edit-header') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <!-- Footer Component Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-shoe-prints"></i>
                Footer
            </h3>
            <p>Manage the Footer component of your site.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.components.edit-footer') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <!-- Reviews Component Card -->
        <div class="control-panel-card pages-card">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-star"></i>
                Reviews
            </h3>
            <p>Manage the Reviews component of your site.</p>
            <div class="pages-card-actions">
                <a href="{{ route('admin.components.edit-reviews') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
        </div>
    </div>
</x-control-panel-layout>