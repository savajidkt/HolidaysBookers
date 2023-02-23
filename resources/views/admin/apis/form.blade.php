<div class="row">

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">{{ __('api/api.form_api_name') }}</label>
            <input type="text" id="basic-addon-name" name="name" class="form-control"
                placeholder="{{ __('api/api.form_api_name') }}"
                value="{{ isset($model->name) ? $model->name : old('name') }}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-api_url">{{ __('api/api.form_api_url') }}</label>
            <input type="text" id="basic-addon-api_url" name="api_url" class="form-control"
                placeholder="{{ __('api/api.form_api_url') }}"
                value="{{ isset($model->api_url) ? $model->api_url : old('api_url') }}"
                aria-describedby="basic-addon-api_url" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('api_url')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('api/api.form_status') }}</label>
            <select name="status" class="form-control" id="status">
                <option value="">{{ __('api/api.form_select_status') }}</option>
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
