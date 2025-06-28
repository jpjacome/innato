<!-- File removed: index.blade.php (maintenance log system is deprecated and removed) -->
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
                                    <button type="submit" class="control-panel-button control-panel-button-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
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