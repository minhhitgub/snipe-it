@props([
    'item' => null,
    'field_name' => null,
    'input_style' => null,
    'required' => false,
])
<!-- input-text blade component -->
<input
    {{ $attributes->merge(['class' => 'form-control', 'style' => $input_style]) }}
    @required($required)
/>
