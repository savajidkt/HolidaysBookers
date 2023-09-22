<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-amenity_name">{{ __('amenity/amenity.form_amenity_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-amenity_name" name="amenity_name" class="form-control"
                placeholder="{{ __('amenity/amenity.form_amenity_name') }}"
                value="{{ isset($model->amenity_name) ? $model->amenity_name : old('amenity_name') }}"
                aria-describedby="basic-addon-amenity_name"
                data-error="{{ __('amenity/message.amenity_name_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('amenity_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="type">{{ __('amenity/amenity.form_amenity_type') }} <span class="text-danger">*</span></label>
            <select name="type" class="form-control" id="type"
                data-error="{{ __('amenity/message.amenity_type_required') }}">
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
            <label class="form-label" for="status">{{ __('amenity/amenity.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="form-control" id="status"
                data-error="{{ __('amenity/message.status_required') }}">
                <option value="">{{ __('amenity/amenity.form_select_status') }}</option>
                <option value="1" {{ (isset($model->id) && $model->status == 1) ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ (isset($model->id) && $model->status == 0) ? 'selected' : '' }}> {{ __('core.inactive') }}</option>
            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('js/form/Amenity.js') }}"></script>
@endsection
