@props([
    'name',
    'label',
    'type' => 'text',
    'id' => null,
    'value' => '',
    'required' => false,
    'placeholder' => ' '
])

<div class="relative w-full group">
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $id ?? $name }}" 
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'peer w-full px-4 pt-5 pb-2 text-sm bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary placeholder-transparent transition-all'
        ]) }}
    />
    <label 
        for="{{ $id ?? $name }}" 
        class="absolute left-4 top-2.5 text-[10px] text-base-content/50 font-extrabold uppercase tracking-wider transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-placeholder-shown:font-medium peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-focus:top-2.5 peer-focus:text-[10px] peer-focus:text-primary peer-focus:font-extrabold peer-focus:uppercase peer-focus:tracking-wider pointer-events-none"
    >
        {{ $label }}
        @if($required)
            <span class="text-error">*</span>
        @endif
    </label>
</div>
