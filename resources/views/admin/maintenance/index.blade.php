<x-control-panel-layout>
    <div class="control-panel-card">
        <div class="flex">
            <h2 class="control-panel-title">
                @isset($plant)
                    {{ __('Maintenance Logs for') }} {{ $plant->name }}
                @else
                    {{ __('All Maintenance Logs') }}
                @endisset
            </h2>
            <a href="{{ route('admin.maintenance.create', isset($plant) ? ['plant_id' => $plant->id] : []) }}" class="control-panel-button">
                Add New Log
            </a>
        </div>

        @if(session('success'))
            <div class="control-panel-alert control-panel-alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="control-panel-table-container">
            <table class="control-panel-table">
                <thead>
                    <tr>
                        <th>Plant</th>
                        <th>Last Watering</th>
                        <th>Next Watering</th>
                        <th>Last Pruning</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenanceLogs as $log)
                        <tr>
                            <td>
                                <a href="{{ route('admin.plants.show', $log->plant_id) }}" class="control-panel-link">
                                    {{ $log->plant->name }}
                                </a>
                            </td>
                            <td>{{ $log->last_watering ? $log->last_watering->format('M d, Y') : 'Not set' }}</td>
                            <td>{{ $log->next_watering ? $log->next_watering->format('M d, Y') : 'Not scheduled' }}</td>
                            <td>{{ $log->last_pruning ? $log->last_pruning->format('M d, Y') : 'Not set' }}</td>
                            <td>
                                @if($log->images->isNotEmpty())
                                    <div style="display: flex; gap: 0.5rem;">
                                        @foreach($log->images->take(3) as $image)
                                            <img src="{{ $image->image_path }}" alt="Maintenance Image" style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%;">
                                        @endforeach
                                        @if($log->images->count() > 3)
                                            <span style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background-color: var(--accent-color); border-radius: 50%; color: var(--text); font-size: 0.75rem;">
                                                +{{ $log->images->count() - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span style="color: var(--accent-color);">No images</span>
                                @endif
                            </td>
                            <td class="control-panel-actions-cell">
                                <a href="{{ route('admin.maintenance.show', $log->id) }}" class="control-panel-button">View</a>
                                <a href="{{ route('admin.maintenance.edit', $log->id) }}" class="control-panel-button">Edit</a>
                                <form action="{{ route('admin.maintenance.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this maintenance log?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="control-panel-button control-panel-button-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">
                                No maintenance logs found. 
                                <a href="{{ route('admin.maintenance.create', isset($plant) ? ['plant_id' => $plant->id] : []) }}" class="control-panel-link">
                                    Add your first maintenance log
                                </a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1rem;">
            {{ $maintenanceLogs->links() }}
        </div>
    </div>
</x-control-panel-layout> 