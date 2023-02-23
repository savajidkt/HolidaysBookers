<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-amenity_name">{{ __('amenity/amenity.form_amenity_name') }}</label>
            <input type="text" id="basic-addon-amenity_name" name="amenity_name" class="form-control"
                placeholder="{{ __('amenity/amenity.form_amenity_name') }}"
                value="{{ isset($model->amenity_name) ? $model->amenity_name : old('amenity_name') }}"
                aria-describedby="basic-addon-amenity_name" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('amenity_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="type">{{ __('amenity/amenity.form_amenity_type') }}</label>
            <select name="type" class="form-control" id="type">
                <option value="">{{ __('amenity/amenity.form_select_type') }}</option>
                <option value="1" {{ $model->type == 1 ? 'selected' : '' }}>
                    {{ __('amenity/amenity.form_type_hotel') }}</option>
                <option value="2" {{ $model->type == 2 ? 'selected' : '' }}>
                    {{ __('amenity/amenity.form_type_room') }}</option>
            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('type')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="status">{{ __('amenity/amenity.form_status') }}</label>
            <select name="status" class="form-control" id="status">
                <option value="">{{ __('amenity/amenity.form_select_status') }}</option>
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
