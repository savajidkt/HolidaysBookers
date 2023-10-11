<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-code">{{ __('agent-markup/agent-markup.form_agent_markup_code') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-code" name="code" class="form-control"
                placeholder="{{ __('agent-markup/agent-markup.form_agent_markup_code') }}" oninput="this.value = this.value.replace(/[^0-9a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');"
                value="{{ isset($model->code) ? $model->code : old('code') }}" aria-describedby="basic-addon-code"
                data-error="{{ __('agent-markup/message.product_markup_code_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('code')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-rezlive">{{ __('agent-markup/agent-markup.form_agent_markup_rezlive_markup') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-rezlive" name="rezlive" class="form-control"
                placeholder="{{ __('agent-markup/agent-markup.form_agent_markup_rezlive_markup') }}"
                value="{{ isset($model->rezlive) ? $model->rezlive : old('rezlive') }}"
                aria-describedby="basic-addon-rezlive"
                data-error="{{ __('agent-markup/message.product_markup_rezlive_markup_required') }}" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')"/>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('rezlive')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-offline_hotel">{{ __('agent-markup/agent-markup.form_agent_markup_offline_hotel_markup') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-offline_hotel" name="offline_hotel" class="form-control"
                placeholder="{{ __('agent-markup/agent-markup.form_agent_markup_offline_hotel_markup') }}"
                value="{{ isset($model->offline_hotel) ? $model->offline_hotel : old('offline_hotel') }}"
                aria-describedby="basic-addon-offline_hotel"
                data-error="{{ __('agent-markup/message.product_markup_offline_hotel_markup_required') }}" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')"/>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('offline_hotel')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-sightseeing">{{ __('agent-markup/agent-markup.form_agent_markup_sightseeing_markup') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-sightseeing" name="sightseeing" class="form-control"
                placeholder="{{ __('agent-markup/agent-markup.form_agent_markup_sightseeing_markup') }}"
                value="{{ isset($model->sightseeing) ? $model->sightseeing : old('sightseeing') }}"
                aria-describedby="basic-addon-sightseeing"
                data-error="{{ __('agent-markup/message.product_markup_sightseeing_required') }}" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')"/>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('sightseeing')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-transfer">{{ __('agent-markup/agent-markup.form_agent_markup_transfer_markup') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-transfer" name="transfer" class="form-control"
                placeholder="{{ __('agent-markup/agent-markup.form_agent_markup_transfer_markup') }}"
                value="{{ isset($model->transfer) ? $model->transfer : old('transfer') }}"
                aria-describedby="basic-addon-transfer"
                data-error="{{ __('agent-markup/message.product_markup_transfer_required') }}" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')"/>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('transfer')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-package">{{ __('agent-markup/agent-markup.form_agent_markup_package_markup') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-package" name="package" class="form-control"
                placeholder="{{ __('agent-markup/agent-markup.form_agent_markup_package_markup') }}"
                value="{{ isset($model->package) ? $model->package : old('package') }}"
                aria-describedby="basic-addon-package"
                data-error="{{ __('agent-markup/message.product_markup_package_required') }}" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')"/>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('package')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('agent-markup/agent-markup.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control" id="status" data-minimum-results-for-search="Infinity"
                data-error="{{ __('agent-markup/message.status_required') }}">
                <option value="">{{ __('agent-markup/agent-markup.form_select_status') }}</option>
                <option value="1" {{ $model->status == 1 ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ $model->status == 0 ? 'selected' : '' }}> {{ __('core.inactive') }}
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
    <script src="{{ asset('js/form/Agent-Markup.js') }}"></script>
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
