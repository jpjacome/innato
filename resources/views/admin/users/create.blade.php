<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Crear Nuevo Usuario</h2>

        <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="control-panel-label">Nombre</label>
                <input id="name" name="name" type="text" class="control-panel-input" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="control-panel-label">Correo electrónico</label>
                <input id="email" name="email" type="email" class="control-panel-input" value="{{ old('email') }}" required>
                @error('email')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="control-panel-label">Contraseña</label>
                <input id="password" name="password" type="password" class="control-panel-input" required>
                @error('password')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="control-panel-label">Confirmar Contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="control-panel-input" required>
            </div>

            <div>
                <label for="role" class="control-panel-label">Rol</label>
                <select id="role" name="role" class="control-panel-select" required>
                    <option value="regular" {{ old('role') === 'regular' ? 'selected' : '' }}>Usuario Regular</option>
                    <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('role')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('users.index') }}" class="control-panel-button-secondary mr-3">
                    Cancelar
                </a>
                <button type="submit" class="control-panel-button">
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
</x-control-panel-layout> 