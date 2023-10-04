<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">{{ __('reach-us/reach-us.form_reach_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-name" name="name" class="form-control"
                placeholder="{{ __('reach-us/reach-us.form_reach_name') }}" onkeydown="return /[a-zA-Z ]/.test(event.key)"
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
            <label class="form-label" for="role">Show Other Textbox</label>
            <select name="show_other_textbox" class="form-control" id="show_other_textbox">
                <option value="0" {{ $model->show_other_textbox == 0 ? 'selected' : '' }}> {{ __('core.no') }}
                </option>
                <option value="1" {{ $model->show_other_textbox == 1 ? 'selected' : '' }}> {{ __('core.yes') }}
                </option>
            </select>
        </div>
    </div>
    @php
        $hide = isset($model->textbox_lable) ? '' : 'hide';
    @endphp
    <div class="col-12 textbox_lable_div {{ $hide }}">
        <div class="form-group">
            <label class="form-label" for="role">Textbox Lable <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-textbox_lable" name="textbox_lable" class="form-control"
                value="{{ isset($model->textbox_lable) ? $model->textbox_lable : old('textbox_lable') }}"
                data-error="Textbox lable name is required" />
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('reach-us/reach-us.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control" id="status" data-minimum-results-for-search="Infinity"
                data-error="{{ __('reach-us/message.status_required') }}">
                <option value="">{{ __('reach-us/reach-us.form_select_status') }}</option>
                <option value="1" {{ $model->status == 1 ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ $model->status == 0 ? 'selected' : '' }}> {{ __('core.inactive') }}</option>
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
    <script src="{{ asset('js/form/Reach-us.js') }}"></script>
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
