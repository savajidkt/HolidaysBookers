<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-property_name">{{ __('propertytype/propertytype.form_property_name') }}</label>
            <input type="text" id="basic-addon-property_name" name="property_name" class="form-control"
                placeholder="{{ __('propertytype/propertytype.form_property_name') }}"
                value="{{ isset($model->property_name) ? $model->property_name : old('property_name') }}"
                aria-describedby="basic-addon-property_name" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('property_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('propertytype/propertytype.form_status') }}</label>
            <select name="status" class="form-control" id="status">
                <option value="">{{ __('propertytype/propertytype.form_select_status') }}</option>
                <option value="1" {{ $model->status == 1 ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ $model->status == 0 ? 'selected' : '' }}> {{ __('core.inactive') }}</option>

            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
@endsection
