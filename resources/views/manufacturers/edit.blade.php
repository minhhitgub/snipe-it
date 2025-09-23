@extends('layouts/edit-form', [
    'createText' => trans('admin/manufacturers/table.create') ,
    'updateText' => trans('admin/manufacturers/table.update'),
    'helpTitle' => trans('admin/manufacturers/table.about_manufacturers_title'),
    'helpText' => trans('admin/manufacturers/table.about_manufacturers_text'),
    'formAction' => (isset($item->id)) ? route('manufacturers.update', ['manufacturer' => $item->id]) : route('manufacturers.store'),
])


{{-- Page content --}}
@section('inputFields')

    <!-- Name -->
    <x-form-row
            :label="trans('admin/manufacturers/table.name')"
            :$item
            :errors="$errors ?? null"
            name="name"
    />

    <!-- URL -->
    <x-form-row
            :label="trans('general.url')"
            :$item
            :errors="$errors ?? null"
            name="url"
            type="url"
    />

    <!-- Support URL -->
    <x-form-row
            :label="trans('admin/manufacturers/table.support_url')"
            :$item
            :errors="$errors ?? null"
            name="support_url"
            type="url"
    />

    <!-- Warranty Lookup URL -->
    <x-form-row
            :label="trans('admin/manufacturers/table.warranty_lookup_url')"
            :$item
            :errors="$errors ?? null"
            help_text="{!! trans('admin/manufacturers/message.support_url_help') !!}"
            name="warranty_lookup_url"
            type="url"
    />

    <!-- Support Phone -->
    <x-form-row
            :label="trans('admin/manufacturers/table.support_phone')"
            :$item
            :errors="$errors ?? null"
            name="support_phone"
            type="tel"
    />

    <!-- Support Email -->
    <x-form-row
            :label="trans('admin/manufacturers/table.support_email')"
            :$item
            :errors="$errors ?? null"
            name="support_email"
            type="email"
            input_div_class="col-md-6 col-sm-12 col-xs-12"
    />


    @include ('partials.forms.edit.image-upload', ['image_path' => app('manufacturers_upload_path')])

    <!-- Notes -->
    <x-form-row
            :label="trans('general.notes')"
            :$item
            :errors="$errors ?? null"
            name="notes"
            type="textarea"
    />


@stop
