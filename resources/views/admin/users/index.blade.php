<x-control-panel-layout>
    <div class="control-panel-card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="control-panel-title">Gestión de Usuarios</h2>
            <a href="{{ route('users.create') }}" class="control-panel-button create-user-button">
                Crear Nuevo Usuario
            </a>
        </div>
        
        <table class="control-panel-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin' || $user->is_admin)
                                <span class="control-panel-badge">Administrador</span>
                            @elseif($user->role === 'editor')
                                <span class="control-panel-badge control-panel-badge-editor">Editor</span>
                            @else
                                <span class="control-panel-badge control-panel-badge-regular">Regular</span>
                            @endif
                        </td>
                        <td class="control-panel-actions-cell">
                            <a href="{{ route('users.edit', $user) }}" class="control-panel-button control-panel-button-secondary ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline ml-2" onsubmit="return confirm('¿Está seguro de que desea eliminar este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="control-panel-button control-panel-button-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-control-panel-layout> 