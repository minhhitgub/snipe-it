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
            :item="$item"
            :errors="$errors ?? null"
            field_name="name"
            input_style="width: 50%"
            class="test"
            label_style="color: red"
    />

    <!-- URL -->
    <x-form-row
            :label="trans('general.url')"
            :item="$item"
            :errors="$errors ?? null"
            field_name="url"
            type="url"
    />

    <!-- Support URL -->
    <x-form-row
            :label="trans('admin/manufacturers/table.support_url')"
            :item="$item"
            :errors="$errors ?? null"
            field_name="support_url"
            type="url"
    />

    <!-- Warranty Lookup URL -->
    <x-form-row
            :label="trans('admin/manufacturers/table.warranty_lookup_url')"
            :item="$item"
            :errors="$errors ?? null"
            :help_text="trans('admin/manufacturers/message.support_url_help')"
            field_name="warranty_lookup_url"
            type="url"
    />

    <!-- Support Phone -->
    <x-form-row
            :label="trans('admin/manufacturers/table.support_phone')"
            :item="$item"
            :errors="$errors ?? null"
            field_name="support_phone"
            type="tel"
    />

    <!-- Support Email -->
    <x-form-row
            :label="trans('admin/manufacturers/table.support_email')"
            :item="$item"
            :errors="$errors ?? null"
            field_name="support_email"
            type="email"
    />


@include ('partials.forms.edit.image-upload', ['image_path' => app('manufacturers_upload_path')])

<div class="form-group{!! $errors->has('notes') ? ' has-error' : '' !!}">
    <label for="notes" class="col-md-3 control-label">{{ trans('general.notes') }}</label>
    <div class="col-md-8">
        <x-input.textarea
                name="notes"
                id="notes"
                :value="old('notes', $item->notes)"
                placeholder="{{ trans('general.placeholders.notes') }}"
                aria-label="notes"
                rows="5"
        />
        {!! $errors->first('notes', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>



@stop
