<x-form-row
        :label="trans('general.address')"
        :$item
        :$errors
        name="address"
/>

<x-form-row
        :label="trans('general.address')"
        :$item
        :$errors
        name="address2"
/>

<x-form-row
        :label="trans('general.city')"
        :$item
        :$errors
        name="city"
/>

<x-form-row
        :label="trans('general.state')"
        :$item
        :$errors
        name="state"
        
/>

<div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
    <label for="country" class="col-md-3 control-label">{{ trans('general.country') }}</label>
    <div class="col-md-7">
    {!! Form::countries('country', old('country', $item->country), 'select2') !!}
        <p class="help-block">{{ trans('general.countries_manually_entered_help') }}</p>
        {!! $errors->first('country', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<x-form-row
        :label="trans('general.zip')"
        :$item
        :$errors
        name="zip"
        maxlength="10"
        input_div_class="col-md-3"
/>
