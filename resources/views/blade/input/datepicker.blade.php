@aware(['name'])

@props([
    'value' => null,
    'required' => false,
    'end_date' => null,
    'name' => null,
])

<!-- Datepicker -->
<div
     {{ $attributes->merge(['class' => 'input-group date']) }}
     data-provide="datepicker"
     data-date-today-highlight="true"
     data-date-language="{{ auth()->user()->locale }}"
     data-date-locale="{{ auth()->user()->locale }}"
     data-date-format="yyyy-mm-dd"
     data-date-autoclose="true"
     data-date-clear-btn="true"{{ $end_date ? ' data-date-end-date=' . $end_date : '' }}>

    <input
            type="text"
            name="{{ $name }}"
            placeholder="{{ trans('general.select_date') }}"
            value="{{ $value }}" maxlength="10"
            {{ $attributes->merge(['class' => 'form-control']) }}
            {{ $required ? ' required' : '' }}
    >
    <span class="input-group-addon"><x-icon type="calendar" /></span>

</div>