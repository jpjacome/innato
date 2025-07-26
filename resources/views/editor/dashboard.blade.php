<x-editor-layout>
    <div class="control-panel-card welcome-card">
        <h2 class="control-panel-title">Bienvenido, {{ Auth::user()->name }}</h2>
    </div>

    <!-- Destinations Overview -->
    <div class="control-panel-card">
        <h3 class="control-panel-subtitle">
            <i class="fas fa-list"></i>
            Tus Destinos
        </h3>
        @if($destinations->count() > 0)
            <div class="destinations-table-container">
                <table class="destinations-table">
                    <thead>
                        <tr>
                            <th>Destino</th>
                            <th>Tipo</th>
                            <th>Ubicación</th>
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
                                            <i class="fas fa-external-link-alt"></i> Ver página pública
                                        </a>
                                        <a href="{{ route('editor.destinations.edit', $destination) }}" 
                                           class="control-panel-button control-panel-button-primary btn-sm">
                                            <i class="fas fa-edit"></i> Editar
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
                <h4>No se encontraron destinos</h4>
                <p>No hay destinos disponibles para editar en este momento.</p>
            </div>
        @endif
    </div>

    <!-- Latest Reservations Overview -->
    <div class="control-panel-card">
        <h3 class="control-panel-subtitle dashboard-subtitle">
            <i class="fas fa-calendar-check"></i>
            Últimas Reservas
        </h3>
        @if(isset($reservations) && $reservations->count() > 0)
            <table class="control-panel-table">
                <thead>
                    <tr>
                        <th>Nombre del huésped</th>
                        <th>Email</th>
                        <th>Fecha</th>
                        <th>Destino</th>
                        <th>Personas</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->name }}</td>
                            <td>{{ $reservation->email }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->destination ? $reservation->destination->title : '-' }}</td>
                            <td>{{ $reservation->people_count }}</td>
                            <td>{{ $reservation->phone_number }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <nav role="navigation" aria-label="Pagination Navigation" class="pagination-nav control-panel-pagination">
                {{ $reservations->links() }}
            </nav>
        @else
            <div class="empty-state">
                <i class="fas fa-calendar-times fa-2x"></i>
                <h4>No se encontraron reservas</h4>
                <p>No hay reservas para tus destinos aún.</p>
            </div>
        @endif
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</x-editor-layout>
