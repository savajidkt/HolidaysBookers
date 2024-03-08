@php

    $savedArr = [];
    if( $model ){
        if( isset($model->settings_data)){
            $savedArr = unserialize($model->settings_data);
        }
    }
    
@endphp
<div class="row">

    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_global_markups_type">Agent Global Markup Type</label>
            <div class="demo-inline-spacing">
                <div class="custom-control custom-radio">
                    <input type="radio" id="agent_global_markups_type-yes" name="agent_global_markups_type"
                        class="custom-control-input" value="1"  @php if( isset($savedArr['agent_global_markups_type'])  && $savedArr['agent_global_markups_type'] == "1") { echo 'checked'; } else { echo ''; } @endphp >
                    <label class="custom-control-label" for="agent_global_markups_type-yes">Percentage (%) </label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="agent_global_markups_type-no" name="agent_global_markups_type"
                        class="custom-control-input" value="2" @php if( isset($savedArr['agent_global_markups_type'])  && $savedArr['agent_global_markups_type'] == "2") { echo 'checked'; } else { echo ''; } @endphp>
                    <label class="custom-control-label" for="agent_global_markups_type-no">Fix</label>
                </div>
            </div>
            <div class="valid-feedback">Looks good!</div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_global_markup">Agent Global Markup</label>
            <input type="number" id="agent_global_markup" name="agent_global_markup" class="form-control"
                placeholder="Agent Global Markup" value="{{ isset($savedArr['agent_global_markup']) ? $savedArr['agent_global_markup'] : '' }}">
            <div class="valid-feedback">Looks good!</div>
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