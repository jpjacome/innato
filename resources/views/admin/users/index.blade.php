<x-control-panel-layout>
    <div class="control-panel-card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="control-panel-title">User Management</h2>
            <a href="{{ route('users.create') }}" class="control-panel-button">
                Create New User
            </a>
        </div>
        
        <table class="control-panel-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
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
                        <td>
                            <form action="{{ route('users.update', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="role" class="control-panel-select" onchange="this.form.submit()">
                                    <option value="admin" {{ ($user->role === 'admin' || $user->is_admin) ? 'selected' : '' }}>Admin</option>
                                    <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                                    <option value="regular" {{ $user->role === 'regular' && !$user->is_admin ? 'selected' : '' }}>Regular</option>
                                </select>
                            </form>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
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