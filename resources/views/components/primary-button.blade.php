<button {{ $attributes->merge(['type' => 'submit', 'class' => 'control-panel-button']) }}>
    {{ $slot }}
</button>
