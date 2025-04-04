@props(['value'])

<label {{ $attributes->merge(['class' => 'control-panel-label']) }}>
    {{ $value ?? $slot }}
</label>
