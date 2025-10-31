@aware(['name'])

@props([
'name' => null,
'input_group_addon' => false,
'input_icon' => false,
'input_group_text' => false,
'required' => false,
])
<!-- input-text blade component -->
@if ($input_group_addon)
        <div class="input-group">
@endif

    <input
        {{ $attributes->merge(['class' => 'form-control']) }}
        name="{{ $name }}"
        @required($required)
    />

@if ($input_group_addon)
    <span class="input-group-addon">
        @if ($input_icon)
            <x-icon :type="$input_icon" />
        @elseif ($input_group_text)
            {{ $input_group_text }}
        @endif
    </span>
</div>
@endif

