@props([
    'name' => null,
])

<!-- form-row blade component -->
<div {{ $attributes->merge(['name' => $name]) }} class="form-group @error($name) has-error @enderror">
    {{ $slot }}
</div>

