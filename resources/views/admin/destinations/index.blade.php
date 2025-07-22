<x-control-panel-layout>
    <div class="control-panel-card">
        <div class="page-header" style="margin-bottom: 0;">
            <h2 class="control-panel-title">
                <i class="fas fa-map-marker-alt"></i>
                Admin - Manage All Destinations
            </h2>
            <p class="control-panel-subtitle">View and edit all destinations with their assigned editors</p>

            <div class="control-panel-card regions-container">
                <h3 class="control-panel-subtitle"><i class="fas fa-globe"></i> Manage Regions</h3>
                <div id="regionsManager">
                    <ul id="regionsList" style="margin-bottom:1rem;">
                        <!-- Regions will be loaded here -->
                    </ul>
                    <input type="text" id="newRegionInput" placeholder="Add new region..." style="padding:0.5rem; border:1px solid #ccc; border-radius:4px; margin-right:0.5rem;">
                    <button type="button" id="addRegionBtn" class="control-panel-button control-panel-button-primary">Add Region</button>
                </div>
            </div>
            <div style="margin-top: 1rem;">
                <button type="button" class="control-panel-button control-panel-button-primary" id="addDestinationBtn">
                    <i class="fas fa-plus"></i> Add Destination
                </button>
            </div>
            <!-- Add Destination Modal -->
            <div id="addDestinationModal" class="modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); justify-content:center; align-items:center;">
                <div class="modal-content" style="background:#fff; padding:2rem; border-radius:8px; min-width:320px; max-width:90vw; box-shadow:0 2px 16px rgba(0,0,0,0.2); position:relative;">
                    <button type="button" id="closeModalBtn" style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
                    <h3 style="margin-bottom:1rem;">Create New Destination</h3>
                    <form id="createDestinationForm">
                        <div style="margin-bottom:1rem;">
                            <label for="destinationName" style="display:block; margin-bottom:0.5rem;">Destination Name</label>
                            <input type="text" id="destinationName" name="destinationName" class="form-control" required style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:4px;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="editorSelect" style="display:block; margin-bottom:0.5rem;">Assign Editor</label>
                            <select id="editorSelect" name="editorSelect" class="form-control" required style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:4px;">
                                <option value="">Select an editor...</option>
                                <!-- Editor options will be populated by backend -->
                            </select>
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="destinationSlug" style="display:block; margin-bottom:0.5rem;">Destination Slug</label>
                            <div style="font-size:0.9rem; color:#888; margin-bottom:0.25rem;">
                                URL: <span>/destination/</span><span id="slugPreview" style="font-weight:600;"></span>
                            </div>
                            <input type="text" id="destinationSlug" name="destinationSlug" class="form-control" required style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:4px;" placeholder="e.g. playa-libertador">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="destinationRegion" style="display:block; margin-bottom:0.5rem;">Region</label>
                            <select id="destinationRegion" name="destinationRegion" class="form-control" required style="width:100%; padding:0.5rem; border:1px solid #ccc; border-radius:4px;">
                                <option value="">Select a region...</option>
                                <!-- Regions will be loaded dynamically -->
                            </select>
                        </div>
                        <button type="submit" class="control-panel-button control-panel-button-primary">Create Destination</button>
                    </form>
                </div>
            </div>
            <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addDestinationBtn').onclick = function() {
        document.getElementById('addDestinationModal').style.display = 'flex';
        // Fetch editors when modal opens
        fetch('/admin/editors-list')
            .then(response => response.json())
            .then(data => {
                var select = document.getElementById('editorSelect');
                select.innerHTML = '<option value="">Select an editor...</option>';
                data.forEach(function(editor) {
                    var option = document.createElement('option');
                    option.value = editor.id;
                    option.textContent = editor.name + ' (' + editor.email + ')';
                    select.appendChild(option);
                });
            })
            .catch(() => {
                var select = document.getElementById('editorSelect');
                select.innerHTML = '<option value="">Could not load editors</option>';
            });
        // Fetch regions for dropdown
        fetch('/admin/regions-list')
            .then(response => response.json())
            .then(data => {
                var regionSelect = document.getElementById('destinationRegion');
                regionSelect.innerHTML = '<option value="">Select a region...</option>';
                data.forEach(function(region) {
                    var option = document.createElement('option');
                    option.value = region;
                    option.textContent = region;
                    regionSelect.appendChild(option);
                });
            });
        // Reset slug preview
        document.getElementById('slugPreview').textContent = '';
        document.getElementById('destinationSlug').value = '';
    };
    // Update slug preview as admin types
    document.getElementById('destinationSlug').addEventListener('input', function() {
        document.getElementById('slugPreview').textContent = this.value;
    });
    document.getElementById('closeModalBtn').onclick = function() {
        document.getElementById('addDestinationModal').style.display = 'none';
    };
    // AJAX form submission for creating a destination
    document.getElementById('createDestinationForm').onsubmit = function(e) {
        e.preventDefault();
        var form = e.target;
        var data = {
            destinationName: form.destinationName.value,
            editorSelect: form.editorSelect.value,
            destinationSlug: form.destinationSlug.value,
            destinationRegion: form.destinationRegion.value
        };
        fetch('/admin/destinations/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Destination created successfully!');
                window.location.reload();
            } else {
                alert('Error creating destination.');
            }
        })
        .catch(() => {
            alert('Error creating destination.');
        });
    };
    // Delete destination handler
    document.querySelectorAll('.delete-destination-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this destination?')) {
                var id = btn.getAttribute('data-id');
                fetch('/admin/destinations/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Destination deleted successfully!');
                        window.location.reload();
                    } else {
                        alert('Error deleting destination.');
                    }
                })
                .catch(() => {
                    alert('Error deleting destination.');
                });
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
        function loadRegions() {
            fetch('/admin/regions-list')
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById('regionsList');
                    list.innerHTML = '';
                    data.forEach(function(region, idx) {
                        const li = document.createElement('li');
                        li.textContent = region;
                        li.style.display = 'flex';
                        li.style.alignItems = 'center';
                        li.style.marginBottom = '0.5rem';
                        const delBtn = document.createElement('button');
                        delBtn.textContent = 'Delete';
                        delBtn.className = 'control-panel-button control-panel-button-secondary region-delete-button';
                        delBtn.style.marginLeft = '1rem';
                        delBtn.onclick = function() {
                            if (confirm('Delete region "' + region + '"?')) {
                                fetch('/admin/regions-delete', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({ region: region })
                                })
                                .then(() => loadRegions());
                            }
                        };
                        li.appendChild(delBtn);
                        list.appendChild(li);
                    });
                });
        }
        document.getElementById('addRegionBtn').onclick = function() {
            const val = document.getElementById('newRegionInput').value.trim();
            if (!val) return;
            fetch('/admin/regions-add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ region: val })
            }).then(() => {
                document.getElementById('newRegionInput').value = '';
                loadRegions();
            });
        };
        loadRegions();
    });
            </script>
            </div>
        </div>
        
        @if($destinations->count() > 0)
            <div class="destinations-table-container">
                <table class="destinations-table">
                    <thead>
                        <tr>
                            <th>Destination</th>
                            <th>Location</th>
                            <th>Assigned Editor</th>
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
                                    <div class="location-info">
                                        <span>{{ $destination->province }}</span>
                                        <small>{{ $destination->canton }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="editor-info">
                                        @if($destination->assignedEditor)
                                            <span class="editor-name">{{ $destination->assignedEditor->name }}</span>
                                            <small class="editor-email">{{ $destination->assignedEditor->email }}</small>
                                        @else
                                            <span class="no-editor">No editor assigned</span>
                                        @endif
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
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('admin.destinations.edit', $destination) }}" 
                                           class="control-panel-button control-panel-button-primary btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button class="control-panel-button control-panel-button-danger btn-sm delete-destination-btn" data-id="{{ $destination->id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
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
                <p>There are no destinations in the system at the moment.</p>
            </div>
        @endif
    </div>

    <!-- Custom Styles for Admin Destinations Table -->
    <style>
        .page-header {
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--control-panel-border);
        }

        
    </style>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</x-control-panel-layout>
