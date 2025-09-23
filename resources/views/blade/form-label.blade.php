<!-- form-label blade component -->
@props([
    'label',
])

<label {{ $attributes->merge(['class' => 'control-label']) }}>
    {{ $label }}
</label>

