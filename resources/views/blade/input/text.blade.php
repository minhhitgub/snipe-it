@props([
    'input_style' => null,
    'input_group_addon' => null,
    'required' => false,
    'item' => null,
])
<!-- input-text blade component -->
<input
    {{ $attributes->merge(['class' => 'form-control', 'style' => $input_style]) }}
    @required($required)
/>

@if ($input_group_addon)
    <span class="input-group-addon">{{ $input_group_addon }}</span>
@endif
