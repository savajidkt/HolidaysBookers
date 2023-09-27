<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-vehicle_name">{{ __('vehicletype/vehicletype.form_vehicle_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-vehicle_name" name="vehicle_name" class="form-control"
                placeholder="{{ __('vehicletype/vehicletype.form_vehicle_name') }}" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                value="{{ isset($model->vehicle_name) ? $model->vehicle_name : old('vehicle_name') }}"
                aria-describedby="basic-addon-vehicle_name" data-error="{{ __('vehicletype/message.vehicle_name_required') }}"/>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('vehicle_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-no_of_seats">{{ __('vehicletype/vehicletype.form_vehicle_no_of_seats') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-no_of_seats" name="no_of_seats" class="form-control"
                placeholder="{{ __('vehicletype/vehicletype.form_vehicle_no_of_seats') }}" oninput="this.value = this.value.replace(/[^0-9]+/g, '').replace(/(\..*)\./g, '$1');"
                value="{{ isset($model->no_of_seats) ? $model->no_of_seats : old('no_of_seats') }}"
                aria-describedby="basic-addon-no_of_seats" data-error="{{ __('vehicletype/message.no_of_seats_required') }}" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')"/>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('no_of_seats')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('vehicletype/vehicletype.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control" id="status" data-minimum-results-for-search="Infinity" {{ __('vehicletype/message.status_required') }}>
                <option value="">{{ __('vehicletype/vehicletype.form_select_status') }}</option>
                <option value="1" {{ (isset($model->id) && $model->status == 1) ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ (isset($model->id) && $model->status == 0) ? 'selected' : '' }}> {{ __('core.inactive') }}</option>

            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            <span id="status_id"></span>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
<script>
    $('.select2').select2();
</script>
<script src="{{ asset('js/form/Vehicle-Type.js') }}"></script>
<script>
    $('#status').on('change', function() {
        var selected_option_value = $(this).find(":selected").val();
        if (selected_option_value == '') {
            $('#status-error').show();
            $('#status').addClass('error');
        } else {
            $('#status-error').hide();
            $('#status').removeClass('error');
        }
    });
</script>
@endsection
