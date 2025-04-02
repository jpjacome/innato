<x-control-panel-layout>
    <div class="card">
        <h1 class="text-2xl font-bold mb-4">Control Panel Settings</h1>
        
        <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="form-group">
                    <label for="primary_color" class="form-label">Primary Color</label>
                    <input type="color" name="primary_color" id="primary_color" 
                           value="{{ $settings->primary_color ?? '#4F46E5' }}" 
                           class="form-input h-10">
                </div>
                
                <div class="form-group">
                    <label for="secondary_color" class="form-label">Secondary Color</label>
                    <input type="color" name="secondary_color" id="secondary_color" 
                           value="{{ $settings->secondary_color ?? '#818CF8' }}" 
                           class="form-input h-10">
                </div>
                
                <div class="form-group">
                    <label for="accent_color" class="form-label">Accent Color</label>
                    <input type="color" name="accent_color" id="accent_color" 
                           value="{{ $settings->accent_color ?? '#6366f1' }}" 
                           class="form-input h-10">
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="submit-button">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-control-panel-layout> 