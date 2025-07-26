<x-editor-layout>
    <div class="control-panel-card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="control-panel-title">Mi Perfil</h2>
            {{-- Editors cannot create new users --}}
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
                                <span class="control-panel-badge">Admin</span>
                            @elseif($user->role === 'editor')
                                <span class="control-panel-badge control-panel-badge-editor">Editor</span>
                            @else
                                <span class="control-panel-badge control-panel-badge-regular">Regular</span>
                            @endif
                        </td>
                        <td class="control-panel-actions-cell">
                            <a href="{{ route('editor.users.edit', $user) }}" class="control-panel-button control-panel-button-secondary ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="control-panel-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            {{-- Editors cannot delete users --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-editor-layout>
