<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Pages</h2>
        <p class="text-white opacity-75">This is the Pages management section. Content will be added here in the future.</p>

        <!-- Home Management Card -->
        <div class="control-panel-card pages-card" style="margin-top: 2rem;">
            <h3 class="control-panel-subtitle">
                <i class="fas fa-home"></i> 
                <a href="/home" target="_blank" style="color:inherit;text-decoration:underline;">Home</a>
            </h3>
            <p>Manage the content and statistics of your homepage.</p>
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <a href="{{ route('admin.pages.edit-home') }}" class="control-panel-button">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button class="control-panel-button control-panel-button-secondary">
                    <i class="fas fa-chart-bar"></i> Stats
                </button>
            </div>
        </div>

        <!-- Quick Access to Plant Management (REMOVED) -->
    </div>
</x-control-panel-layout>