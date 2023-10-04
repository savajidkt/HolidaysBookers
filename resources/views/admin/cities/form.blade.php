<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="country">{{ __('city/city.form_country_name') }} <span class="text-danger">*</span></label>
            <select name="country_id" class="select2 form-control" id="country_id" data-minimum-results-for-search="Infinity"
                data-error="{{ __('city/message.country_name_required') }}">
                <option value="">{{ __('city/city.form_country_select') }}</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $model->country_id == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}</option>
                @endforeach
            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            <span id="country"></span>
            @error('country_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group loaderDisplay">
            <label class="form-label" for="country">{{ __('city/city.form_state_name') }} <span class="text-danger">*</span></label>
            <select name="state_id" class="select2 form-control" id="state_id" data-minimum-results-for-search="Infinity"
                data-error="{{ __('city/message.state_name_required') }}">
                <option value="">{{ __('city/city.form_state_status') }}</option>
                @if ($states)
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" {{ $model->state_id == $state->id ? 'selected' : '' }}>
                            {{ $state->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="spinner-border spinner-border-sm hide" role="status">
                <span class="sr-only">{{ __('core.loading') }}</span>
            </div>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            <span id="state"></span>
            @error('state_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">{{ __('city/city.form_city_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-name" name="name" class="form-control"
                placeholder="{{ __('city/city.form_city_name') }}" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                value="{{ isset($model->name) ? $model->name : old('name') }}" aria-describedby="basic-addon-name"
                data-error="{{ __('city/message.city_name_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('city/city.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control" id="status" data-minimum-results-for-search="Infinity"
                data-error="{{ __('city/message.state_name_required') }}">
                <option value="">{{ __('city/city.form_select_status') }}</option>
                <option value="1" {{ (isset($model->id) && $model->status == 1) ? 'selected' : '' }}> {{ __('core.active') }}
                </option>
                <option value="0" {{ (isset($model->id) && $model->status == 0) ? 'selected' : '' }}> {{ __('core.inactive') }}
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
    <script type="text/javascript">
        var moduleConfig = {
            redirectUrl: "{!! route('get-state-list') !!}"
        };
    </script>    
    <script>
        $('.select2').select2();
    </script>
    <script src="{{ asset('js/form/City.js') }}"></script>
    <script>
        $('#country_id').on('change', function() {
            var selected_option_value = $(this).find(":selected").val();
            if (selected_option_value == '') {
                $('#country_id-error').show();
                $('#country_id').addClass('error');
            } else {
                $('#country_id-error').hide();
                $('#country_id').removeClass('error');
            }
        });
        $('#state_id').on('change', function() {
            var selected_option_value = $(this).find(":selected").val();
            if (selected_option_value == '') {
                $('#state_id-error').show();
                $('#state_id').addClass('error');
            } else {
                $('#state_id-error').hide();
                $('#state_id').removeClass('error');
            }
        });
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
