<x-control-panel-layout>
    <div class="control-panel-card">
        <div class="flex">
            <h2 class="control-panel-title">{{ __('Plants Management') }}</h2>
            <a href="{{ route('admin.plants.create') }}" class="control-panel-button">
                Add New Plant
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
                        <th>Family</th>
                        <th>Thumbnail</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plants as $plant)
                        <tr>
                            <td>
                                <div>{{ $plant->name }}</div>
                                <div style="font-size: 0.875rem; color: var(--accent-color);">{{ Str::limit($plant->common_names, 50) }}</div>
                            </td>
                            <td>
                                {{ $plant->family }}
                            </td>
                            <td>
                                @if($plant->images->isNotEmpty())
                                    <img src="{{ $plant->images->first()->image_path }}" alt="{{ $plant->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background-color: var(--accent-color); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-leaf" style="color: var(--text);"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="control-panel-actions-cell">
                                <a href="{{ route('admin.plants.show', $plant->id) }}" class="control-panel-button">View</a>
                                <a href="{{ route('admin.plants.edit', $plant->id) }}" class="control-panel-button">Edit</a>
                                <a href="{{ route('admin.maintenance.create', ['plant_id' => $plant->id]) }}" class="control-panel-button control-panel-button-secondary">Maintenance</a>
                                <a href="{{ route('public.plants.show', $plant->id) }}" class="control-panel-button control-panel-button-secondary" target="_blank" title="View public page">
                                    <i class="fas fa-globe"></i> Public
                                </a>
                                <form action="{{ route('admin.plants.destroy', $plant->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plant?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="control-panel-button control-panel-button-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">
                                No plants found. <a href="{{ route('admin.plants.create') }}" class="control-panel-link">Add your first plant</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1rem;">
            {{ $plants->links() }}
        </div>
    </div>
</x-control-panel-layout> 