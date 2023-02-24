<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-name">{{ __('company-type/company-type.form_company_type') }}</label>
            <input type="text" id="basic-addon-name" name="company_type" class="form-control"
                placeholder="{{ __('company-type/company-type.form_company_type') }}"
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
            <label class="form-label" for="role">{{ __('company-type/company-type.form_status') }}</label>
            <select name="status" class="form-control" id="status"
                data-error="{{ __('company-type/message.status_required') }}">
                <option value="">{{ __('company-type/company-type.form_select_status') }}</option>
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
    <script src="{{ asset('js/form/Company-Type.js') }}"></script>
@endsection
