@props([
    'item' => null,
    'field_name' => null,
    'input_style' => null,
])
<!-- input-text blade component -->
<input {{ $attributes->merge(['class' => 'form-control']) }} />
