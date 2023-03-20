<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">CURRENCY DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-5">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Currency</label>
            <input type="text" id="basic-addon-name" name="name" class="form-control" placeholder="Currency name"
                value="{{ isset($model->name) ? $model->name : old('name') }}"
                aria-describedby="basic-addon-name" data-error="Currency name is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-5">
        <div class="form-group">
            <label class="form-label" for="basic-addon-code">Currency Code</label>
            <input type="text" id="basic-addon-code" name="code" class="form-control" placeholder="Currency code"
                value="{{ isset($model->code) ? $model->code : old('code') }}"
                aria-describedby="basic-addon-code" data-error="Currency code is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('code')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="role">Status</label>
            <select name="status" class="form-control" id="status" data-error="Status is required">
                <option value="">Select Status</option>
                <option value="1" {{ isset($model->id) && $model->status == 1 ? 'selected' : '' }}>
                    {{ __('core.active') }}</option>
                <option value="0" {{ isset($model->id) && $model->status == 0 ? 'selected' : '' }}>
                    {{ __('core.inactive') }}
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
    <script src="{{ asset('js/form/Currency.js') }}"></script>
@endsection
