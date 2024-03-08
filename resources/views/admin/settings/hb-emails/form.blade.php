@php

    $savedArr = [];
    if( $model ){
        if( isset($model->settings_data)){
            $savedArr = unserialize($model->settings_data);
        }
    }
    
@endphp
<div class="row">

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="agent_global_markup">Multiple Email Recipients (By Comma (,) as a Separator) </label>
            <textarea id="multiple_email_recipients" name="multiple_email_recipients" class="form-control" placeholder="Multiple Email Recipients (By Comma (,) as a Separator)" cols="30" rows="2">{{ isset($savedArr['multiple_email_recipients']) ? $savedArr['multiple_email_recipients'] : old('multiple_email_recipients') }}</textarea>

          
        </div>
    </div>

    


    <div class="col-12">
        @if (count($savedArr) > 0)
            <input type="hidden" value="{{ $model->id }}" name="setting_id">
            <button type="submit" id="user-save" class="btn btn-primary waves-effect waves-float waves-light"><span
                    class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                    aria-hidden="true"></span><span class="ml-25 align-middle">Update</span></button>
        @else
            <button type="submit" id="user-save" class="btn btn-primary waves-effect waves-float waves-light"><span
                    class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                    aria-hidden="true"></span><span class="ml-25 align-middle">Submit</span></button>
        @endif

    </div>




</div>
@section('extra-script')
   
    <script src="{{ asset('js/form/GlobalMarkup.js') }}"></script>    
@endsection