<x-editor-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Editar Perfil</h2>

        <form action="{{ route('editor.users.update', $user) }}" method="POST" class="control-panel-form">
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
                <label class="control-panel-label" for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" class="control-panel-input" required>
                @error('email')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Editors cannot change their role --}}
            <div class="control-panel-form-group">
                <label class="control-panel-label" for="role">Rol</label>
                <input type="text" name="role" id="role" value="{{ ucfirst($user->role) }}" class="control-panel-input" readonly>
            </div>

            <div class="control-panel-form-group">
                <label class="control-panel-label" for="password">Nueva Contraseña (dejar en blanco para mantener la actual)</label>
                <input type="password" name="password" id="password" class="control-panel-input">
                <p class="text-white opacity-75 text-sm mt-1">Solo llena esto si quieres cambiar la contraseña.</p>
                @error('password')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="control-panel-form-group">
                <label class="control-panel-label" for="password_confirmation">Confirmar Nueva Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="control-panel-input">
                <p class="text-white opacity-75 text-sm mt-1">Debe coincidir con la nueva contraseña si deseas cambiarla.</p>
            </div>

            <div class="control-panel-actions">
                <button type="submit" class="control-panel-button">Actualizar Perfil</button>
                <a href="{{ route('editor.users.index') }}" class="control-panel-button control-panel-button-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-editor-layout>
