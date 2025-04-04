@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'control-panel-status-message']) }}>
        {{ $status }}
    </div>
@endif
