<x-editor-layout>
    <div class="control-panel-card">
        <div class="page-header">
            <h2 class="control-panel-title">
                <i class="fas fa-map-marker-alt"></i>
                Manage Destinations
            </h2>
            <p class="control-panel-subtitle">Edit content for all destination pages</p>
        </div>
        
        @if($destinations->count() > 0)
            <div class="destinations-table-container">
                <table class="destinations-table">
                    <thead>
                        <tr>
                            <th>Destination</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($destinations as $destination)
                            <tr>
                                <td>
                                    <div class="destination-info">
                                        <h4>
                                            <a href="{{ route('destination.show', $destination->slug) }}" target="_blank" class="destination-title-link">
                                                {{ $destination->title }}
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </h4>
                                        <p>{{ $destination->subtitle }}</p>
                                    </div>
                                </td>
                                <td>
                                    <span class="destination-type">{{ $destination->subtitle }}</span>
                                </td>
                                <td>
                                    <div class="location-info">
                                        <span>{{ $destination->province }}</span>
                                        <small>{{ $destination->canton }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $destination->status }}">
                                        {{ ucfirst($destination->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('destination.show', $destination->slug) }}" 
                                           class="control-panel-button control-panel-button-secondary btn-sm"
                                           target="_blank">
                                            <i class="fas fa-external-link-alt"></i> View Public Page
                                        </a>
                                        <a href="{{ route('editor.destinations.edit', $destination) }}" 
                                           class="control-panel-button control-panel-button-primary btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-map-marker-alt fa-3x"></i>
                <h4>No destinations found</h4>
                <p>There are no destinations available for editing at the moment.</p>
            </div>
        @endif
    </div>

    <!-- Custom Styles for Destinations Table -->
    <style>
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--control-panel-border);
        }

        .destinations-table-container {
            overflow-x: auto;
            margin-top: 1rem;
        }

        .destinations-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--control-panel-card-bg);
        }

        .destinations-table th,
        .destinations-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--control-panel-border);
        }

        .destinations-table th {
            background: var(--control-panel-bg);
            font-weight: 600;
            color: var(--control-panel-text);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .destinations-table tr:hover {
            background: var(--control-panel-hover-bg, rgba(0, 0, 0, 0.02));
        }

        .destination-info h4 {
            margin: 0 0 0.25rem 0;
            color: var(--control-panel-text);
            font-size: 1rem;
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
            font-size: 0.75rem;
            opacity: 0.7;
        }

        .destination-info p {
            margin: 0;
            color: var(--control-panel-text-muted);
            font-size: 0.85rem;
        }

        .destination-type {
            color: var(--control-panel-text-muted);
            font-size: 0.9rem;
        }

        .location-info {
            display: flex;
            flex-direction: column;
        }

        .location-info span {
            color: var(--control-panel-text);
            font-weight: 500;
        }

        .location-info small {
            color: var(--control-panel-text-muted);
            font-size: 0.8rem;
        }

        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-active {
            background: #10b981;
            color: white;
        }

        .status-inactive {
            background: #6b7280;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            text-decoration: none;
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

        @media (max-width: 768px) {
            .destinations-table {
                font-size: 0.85rem;
            }
            
            .destinations-table th,
            .destinations-table td {
                padding: 0.75rem 0.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }
        }
    </style>
</x-editor-layout>
