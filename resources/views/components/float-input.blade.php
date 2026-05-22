@props([
    'name',
    'label',
    'type' => 'text',
    'id' => null,
    'value' => '',
    'required' => false,
    'placeholder' => null
])

@php
    $resolvedPlaceholder = $placeholder ?? $label;
@endphp

<label 
    {{ $attributes->merge([
        'class' => 'floating-label w-full block'
    ]) }}
>
    <span>
        {{ $label }}
        @if($required)
            <span class="text-error font-extrabold">*</span>
        @endif
    </span>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $id ?? $name }}" 
        value="{{ old($name, $value) }}"
        placeholder="{{ $resolvedPlaceholder }}"
        {{ $required ? 'required' : '' }}
        class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all"
    />
</label>
