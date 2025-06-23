<x-control-panel-layout>
    <div class="control-panel-card welcome-card">
        <h2 class="control-panel-title">Welcome, {{ Auth::user()->name }}</h2>
        
        <div class="control-panel-grid" id="control-panel-grid-1">
            <!-- Quick Stats -->
            <div class="control-panel-card stats-card user-stats-card">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-people-fill"></i>
                </h3>
                <p class="control-panel-stat">{{ \App\Models\User::count() }}</p>
            </div>
            
            @if(Auth::user()->isAdmin() || Auth::user()->isEditor())
            <div class="control-panel-card stats-card plants-stats-card">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-tree"></i>
                </h3>
                <p class="control-panel-stat">{{ \App\Models\Plant::count() }}</p>
            </div>
            @endif
        </div>
    </div>

    @if(Auth::user()->isAdmin() || Auth::user()->isEditor())
    <!-- Plant Management Module Card -->
    <div class="control-panel-card plants-management-card">
        <h2 class="control-panel-title">Plant Management</h2>
        
        <div class="control-panel-grid">
            <!-- Plants List -->
            <a href="{{ route('admin.plants.index') }}" class="control-panel-card" style="text-decoration: none; color: inherit; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-database-fill"></i>
                    Plants Database
                </h3>
                <p>Manage plant information, images, and maintenance records.</p>
            </a>
            
            <!-- Add New Plant -->
            <a href="{{ route('admin.plants.create') }}" class="control-panel-card" style="text-decoration: none; color: inherit; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-tree"></i>
                    Add New Plant
                </h3>
                <p>Create a new plant record with detailed information and images.</p>
            </a>
            
            <!-- Maintenance Logs -->
            <a href="{{ route('admin.maintenance.index') }}" class="control-panel-card" style="text-decoration: none; color: inherit; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                <h3 class="control-panel-subtitle">
                    <i class="bi bi-journal-check"></i>
                    Maintenance Logs
                </h3>
                <p>Track watering, fertilization, pruning, and other plant care activities.</p>
            </a>
        </div>
    </div>
    
 
        
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorInputs = document.querySelectorAll('input[type="color"]');
            
            colorInputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Update the text value
                    const valueElement = document.getElementById(this.id + '_value');
                    if (valueElement) {
                        valueElement.textContent = this.value;
                    }
                });
            });

        });
    </script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</x-control-panel-layout> 