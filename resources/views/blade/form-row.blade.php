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
            $type = in_array($type, ['text', 'email', 'url', 'tel', 'number', 'password']) ? 'text' : $type;
        @endphp

        <x-dynamic-component
                :component="'input.'.$type"
                :aria-label="$name"
                :$name
                :$placeholder
                :$input_style
                :$item
                :id="$name"
                :required="Helper::checkIfRequired($item, $name)"
                :value="old($name, $item->{$name})"
                :$type
        />

        @error($name)
            <span class="alert-msg" role="alert-msg">
                <i class="fas fa-times" aria-hidden="true"></i>
                {{ $message }}
            </span>
        @enderror

        @if ($help_text)
            <p class="help-block">
                {!! $help_text !!}
            </p>
       @endif
    </div>
</div>
