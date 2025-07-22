@props([
    'destinations' => [],
    'selectedDestinationId' => null
])
<form method="POST" action="{{ route('reservation.store') }}" class="control-panel-form" @submit.prevent="
    $store.reservation.sending = true;
    $store.reservation.errorMsg = '';
    $store.reservation.confirmed = false;
    const form = $el;
    const data = new FormData(form);
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: data
    })
    .then(response => response.json())
    .then(json => {
        if (json.success) {
            $store.reservation.confirmed = true;
        } else if (json.errors) {
            $store.reservation.errorMsg = Object.values(json.errors).flat().join(' ');
        } else {
            $store.reservation.errorMsg = json.message || 'Error al enviar la reserva.';
        }
    })
    .catch(() => {
        $store.reservation.errorMsg = 'Error de red. Intenta de nuevo.';
    })
    .finally(() => {
        $store.reservation.sending = false;
    });
">
    @csrf
    <div class="control-panel-form-group">
        <label for="name" class="control-panel-label">Name</label>
        <input type="text" name="name" id="name" class="control-panel-input" value="{{ old('name') }}" required>
        @error('name')<div class="control-panel-input-error">{{ $message }}</div>@enderror
    </div>
    <div class="control-panel-form-group">
        <label for="email" class="control-panel-label">Email</label>
        <input type="email" name="email" id="email" class="control-panel-input" value="{{ old('email') }}" required>
        @error('email')<div class="control-panel-input-error">{{ $message }}</div>@enderror
    </div>
    <div class="control-panel-form-group">
        <label for="destination_id" class="control-panel-label">Destination</label>
        <select name="destination_id" id="destination-id" class="control-panel-select" required>
            <option value="">Select destination</option>
            @foreach($destinations as $dest)
                @if(is_object($dest) && property_exists($dest, 'id'))
                    <option value="{{ $dest->id }}" {{ ($selectedDestinationId == $dest->id) ? 'selected' : (old('destination_id') == $dest->id ? 'selected' : '') }}>{{ $dest->name }}</option>
                @else
                    <option value="" disabled>{{ $dest }}</option>
                @endif
            @endforeach
        </select>
        @error('destination_id')<div class="control-panel-input-error">{{ $message }}</div>@enderror
    </div>
    <div class="control-panel-form-group">
        <label for="people_count" class="control-panel-label">Number of People</label>
        <input type="number" name="people_count" id="people_count" class="control-panel-input" min="1" value="{{ old('people_count') }}" required>
        @error('people_count')<div class="control-panel-input-error">{{ $message }}</div>@enderror
    </div>
    <div class="control-panel-form-group">
        <label for="date" class="control-panel-label">Date</label>
        <input type="date" name="date" id="date" class="control-panel-input" value="{{ old('date') }}" required>
        @error('date')<div class="control-panel-input-error">{{ $message }}</div>@enderror
    </div>
    <div class="control-panel-form-group">
        <label for="phone_number" class="control-panel-label">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" class="control-panel-input" value="{{ old('phone_number') }}" required>
        @error('phone_number')<div class="control-panel-input-error">{{ $message }}</div>@enderror
    </div>
    <div class="control-panel-form-group">
        <button type="submit" class="control-panel-button">Reserve</button>
    </div>
</form>