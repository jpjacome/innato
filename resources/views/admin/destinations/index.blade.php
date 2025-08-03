<x-control-panel-layout>
    <div class="control-panel-card edit-destinations-card">
        <div class="page-header">
            <h2 class="control-panel-title">
                <i class="fas fa-map-marker-alt"></i>
                Admin - Gestionar todos los destinos
            </h2>
            <p class="control-panel-subtitle">Ver y editar todos los destinos con sus editores asignados</p>

            
            <div class="add-destination-btn-wrapper">
                <button type="button" class="control-panel-button control-panel-button-primary" id="addDestinationBtn">
                    <i class="fas fa-plus"></i> Agregar destino
                </button>
            </div>
            <!-- Add Destination Modal -->
            <div id="addDestinationModal" class="modal" style="display:none;">
                <div class="modal-content">
                    <button type="button" id="closeModalBtn" class="modal-close-btn">&times;</button>
                    <h3 class="modal-title">Crear nuevo destino</h3>
                    <form id="createDestinationForm">
                        <div class="modal-form-group">
                            <label for="destinationName">Nombre del destino</label>
                            <input type="text" id="destinationName" name="destinationName" class="form-control" required>
                        </div>
                        <div class="modal-form-group">
                            <label for="editorSelect">Asignar editor</label>
                            <select id="editorSelect" name="editorSelect" class="form-control" required>
                                <option value="">Selecciona un editor...</option>
                                <!-- Editor options will be populated by backend -->
                            </select>
                        </div>
                        <div class="modal-form-group">
                            <label for="destinationSlug">Slug del destino</label>
                            <div class="modal-url-preview">
                                URL: <span>/destino/</span><span id="slugPreview"></span>
                            </div>
                            <input type="text" id="destinationSlug" name="destinationSlug" class="form-control" required placeholder="ej. playa-libertador">
                        </div>
                        <div class="modal-form-group">
                            <label for="destinationRegion">Región</label>
                            <select id="destinationRegion" name="destinationRegion" class="form-control" required>
                                <option value="">Selecciona una región...</option>
                                <!-- Regions will be loaded dynamically -->
                            </select>
                        </div>
                        <button type="submit" class="control-panel-button control-panel-button-primary">Crear destino</button>
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
                select.innerHTML = '<option value="">Selecciona un editor...</option>';
                data.forEach(function(editor) {
                    var option = document.createElement('option');
                    option.value = editor.id;
                    option.textContent = editor.name + ' (' + editor.email + ')';
                    select.appendChild(option);
                });
            })
            .catch(() => {
                var select = document.getElementById('editorSelect');
                select.innerHTML = '<option value="">No se pudieron cargar los editores</option>';
            });
        // Fetch regions for dropdown
        fetch('/admin/regions-list')
            .then(response => response.json())
            .then(data => {
                var regionSelect = document.getElementById('destinationRegion');
                regionSelect.innerHTML = '<option value="">Selecciona una región...</option>';
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
                alert('¡Destino creado exitosamente!');
                window.location.reload();
            } else {
                alert('Error al crear el destino.');
            }
        })
        .catch(() => {
            alert('Error creating destination.');
        });
    };
    // Delete destination handler
    document.querySelectorAll('.delete-destination-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que deseas eliminar este destino?')) {
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
                        alert('¡Destino eliminado exitosamente!');
                        window.location.reload();
                    } else {
                        alert('Error al eliminar el destino.');
                    }
                })
                .catch(() => {
                    alert('Error al eliminar el destino.');
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
                        delBtn.textContent = 'Eliminar';
                        delBtn.className = 'control-panel-button control-panel-button-secondary region-delete-button';
                        delBtn.style.marginLeft = '1rem';
                        delBtn.onclick = function() {
                        if (confirm('¿Eliminar la región "' + region + '"?')) {
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
                            <th>Destino</th>
                            <th>Ubicación</th>
                            <th>Editor asignado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
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
                                            <span class="no-editor">Sin editor asignado</span>
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
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <a href="{{ route('admin.destinations.edit', $destination) }}" 
                                           class="control-panel-button control-panel-button-primary btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <button class="control-panel-button control-panel-button-danger btn-sm delete-destination-btn" data-id="{{ $destination->id }}">
                                            <i class="fas fa-trash"></i> Eliminar
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
                <h4>No se encontraron destinos</h4>
                <p>No hay destinos en el sistema en este momento.</p>
            </div>
        @endif
    </div>

    <!-- Custom Styles for Admin Destinations Table -->

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</x-control-panel-layout>
