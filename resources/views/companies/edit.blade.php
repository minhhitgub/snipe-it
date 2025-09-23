@extends('layouts/edit-form', [
    'createText' => trans('admin/companies/table.create') ,
    'updateText' => trans('admin/companies/table.update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.companies'),
    'formAction' => (isset($item->id)) ? route('companies.update', ['company' => $item->id]) : route('companies.store'),
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

    <!-- Phone -->
    <x-form-row
            :label="trans('general.phone')"
            :$item
            :$errors
            name="phone"
            type="tel"
    />

    <!-- Fax -->
    <x-form-row
            :label="trans('general.fax')"
            :$item
            :$errors
            name="fax"
            type="tel"
    />

    <!-- Email -->
    <x-form-row
            :label="trans('general.email')"
            :$item
            :$errors
            name="fax"
            type="email"
    />


@include ('partials.forms.edit.image-upload', ['image_path' => app('companies_upload_path')])

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
