<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Pages</h2>
        <p class="text-white opacity-75">This is the Pages management section. Content will be added here in the future.</p>
        
        <!-- Quick Access to Plant Management -->
        <div class="control-panel-card pages-card" style="margin-top: 2rem;">
            <h3 class="control-panel-subtitle">Plant Management</h3>
            <p>Manage your botanical collection and maintenance records in our plant database.</p>
            
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <a href="{{ route('admin.plants.index') }}" class="control-panel-button">
                    <i class="fas fa-leaf"></i> View Plants
                </a>
                
                <a href="{{ route('admin.plants.create') }}" class="control-panel-button control-panel-button-secondary">
                    <i class="fas fa-plus"></i> Add New Plant
                </a>
                
                <a href="{{ route('admin.maintenance.index') }}" class="control-panel-button control-panel-button-secondary">
                    <i class="fas fa-calendar-check"></i> Maintenance Logs
                </a>
            </div>
        </div>
    </div>
</x-control-panel-layout> 