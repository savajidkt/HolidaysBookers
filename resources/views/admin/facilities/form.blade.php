<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Name <span class="text-danger">*</span></label>
            <input type="hidden" name="facility_id" value="{{ $facility_id }}">
            <input type="text" id="basic-addon-name" name="name" class="form-control"
                placeholder="Sub facility name" 
                onkeydown="return /[a-zA-Z ]/.test(event.key)" 
                oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);"
                value="{{ isset($model->name) ? $model->name : old('name') }}"
                aria-describedby="basic-addon-name"
                data-error="Sub facility name is required." />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">Status <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control" id="status" data-minimum-results-for-search="Infinity" data-error="Status is required">
                <option value="">Select Status</option>
                <option value="1" {{ (isset($model->id) && $model->status == 1) ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ (isset($model->id) && $model->status == 0) ? 'selected' : '' }}> {{ __('core.inactive') }}
                </option>
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
    <script src="{{ asset('js/form/HotelFacility.js') }}"></script>
    <script>
        $('#type').on('change', function() {
            var selected_option_value = $(this).find(":selected").val();
            if (selected_option_value == '') {
                $('#type-error').show();
                $('#type').addClass('error');
            } else {
                $('#type-error').hide();
                $('#type').removeClass('error');
            }
        }); 

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
