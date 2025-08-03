<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Editar Usuario</h2>
        
        <form action="{{ route('users.update', $user) }}" method="POST" class="control-panel-form">
            @csrf
            @method('PUT')
            
            <div class="control-panel-form-group">
                <label class="control-panel-label" for="name">Nombre</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="control-panel-input" required>
                @error('name')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="control-panel-form-group">
                <label class="control-panel-label" for="email">Correo electrónico</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" class="control-panel-input" required>
                @error('email')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="control-panel-form-group">
                <label class="control-panel-label" for="role">Rol</label>
                <select name="role" id="role" class="control-panel-select" required>
                    <option value="admin" {{ ($user->role === 'admin' || $user->is_admin) ? 'selected' : '' }}>Administrador</option>
                    <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="regular" {{ $user->role === 'regular' && !$user->is_admin ? 'selected' : '' }}>Regular</option>
                </select>
                @error('role')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="control-panel-form-group">
                <label class="control-panel-label" for="password">Contraseña (dejar en blanco para mantener la actual)</label>
                <input type="password" name="password" id="password" class="control-panel-input">
                <p class="text-white opacity-75 text-sm mt-1">Complete esto solo si desea cambiar la contraseña.</p>
                @error('password')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="control-panel-form-group">
                <label class="control-panel-label" for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="control-panel-input">
            </div>
            
            <div class="control-panel-actions">
                <button type="submit" class="control-panel-button">Actualizar Usuario</button>
                <a href="{{ route('users.index') }}" class="control-panel-button control-panel-button-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-control-panel-layout> 