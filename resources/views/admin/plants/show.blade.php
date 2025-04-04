<x-control-panel-layout>
    <div class="control-panel-card">
        <div class="flex">
            <h2 class="control-panel-title">{{ $plant->name }}</h2>
            <div>
                <a href="{{ route('admin.plants.index') }}" class="control-panel-button">
                    Back to Plants
                </a>
                <a href="{{ route('admin.plants.edit', $plant->id) }}" class="control-panel-button">
                    Edit Plant
                </a>
                <a href="{{ route('admin.maintenance.create', ['plant_id' => $plant->id]) }}" class="control-panel-button control-panel-button-secondary">
                    Add Maintenance Log
                </a>
                <a href="{{ route('public.plants.show', $plant->id) }}" class="control-panel-button control-panel-button-secondary" target="_blank" title="View public page">
                    <i class="fas fa-globe"></i> View Public Page
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="control-panel-alert control-panel-alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Plant Images -->
        @if($plant->images->isNotEmpty())
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Plant Images</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                    @foreach($plant->images as $image)
                        <div style="position: relative; width: 150px; height: 150px;">
                            <img src="{{ $image->image_path }}" alt="{{ $plant->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            <form action="{{ route('admin.plants.images.destroy', ['plant' => $plant->id, 'image' => $image->id]) }}" method="POST" style="position: absolute; top: 5px; right: 5px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="control-panel-button control-panel-button-danger" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" onclick="return confirm('Are you sure you want to delete this image?');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Plant Information -->
        <div class="control-panel-card">
            <h3 class="control-panel-subtitle">Plant Information</h3>
            <div class="control-panel-grid">
                <div>
                    <p><strong>Common Names:</strong> {{ $plant->common_names ?? 'Not specified' }}</p>
                    <p><strong>Family:</strong> {{ $plant->family ?? 'Not specified' }}</p>
                    <p><strong>Native Range:</strong> {{ $plant->native_range ?? 'Not specified' }}</p>
                    <p><strong>Age:</strong> {{ $plant->age ?? 'Not specified' }}</p>
                </div>
                <div>
                    <p><strong>Current Height:</strong> {{ $plant->current_height ?? 'Not specified' }}</p>
                    <p><strong>Expected Height:</strong> {{ $plant->expected_height ?? 'Not specified' }}</p>
                    <p><strong>Leaf Type:</strong> {{ $plant->leaf_type ?? 'Not specified' }}</p>
                    <p><strong>Bloom Time:</strong> {{ $plant->bloom_time ?? 'Not specified' }}</p>
                </div>
                <div>
                    <p><strong>Flower Color:</strong> {{ $plant->flower_color ?? 'Not specified' }}</p>
                    <p><strong>Fruit:</strong> {{ $plant->fruit ?? 'Not specified' }}</p>
                    <p><strong>Light:</strong> {{ $plant->light ?? 'Not specified' }}</p>
                    <p><strong>Soil:</strong> {{ $plant->soil ?? 'Not specified' }}</p>
                    <p><strong>Hardiness:</strong> {{ $plant->hardiness ?? 'Not specified' }}</p>
                </div>
            </div>
            @if($plant->other_comments)
                <div style="margin-top: 1rem;">
                    <strong>Other Comments:</strong>
                    <p>{{ $plant->other_comments }}</p>
                </div>
            @endif
        </div>

        <!-- Maintenance Logs -->
        <div class="control-panel-card">
            <div class="flex">
                <h3 class="control-panel-subtitle">Maintenance Logs</h3>
                <a href="{{ route('admin.maintenance.create', ['plant_id' => $plant->id]) }}" class="control-panel-button control-panel-button-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">
                    <i class="fas fa-plus"></i> Add Log
                </a>
            </div>

            @if($maintenanceLogs->isEmpty())
                <p>No maintenance logs found for this plant.</p>
            @else
                <div class="control-panel-table-container">
                    <table class="control-panel-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Last Watering</th>
                                <th>Next Watering</th>
                                <th>Last Fertilization</th>
                                <th>Last Pruning</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenanceLogs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('M d, Y') }}</td>
                                    <td>{{ $log->last_watering ? $log->last_watering->format('M d, Y') : 'Not set' }}</td>
                                    <td>{{ $log->next_watering ? $log->next_watering->format('M d, Y') : 'Not scheduled' }}</td>
                                    <td>{{ $log->last_fertilization ? $log->last_fertilization->format('M d, Y') : 'Not set' }}</td>
                                    <td>{{ $log->last_pruning ? $log->last_pruning->format('M d, Y') : 'Not set' }}</td>
                                    <td class="control-panel-actions-cell">
                                        <a href="{{ route('admin.maintenance.show', $log->id) }}" class="control-panel-button" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">View</a>
                                        <a href="{{ route('admin.maintenance.edit', $log->id) }}" class="control-panel-button" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 1rem;">
                    {{ $maintenanceLogs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-control-panel-layout> 