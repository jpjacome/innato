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
</x-editor-layout>
