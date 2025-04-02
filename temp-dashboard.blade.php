<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Welcome to the Dashboard</h2>
        
        <div class="control-panel-grid">
            <!-- Quick Stats -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Users</h3>
                <p class="control-panel-stat">{{ \App\Models\User::count() }}</p>
            </div>

            <!-- Recent Activity -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Recent Activity</h3>
                <p>No recent activity</p>
            </div>

            <!-- Quick Actions -->
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Quick Actions</h3>
                <div class="control-panel-actions">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('users.index') }}" class="control-panel-button">
                            Manage Users
                        </a>
                        <a href="{{ route('settings.index') }}" class="control-panel-button">
                            Settings
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-control-panel-layout> 