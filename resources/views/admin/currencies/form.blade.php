<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">CURRENCY DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-country">Country <span class="text-danger">*</span></label>

            <select name="country_id" class="select2 form-control" id="country_id" data-error="Country is required">
                <option value="">Select Status</option>
                @if ($countries)
                    @foreach ($countries as $key => $country)
                        <option value="{{ $country->id }}" {{ isset($model->country->id) &&  $country->id == $model->country->id ? 'selected' : '' }}>
                            {{ $country->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('country_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Currency Name <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-name" name="name" class="form-control" placeholder="Currency name"
                value="{{ isset($model->name) ? $model->name : old('name') }}"
                onkeydown="return /[a-zA-Z ]/.test(event.key)" aria-describedby="basic-addon-name"
                data-error="Currency name is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-code">Currency Code <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-code" name="code" class="form-control" placeholder="Currency code"
                value="{{ isset($model->code) ? $model->code : old('code') }}"
                onkeydown="return /[a-zA-Z ]/.test(event.key)" aria-describedby="basic-addon-code"
                data-error="Currency code is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('code')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-symbol">Currency Symbol <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-symbol" name="symbol" class="form-control"
                placeholder="Currency symbol" value="{{ isset($model->symbol) ? $model->symbol : old('symbol') }}"
                 aria-describedby="basic-addon-symbol"
                data-error="Currency symbol is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('symbol')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-rate">Currency Rate <span class="text-danger">*</span></label>
            <input type="number" id="basic-addon-rate" name="rate" class="form-control" placeholder="Currency rate"
                value="{{ isset($model->rate) ? $model->rate : old('rate') }}"
                aria-describedby="basic-addon-rate"
                data-error="Currency rate is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('rate')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="role">Status <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control" id="status"
                data-minimum-results-for-search="Infinity" data-error="Status is required">
                <option value="">Select Status</option>
                <option value="1" {{ isset($model->id) && $model->status == 1 ? 'selected' : '' }}>
                    {{ __('core.active') }}</option>
                <option value="0" {{ isset($model->id) && $model->status == 0 ? 'selected' : '' }}>
                    {{ __('core.inactive') }}
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
    <script src="{{ asset('js/form/Currency.js') }}"></script>
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
