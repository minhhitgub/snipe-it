<!-- form-row blade component -->
@props([
    'errors',
    'label' => null,
    'name' => null,
    'help_text' => null,
    'label_style' => null,
    'label_class' => 'col-md-3 col-sm-12 col-xs-12',
    'input_div_class' => 'col-md-8 col-sm-12',
    'type' => 'checkbox',
    'item' => null,
    'disabled' => false,
    'error_offset_class' => 'col-md-7 col-md-offset-3',
    'info_tooltip_text' => null,
    'value_text' => null,
    'checkbox_value' => null,
])

<div {{ $attributes->merge(['class' => 'form-group']) }}>

    <x-form-label
            :label="$label ?? null"
            :style="$label_style ?? null"
            class="{{ $label_class }}"
    />

    <div {{ $attributes->merge(['class' => $input_div_class]) }}>

        <label class="form-control{{ $disabled ? ' form-control--disabled' : ''  }}">
            <input type="checkbox" name="{{ $name }}" aria-label="{{ $name }}" value="{{ $checkbox_value }}" @checked(old($name, $item->$name)) {!! $disabled ? 'class="disabled" disabled' : ''  !!}>
            {{ $value_text ?? $label }}
        </label>

    </div>




    @if ($info_tooltip_text)
        <!-- Info Tooltip -->
        <div class="col-md-1 text-left" style="padding-left:0; margin-top: 5px;">
            <x-input.info-tooltip>
                {{ $info_tooltip_text }}
            </x-input.info-tooltip>
        </div>
    @endif


    @error($name)
    <!-- Form Error -->
    <div {{ $attributes->merge(['class' => $error_offset_class]) }}>
                <span class="alert-msg" role="alert">
                    <i class="fas fa-times" aria-hidden="true"></i>
                    {{ $message }}
                </span>
    </div>
    @enderror

    @if ($help_text)
        <!-- Help Text -->
        <div {{ $attributes->merge(['class' => $error_offset_class]) }}>
            <p class="help-block">
                {!! $help_text !!}
            </p>
        </div>
    @endif

</div>
