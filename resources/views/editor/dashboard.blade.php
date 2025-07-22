<x-editor-layout>
    <div class="control-panel-card welcome-card">
        <h2 class="control-panel-title">Welcome, {{ Auth::user()->name }}</h2>
        <p class="control-panel-subtitle">Editor Dashboard - Manage Destination Content</p>
        
        <div class="control-panel-grid" id="control-panel-grid-1">
            <!-- Destinations Stats -->
            <div class="control-panel-card stats-card">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-map-marker-alt"></i>
                    Destinations
                </h3>
                <p class="control-panel-stat">{{ $destinationsCount }}</p>
                <p class="control-panel-stat-description">Total destinations to manage</p>
            </div>
            
            <!-- Recent Activity -->
            <div class="control-panel-card stats-card">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-edit"></i>
                    Quick Access
                </h3>
                <a href="{{ route('editor.destinations.index') }}" class="control-panel-button">
                    Manage Destinations
                </a>
            </div>
        </div>
    </div>

    <!-- Destinations Overview -->
    <div class="control-panel-card">
        <h3 class="control-panel-subtitle">
            <i class="fas fa-list"></i>
            Your Destinations
        </h3>
        
        @if($destinations->count() > 0)
            <div class="destinations-grid">
                @foreach($destinations as $destination)
                    <div class="destination-card">
                        <div class="destination-header">
                            <h4>
                                <a href="{{ route('destination.show', $destination->slug) }}" target="_blank" class="destination-title-link">
                                    {{ $destination->title }}
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </h4>
                            <span class="destination-status status-{{ $destination->status }}">
                                {{ ucfirst($destination->status) }}
                            </span>
                        </div>
                        <p class="destination-subtitle">{{ $destination->subtitle }}</p>
                        <p class="destination-location">📍 {{ $destination->province }}, {{ $destination->canton }}</p>
                        
                        <div class="destination-actions">
                            <a href="{{ route('destination.show', $destination->slug) }}" target="_blank" class="control-panel-button control-panel-button-secondary">
                                <i class="fas fa-eye"></i> View Page
                            </a>
                            <a href="{{ route('editor.destinations.edit', $destination) }}" class="control-panel-button control-panel-button-primary">
                                <i class="fas fa-edit"></i> Edit Content
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-map-marker-alt fa-3x"></i>
                <h4>No destinations found</h4>
                <p>There are no destinations available for editing at the moment.</p>
            </div>
        @endif
    </div>

    <!-- Custom Styles for Editor Dashboard -->
    <style>
        .destinations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .destination-card {
            background: var(--control-panel-card-bg);
            border: 1px solid var(--control-panel-border);
            border-radius: 8px;
            padding: 1.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .destination-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .destination-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        .destination-header h4 {
            margin: 0;
            color: var(--control-panel-text);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .destination-title-link {
            color: var(--control-panel-text);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.2s;
        }

        .destination-title-link:hover {
            color: var(--control-panel-accent);
            text-decoration: none;
        }

        .destination-title-link i {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .destination-status {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: #10b981;
            color: white;
        }

        .status-inactive {
            background: #6b7280;
            color: white;
        }

        .destination-subtitle {
            color: var(--control-panel-text-muted);
            margin: 0.5rem 0;
            font-size: 0.9rem;
        }

        .destination-location {
            color: var(--control-panel-text-muted);
            margin: 0.5rem 0;
            font-size: 0.85rem;
        }

        .destination-actions {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--control-panel-border);
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .destination-actions .control-panel-button {
            flex: 1;
            min-width: 120px;
            text-align: center;
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
        }

        .control-panel-button-secondary {
            background: var(--control-panel-border);
            color: var(--control-panel-text);
            border: 1px solid var(--control-panel-border);
        }

        .control-panel-button-secondary:hover {
            background: var(--control-panel-text-muted);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--control-panel-text-muted);
        }

        .empty-state i {
            color: var(--control-panel-text-muted);
            opacity: 0.5;
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            margin: 1rem 0 0.5rem 0;
            color: var(--control-panel-text);
        }

        .control-panel-stat-description {
            font-size: 0.8rem;
            color: var(--control-panel-text-muted);
            margin-top: 0.25rem;
        }
    </style>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</x-editor-layout>
