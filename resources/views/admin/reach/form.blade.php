<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">{{ __('reach-us/reach-us.form_reach_name') }}</label>
            <input type="text" id="basic-addon-name" name="name" class="form-control"
                placeholder="{{ __('reach-us/reach-us.form_reach_name') }}"
                value="{{ isset($model->name) ? $model->name : old('name') }}" aria-describedby="basic-addon-name"
                data-error="{{ __('reach-us/message.reachus_name_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('reach-us/reach-us.form_status') }}</label>
            <select name="status" class="form-control" id="status"
                data-error="{{ __('reach-us/message.status_required') }}">
                <option value="">{{ __('reach-us/reach-us.form_select_status') }}</option>
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
    <script src="{{ asset('js/form/Reach-us.js') }}"></script>
@endsection