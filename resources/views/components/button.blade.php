@props([
    'type' => 'button',
    'label',
    'style' => 'primary',
    'attributes' => []
])

@php
    $classes = $style === 'primary'
        ? 'btn btn-primary'
        : ($style === 'secondary' ? 'btn btn-outline-secondary' : 'btn');
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $label }}
</button>