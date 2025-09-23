@extends('layouts/edit-form', [
    'createText' => trans('admin/licenses/form.create'),
    'updateText' => trans('admin/licenses/form.update'),
    'topSubmit' => true,
    'formAction' => ($item->id) ? route('licenses.update', ['license' => $item->id]) : route('licenses.store'),
     'index_route' => 'licenses.index',
    'options' => [
                'back' => trans('admin/hardware/form.redirect_to_type',['type' => trans('general.previous_page')]),
                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'licenses']),
                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.license')]),
               ]
])

{{-- Page content --}}
@section('inputFields')


    <!-- Name -->
    <x-form-row
            :label="trans('general.name')"
            :$item
            :$errors
            name="name"
    />

    @include ('partials.forms.edit.category-select', ['translated_name' => trans('admin/categories/general.category_name'), 'fieldname' => 'category_id', 'required' => 'true', 'category_type' => 'license'])


    <!-- Seats -->
    <x-form-row
            :label="trans('admin/licenses/form.seats')"
            :$item
            :$errors
            name="seats"
            input_div_class="col-md-2"
            minlength="1"
            maxlength="10000"
            type="number"
    />

    <!-- Min Seats -->
    <x-form-row
            :label="trans('general.min_amt')"
            :$item
            :$errors
            name="seats"
            input_div_class="col-md-2"
            minlength="1"
            maxlength="5"
            type="number"
            :info_tooltip_text="trans('general.min_amt_help')"
    />

    <!-- Product Key -->
    @can('viewKeys', $item)
        <x-form-row
                :label="trans('admin/licenses/form.license_key')"
                :$item
                :$errors
                name="serial"
                type="textarea"
                maxlength="65000"
        />
    @endcan


@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id',])

   <!-- Licensed to name -->
    <x-form-row
            :label="trans('admin/licenses/form.to_name')"
            :$item
            :$errors
            name="license_name"
    />

    <!-- Licensed to email -->
    <x-form-row
            :label="trans('admin/licenses/form.to_email')"
            :$item
            :$errors
            name="license_email"
            type="email"
    />

<!-- Reassignable -->
<div class="form-group {{ $errors->has('reassignable') ? ' has-error' : '' }}">
    <div class="col-md-3 control-label">
        <strong>{{ trans('admin/licenses/form.reassignable') }}</strong>
    </div>
    <div class="col-md-7">
        <label class="form-control">
            <input type="checkbox" name="reassignable" value="1" aria-label="reassignable" @checked(old('reassignable', $item->id ? $item->reassignable : '1'))>
        {{ trans('general.yes') }}
        </label>
    </div>
</div>


@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])

    <!-- Order number -->
    <x-form-row
            :label="trans('general.order_number')"
            :$item
            :$errors
            name="order_number"
            input_div_class="col-md-5 col-sm-12"
    />

    <!-- Purchase Order  -->
    <x-form-row
            :label="trans('admin/licenses/form.purchase_order')"
            :$item
            :$errors
            name="purchase_order"
            input_div_class="col-md-5 col-sm-12"
    />

    <!-- Purchase cost -->
    <x-form-row
            :label="trans('general.purchase_cost')"
            :$item
            :$errors
            name="purchase_cost"
            type="number"
            maxlength="25"
            min="0.00"
            max="99999999999999999.000"
            step="0.001"
            input_div_class="col-md-4 col-sm-12"
    />


    <!-- Purchase date -->
    <x-form-row
            :label="trans('general.purchase_date')"
            :$item
            :$errors
            name="purchase_date"
            type="date"
            input_div_class="col-md-4 col-sm-12"
            :value="old('purchase_date', (($item->purchase_date && $item->purchase_date->format('Y-m-d')) ?? ''))"
    />


    <!-- Expiration Date -->
    <x-form-row
            :label="trans('admin/licenses/form.expiration')"
            :$item
            :$errors
            name="expiration_date"
            type="date"
            input_div_class="col-md-4 col-sm-12"
            :value="old('expiration_date', (($item->expiration_date && $item->expiration_date->format('Y-m-d')) ?? ''))"
    />


<!-- Termination Date -->
    <x-form-row
            :label="trans('admin/licenses/form.termination_date')"
            :$item
            :$errors
            name="termination_date"
            type="date"
            input_div_class="col-md-4 col-sm-12"
            :value="old('termination_date', (($item->termination_date && $item->termination_date->format('Y-m-d')) ?? ''))"
    />


@include ('partials.forms.edit.depreciation')

<!-- Maintained -->
<div class="form-group {{ $errors->has('maintained') ? ' has-error' : '' }}">
    <div class="col-md-3 control-label"><strong>{{ trans('admin/licenses/form.maintained') }}</strong></div>
    <div class="col-md-7">
        <label class="form-control">
            <input type="checkbox" name="maintained" value="1" aria-label="maintained" @checked(old('maintained', $item->maintained))>
        {{ trans('general.yes') }}
        </label>
    </div>
</div>

    <!-- Notes -->
    <x-form-row
            :label="trans('general.notes')"
            :$item
            :$errors
            name="notes"
            type="textarea"
            maxlength="65000"
            placeholder="{{ trans('general.placeholders.notes') }}"
    />

@stop
