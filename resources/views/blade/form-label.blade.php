@aware(['name'])

<!-- form-label blade component -->
<label {{ $attributes->merge(['class' => 'control-label col-md-3']) }} for="{{ $name }}">
    {{ $slot }}
</label>