<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="country">{{ __('state/state.form_country_name') }}</label>
            <select name="country_id" class="form-control" id="country_id">
                <option value="">{{ __('state/state.form_country_select') }}</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $model->country_id == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}</option>
                @endforeach
            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('country_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">{{ __('state/state.form_state_name') }}</label>
            <input type="text" id="basic-addon-name" name="name" class="form-control"
                placeholder="{{ __('state/state.form_state_name') }}"
                value="{{ isset($model->name) ? $model->name : old('name') }}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-code">{{ __('state/state.form_state_code') }}</label>
            <input type="text" id="basic-addon-code" name="code" class="form-control"
                placeholder="{{ __('state/state.form_state_code') }}"
                value="{{ isset($model->code) ? $model->code : old('code') }}" aria-describedby="basic-addon-code" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('code')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('state/state.form_status') }}</label>
            <select name="status" class="form-control" id="status">
                <option value="">{{ __('state/state.form_status_select') }}</option>
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
