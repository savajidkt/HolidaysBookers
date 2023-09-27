<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">{{ __('hotel-group/hotel-group.form_hotel_group') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-name" name="group_name" class="form-control"
                placeholder="{{ __('hotel-group/hotel-group.form_hotel_group') }}" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                value="{{ isset($model->name) ? $model->name : old('group_name') }}" aria-describedby="basic-addon-name"
                data-error="{{ __('hotel-group/message.hotel_group_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('group_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('hotel-group/hotel-group.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control"  id="status" data-minimum-results-for-search="Infinity"
                data-error="{{ __('hotel-group/message.status_required') }}">
                <option value="">{{ __('hotel-group/hotel-group.form_select_status') }}</option>
                <option value="1" {{ (isset($model->id) && $model->status == 1) ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ (isset($model->id) && $model->status == 0 )? 'selected' : '' }}> {{ __('core.inactive') }}</option>
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
    <script src="{{ asset('js/form/Hotel-Group.js') }}"></script>
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
