@props([
    'type' => 'text',
    'label' => null,
    'placeholder' => null,
    'value' => null,
    'name' => null,
    'required' => false,
])

<div class="mb-3">
    @if($label)
        <label class="form-label">{{ $label }}</label>
    @endif
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        value="{{ $value }}" 
        class="form-control" 
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        {{ $attributes }}
    >
</div>