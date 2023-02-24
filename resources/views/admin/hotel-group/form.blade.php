<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">{{ __('hotel-group/hotel-group.form_hotel_group') }}</label>
            <input type="text" id="basic-addon-name" name="group_name" class="form-control"
                placeholder="{{ __('hotel-group/hotel-group.form_hotel_group') }}"
                value="{{ isset($model->name) ? $model->name : old('group_name') }}" aria-describedby="basic-addon-name"
                data-error="{{ __('hotel-group/message.hotel_group_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('group_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('hotel-group/hotel-group.form_status') }}</label>
            <select name="status" class="form-control" id="status"
                data-error="{{ __('hotel-group/message.status_required') }}">
                <option value="">{{ __('hotel-group/hotel-group.form_select_status') }}</option>
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
    <script src="{{ asset('js/form/Hotel-Group.js') }}"></script>
@endsection
