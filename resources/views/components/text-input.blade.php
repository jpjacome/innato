@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'control-panel-input']) }}>
