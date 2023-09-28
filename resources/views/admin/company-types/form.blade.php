<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-name">{{ __('company-type/company-type.form_company_type') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-name" name="company_type" class="form-control"
                placeholder="{{ __('company-type/company-type.form_company_type') }}" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                value="{{ isset($model->company_type) ? $model->company_type : old('company_type') }}"
                aria-describedby="basic-addon-name"
                data-error="{{ __('company-type/message.company_type_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('company_type')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('company-type/company-type.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control" id="status" data-minimum-results-for-search="Infinity"
                data-error="{{ __('company-type/message.status_required') }}">
                <option value="">{{ __('company-type/company-type.form_select_status') }}</option>
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
    <script src="{{ asset('js/form/Company-Type.js') }}"></script>
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
