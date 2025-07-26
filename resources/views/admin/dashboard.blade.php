
<x-control-panel-layout>
    <div class="control-panel-card welcome-card">
        <h2 class="control-panel-title">Bienvenid@, {{ Auth::user()->name }}</h2>
    </div>

    <div class="control-panel-card">
        <h2 class="control-panel-title">Reservas más recientes</h2>
        <table class="control-panel-table">
            <thead>
                <tr>
                    <th>Nombre del huésped</th>
                    <th>Correo electrónico</th>
                    <th>Fecha</th>
                    <th>Destino</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr id="reservation-row-{{ $reservation->id }}">
                        <td>{{ $reservation->name }}</td>
                        <td>{{ $reservation->email }}</td>
                        <td>{{ $reservation->date }}</td>
                        <td>{{ $reservation->destination ? $reservation->destination->title : '-' }}</td>
                        <td class="control-panel-actions-cell">
                            <button class="control-panel-button control-panel-button-danger reservation-delete-button" data-id="{{ $reservation->id }}">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="control-panel-text-muted">No se encontraron reservas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <nav role="navigation" aria-label="Pagination Navigation" class="pagination-nav control-panel-pagination">
            {{ $reservations->links() }}
        </nav>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.reservation-delete-button').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!confirm('Are you sure you want to delete this reservation?')) return;
                    var id = btn.getAttribute('data-id');
                    var row = document.getElementById('reservation-row-' + id);
                    fetch('/admin/reservations/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    })
                    .then(function(response) {
                        if (response.ok) {
                            row.remove();
                        } else {
                            alert('Failed to delete reservation.');
                        }
                    })
                    .catch(function() {
                        alert('Error deleting reservation.');
                    });
                });
            });
        });
        </script>
    </div>
</x-control-panel-layout>