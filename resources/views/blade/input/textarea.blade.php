@aware(['name'])
@props([
    'value' => null,
    'rows' => 5,
])

<textarea
    {{ $attributes->merge(['class' => 'form-control']) }}
    rows="{{ $rows }}"
    name="{{ $name }}"
>{{ $value }}</textarea>
