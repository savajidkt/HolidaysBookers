<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-code">{{ __('agent-markup/agent-markup.form_agent_markup_code') }}</label>
            <input type="text" id="basic-addon-code" name="code" class="form-control"
                placeholder="{{ __('agent-markup/agent-markup.form_agent_markup_code') }}"
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
                for="basic-addon-rezlive">{{ __('agent-markup/agent-markup.form_agent_markup_rezlive_markup') }}</label>
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
                for="basic-addon-offline_hotel">{{ __('agent-markup/agent-markup.form_agent_markup_offline_hotel_markup') }}</label>
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
                for="basic-addon-sightseeing">{{ __('agent-markup/agent-markup.form_agent_markup_sightseeing_markup') }}</label>
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
                for="basic-addon-transfer">{{ __('agent-markup/agent-markup.form_agent_markup_transfer_markup') }}</label>
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
                for="basic-addon-package">{{ __('agent-markup/agent-markup.form_agent_markup_package_markup') }}</label>
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
            <label class="form-label" for="role">{{ __('agent-markup/agent-markup.form_status') }}</label>
            <select name="status" class="form-control" id="status"
                data-error="{{ __('agent-markup/message.status_required') }}">
                <option value="">{{ __('agent-markup/agent-markup.form_select_status') }}</option>
                <option value="1" {{ $model->status == 1 ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ $model->status == 0 ? 'selected' : '' }}> {{ __('core.inactive') }}
                </option>

            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('js/form/Agent-Markup.js') }}"></script>
@endsection
