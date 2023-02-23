<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-vehicle_name">{{ __('vehicletype/vehicletype.form_vehicle_name') }}</label>
            <input type="text" id="basic-addon-vehicle_name" name="vehicle_name" class="form-control"
                placeholder="{{ __('vehicletype/vehicletype.form_vehicle_name') }}"
                value="{{ isset($model->vehicle_name) ? $model->vehicle_name : old('vehicle_name') }}"
                aria-describedby="basic-addon-vehicle_name" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('vehicle_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-no_of_seats">{{ __('vehicletype/vehicletype.form_vehicle_no_of_seats') }}</label>
            <input type="text" id="basic-addon-no_of_seats" name="no_of_seats" class="form-control"
                placeholder="{{ __('vehicletype/vehicletype.form_vehicle_no_of_seats') }}"
                value="{{ isset($model->no_of_seats) ? $model->no_of_seats : old('no_of_seats') }}"
                aria-describedby="basic-addon-no_of_seats" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('no_of_seats')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('vehicletype/vehicletype.form_status') }}</label>
            <select name="status" class="form-control" id="status">
                <option value="">{{ __('vehicletype/vehicletype.form_select_status') }}</option>
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
