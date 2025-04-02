<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Create New User</h2>

        <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="control-panel-label">Name</label>
                <input id="name" name="name" type="text" class="control-panel-input" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="control-panel-label">Email</label>
                <input id="email" name="email" type="email" class="control-panel-input" value="{{ old('email') }}" required>
                @error('email')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="control-panel-label">Password</label>
                <input id="password" name="password" type="password" class="control-panel-input" required>
                @error('password')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="control-panel-label">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="control-panel-input" required>
            </div>

            <div>
                <label for="role" class="control-panel-label">Role</label>
                <select id="role" name="role" class="control-panel-select" required>
                    <option value="regular" {{ old('role') === 'regular' ? 'selected' : '' }}>Regular User</option>
                    <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="control-panel-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('users.index') }}" class="control-panel-button-secondary mr-3">
                    Cancel
                </a>
                <button type="submit" class="control-panel-button">
                    Create User
                </button>
            </div>
        </form>
    </div>
</x-control-panel-layout> 