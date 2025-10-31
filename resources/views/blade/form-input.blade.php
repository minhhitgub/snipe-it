@aware(['name'])

@props([
    'class' => 'col-md-8',
])


<!-- form-input blade component -->
<div {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</div>


@error($name)
<div class="col-md-8 col-md-offset-3">
        <span class="alert-msg" aria-hidden="true">
            <x-icon type="x" />
            {{ $message }}
        </span>
</div>
@enderror
