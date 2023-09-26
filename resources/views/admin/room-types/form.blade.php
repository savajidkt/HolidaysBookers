<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-room_type">{{ __('roomtype/roomtype.form_room_type') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-room_type" name="room_type" class="form-control"
                placeholder="{{ __('roomtype/roomtype.form_room_type') }}" onkeydown="return /[a-z]/i.test(event.key)"
                value="{{ isset($model->room_type) ? $model->room_type : old('room_type') }}"
                aria-describedby="basic-addon-room_type" data-error="{{ __('roomtype/message.room_type_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('room_type')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('roomtype/roomtype.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="form-control" id="status"
                data-error="{{ __('roomtype/message.status_required') }}">
                <option value="">{{ __('roomtype/roomtype.form_select_status') }}</option>
                <option value="1" {{ (isset($model->id) && $model->status == 1) ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ (isset($model->id) && $model->status == 0) ? 'selected' : '' }}> {{ __('core.inactive') }}</option>
            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('js/form/Room-Type.js') }}"></script>
@endsection
