@extends('layouts/edit-form', [
    'createText' => trans('admin/statuslabels/table.create') ,
    'updateText' => trans('admin/statuslabels/table.update'),
    'helpTitle' => trans('admin/statuslabels/table.about'),
    'helpText' => trans('admin/statuslabels/table.info'),
    'formAction' => (isset($item->id)) ? route('statuslabels.update', ['statuslabel' => $item->id]) : route('statuslabels.store'),
])

{{-- Page content --}}
@section('content')
<style>
    .input-group-addon {
        width: 30px;
    }
</style>

@parent
@stop

@section('inputFields')

    <!-- Name -->
    <x-form-row
            :label="trans('general.name')"
            :$item
            :$errors
            name="name"
    />

<!-- Label type -->
<div class="form-group{{ $errors->has('statuslabel_types') ? ' has-error' : '' }}">
    <label for="statuslabel_types" class="col-md-3 control-label">
        {{ trans('admin/statuslabels/table.status_type') }}
    </label>
    <div class="col-md-7 required">

        <x-input.select
            name="statuslabel_types"
            :options="$statuslabel_types"
            :selected="$item->getStatuslabelType()"
            style="width: 100%; min-width:400px"
            aria-label="statuslabel_types"
        />
        {!! $errors->first('statuslabel_types', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<!-- Chart color -->
<div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
    <label for="color" class="col-md-3 control-label">{{ trans('admin/statuslabels/table.color') }}</label>
    <div class="col-md-9">
        <div class="input-group color">
            <input class="form-control col-md-10" maxlength="20" name="color" type="text" id="color" value="{{ old('color', $item->color) }}">
            <div class="input-group-addon"><i></i></div>
        </div><!-- /.input group -->
        {!! $errors->first('color', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
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

<!-- Show in Nav -->
    <x-form-row-checkbox
            :label="trans('admin/statuslabels/table.show_in_nav')"
            :$item
            :$errors
            :value_text="trans('general.yes')"
            name="show_in_nav"
            checkbox_value="1"
    />

<!-- Set as Default -->
    <x-form-row-checkbox
            :label="trans('admin/statuslabels/table.default_label')"
            :$item
            :$errors
            :value_text="trans('general.yes')"
            name="default_label"
            checkbox_value="1"
            help_text="{!! trans('admin/statuslabels/table.default_label_help') !!}"
    />

@stop

@section('moar_scripts')
    <!-- bootstrap color picker -->
    <script nonce="{{ csrf_token() }}">

        $(function() {
            $('.color').colorpicker({
                color: `{{ old('color', $item->color) ?: '#AA3399' }}`,
                format: 'hex'
            });
        });

    </script>

@stop
