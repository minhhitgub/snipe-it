<!-- form-row blade component -->
@props([
    'errors',
    'label',
    'field_name',
    'help_text' => null,
    'label_style' => null,
    'label_class' => 'control-label col-md-3 col-sm-12 col-xs-12',
    'div_style' => null,
    'input_style' => null,
    'item' => null,
    'type' => null,
])

<div class="form-group{{ $errors->has($field_name) ? ' has-error' : '' }}">
    <label for="{{ $field_name }}"{{ $attributes->merge(['class' => $label_class]) }}{{ $label_style ? $attributes->merge(['style' => $label_style]) : '' }}>
        {{ $label }}
    </label>
    <div {{ $attributes->merge(['class' => 'col-md-8 col-sm-12', 'style' => $div_style]) }}>
        <x-input.text
                :aria-label="$field_name"
                :name="$field_name"
                :item="$item ?? null"
                :id="$field_name"
                :required="Helper::checkIfRequired($item, $field_name)"
                :style="$input_style"
                :value="old($field_name, $item->{$field_name})"
                :type="$type ?? 'text'"
        />

        {!! $errors->first($field_name, '<span class="alert-msg"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}

        @if ($help_text)
            <p class="help-block">
                {!! $help_text !!}
            </p>
       @endif
    </div>
</div>
