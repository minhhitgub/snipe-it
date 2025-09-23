@props([
    'item' => null,
    'field_name' => null,
    'input_style' => null,
    'required' => null,
])
<!-- input-text blade component -->
<input {{ $attributes->merge(['class' => 'form-control']) }} {{ ($input_style) ? $attributes->merge(['style' => $input_style]): '' }} {{ ($required ?? false) ? 'required' : '' }} />
