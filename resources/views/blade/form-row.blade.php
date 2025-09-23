<!-- form-row blade component -->
@props([
    'errors',
    'label',
    'name' => null,
    'help_text' => null,
    'label_style' => null,
    'label_class' => 'col-md-3 col-sm-12 col-xs-12',
    'div_style' => null,
    'input_div_class' => 'col-md-8 col-sm-12',
    'input_style' => null,
    'item' => null,
    'type' => 'text',
    'placeholder' => null,
    'maxlength' => 191,
    'minlength' => null,
    'min' => null,
    'max' => null,
    'step' => null,
    'disabled' => false,
    'error_offset_class' => 'col-md-7 col-md-offset-3',
    'info_tooltip_text' => null,
])

<div {{ $attributes->merge(['class' => 'form-group']) }}>

    <x-form-label
            :$label
            :for="$name"
            :style="$label_style ?? null"
            class="{{ $label_class }}"
    />

    <div {{ $attributes->merge(['class' => $input_div_class]) }} {{ ($div_style) ? $attributes->merge(['style' => $div_style]):'' }}>

        @php
            $blade_type = in_array($type, ['text', 'email', 'url', 'tel', 'number', 'password']) ? 'text' : $type;
        @endphp

        <x-dynamic-component
                :component="'input.'.$blade_type"
                :aria-label="$name"
                :$name
                :$placeholder
                :$input_style
                :$item
                :id="$name"
                :required="Helper::checkIfRequired($item, $name)"
                :value="old($name, $item->{$name})"
                :$type
                :$maxlength
                :$minlength
                :$disabled
                :$min
                :$max
                :$step
        />
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
