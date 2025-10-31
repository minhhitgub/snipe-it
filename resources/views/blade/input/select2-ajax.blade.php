@aware(['name'])

@props([
    'selected' => null,
    'forLivewire' => false,
    'data_endpoint' => false,
    'data_placeholder' => false,
    'multiple' => false,
    'item_model' => null,
    'name' => null,
])

@if (!$selected)
    @php
        $selected = old($name);
    @endphp
@endif


<select
        {{ ($multiple == 'true')? ' multiple' : '' }}
        {{ $attributes->class(['js-data-ajax select2', 'livewire-select2' => $forLivewire])->style(['width:100%']) }}
        @if($forLivewire) data-livewire-component="{{ $this->getId() }}" @endif
        data-endpoint="{{ $data_endpoint }}"
        data-placeholder="{{ $data_placeholder }}"
        name="{{ $name }}"
>
    @if ($selected)

        @if (is_integer($selected))
            <option value="{{ $selected }}" selected="selected" role="option" aria-selected="true">
                {{ $item_model::find($selected) ? $item_model::find($selected)->display_name : '' }}
            </option>
         @else
            @foreach ($selected as $key => $id)
                <option value="{{ $id }}" selected="selected" role="option" aria-selected="true">
                    {{ $item_model::find($id) ? $item_model::find($id)->display_name : '' }}
                </option>
            @endforeach
        @endif
    @endif

</select>
