<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">{{ __('country/country.form_country_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-name" name="name" class="form-control"
                placeholder="{{ __('country/country.form_country_name') }}"
                value="{{ isset($model->name) ? $model->name : old('name') }}" aria-describedby="basic-addon-name"
                data-error="{{ __('country/message.country_name_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-code">{{ __('country/country.form_country_code') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-code" name="code" class="form-control"
                placeholder="{{ __('country/country.form_country_code') }}"
                value="{{ isset($model->code) ? $model->code : old('code') }}" aria-describedby="basic-addon-code"
                data-error="{{ __('country/message.country_code_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('code')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-phone_code">{{ __('country/country.form_country_phone_code') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-phone_code" name="phone_code" class="form-control"
                placeholder="{{ __('country/country.form_country_phone_code') }}"
                value="{{ isset($model->phone_code) ? $model->phone_code : old('phone_code') }}"
                aria-describedby="basic-addon-phone_code"
                data-error="{{ __('country/message.country_phone_code_required') }}" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')"/>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('phone_code')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-nationality">{{ __('country/country.form_nationality') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-nationality" name="nationality" class="form-control"
                placeholder="{{ __('country/country.form_nationality') }}"
                value="{{ isset($model->nationality) ? $model->nationality : old('nationality') }}"
                aria-describedby="basic-addon-nationality"
                data-error="{{ __('country/message.country_nationality_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('nationality')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('country/country.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control" id="status" data-minimum-results-for-search="Infinity"
                data-error="{{ __('country/message.status_required') }}">
                <option value="">{{ __('country/country.form_select_status') }}</option>
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
    <script src="{{ asset('js/form/Country.js') }}"></script>
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
