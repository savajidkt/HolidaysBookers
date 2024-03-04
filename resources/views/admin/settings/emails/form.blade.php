@php

$savedArr = [];
    if( $model ){
        if( isset($model->settings_data)){            
            $savedArr = unserialize($model->settings_data);
        }
    }
    
@endphp
<div class="row">
    <div class="col-md-6">
        <div class="col-12">
            <div class="card-body">
                <p class="card-text mb-0">
                    Send email HB
                </p>
                <div class="demo-inline-spacing">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio1" name="send_email_hb" class="custom-control-input" 
                            value="yes" @php if( isset($savedArr['send_email_hb'])  && $savedArr['send_email_hb'] == "yes") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio1">Yes</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio2" name="send_email_hb" class="custom-control-input"
                            value="no" @php if( isset($savedArr['send_email_hb'])  && $savedArr['send_email_hb'] == "no") { echo 'checked'; } else { echo ''; } @endphp  >
                        <label class="custom-control-label" for="customRadio2">No</label>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card-body">
                <p class="card-text mb-0">
                    Send email Agent
                </p>
                <div class="demo-inline-spacing">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio3" name="send_email_agent" class="custom-control-input"
                            value="yes" @php if( isset($savedArr['send_email_agent'])  && $savedArr['send_email_agent'] == "yes") { echo 'checked'; } else { echo ''; } @endphp  >
                        <label class="custom-control-label" for="customRadio3">Yes</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio4" name="send_email_agent" class="custom-control-input"
                            value="no" @php if( isset($savedArr['send_email_agent'])  && $savedArr['send_email_agent'] == "no") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio4">No</label>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card-body">
                <p class="card-text mb-0">
                    Send email Hotel
                </p>
                <div class="demo-inline-spacing">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio5" name="send_email_hotel" class="custom-control-input"
                             value="yes" @php if( isset($savedArr['send_email_hotel'])  && $savedArr['send_email_hotel'] == "yes") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio5">Yes</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio6" name="send_email_hotel" class="custom-control-input"
                            value="no" @php if( isset($savedArr['send_email_hotel'])  && $savedArr['send_email_hotel'] == "no") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio6">No</label>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card-body">
                <p class="card-text mb-0">
                    Send email Hotel Account
                </p>
                <div class="demo-inline-spacing">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio7" name="send_email_hotel_account"
                            class="custom-control-input"  value="yes"  @php if( isset($savedArr['send_email_hotel_account'])  && $savedArr['send_email_hotel_account'] == "yes") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio7">Yes</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio8" name="send_email_hotel_account"
                            class="custom-control-input" value="no" @php if( isset($savedArr['send_email_hotel_account'])  && $savedArr['send_email_hotel_account'] == "no") { echo 'checked'; } else { echo ''; } @endphp>
                        <label class="custom-control-label" for="customRadio8">No</label>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card-body">
                <p class="card-text mb-0">
                    Send email Hotel Sales
                </p>
                <div class="demo-inline-spacing">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio9" name="send_email_hotel_sales"
                            class="custom-control-input" value="yes" @php if( isset($savedArr['send_email_hotel_sales'])  && $savedArr['send_email_hotel_sales'] == "yes") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio9">Yes</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio10" name="send_email_hotel_sales"
                            class="custom-control-input" value="no" @php if( isset($savedArr['send_email_hotel_sales'])  && $savedArr['send_email_hotel_sales'] == "no") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio10">No</label>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card-body">
                <p class="card-text mb-0">
                    Send email Hotel Front Office
                </p>
                <div class="demo-inline-spacing">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio11" name="send_email_hotel_front_office"
                            class="custom-control-input" value="yes" @php if( isset($savedArr['send_email_hotel_front_office'])  && $savedArr['send_email_hotel_front_office'] == "yes") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio11">Yes</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio12" name="send_email_hotel_front_office"
                            class="custom-control-input" value="no" @php if( isset($savedArr['send_email_hotel_front_office'])  && $savedArr['send_email_hotel_front_office'] == "no") { echo 'checked'; } else { echo ''; } @endphp>
                        <label class="custom-control-label" for="customRadio12">No</label>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card-body">
                <p class="card-text mb-0">
                    Send email Hotel Registration
                </p>
                <div class="demo-inline-spacing">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio13" name="send_email_hotel_registration"
                            class="custom-control-input" value="yes" @php if( isset($savedArr['send_email_hotel_registration'])  && $savedArr['send_email_hotel_registration'] == "yes") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio13">Yes</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio14" name="send_email_hotel_registration"
                            class="custom-control-input" value="no" @php if( isset($savedArr['send_email_hotel_registration'])  && $savedArr['send_email_hotel_registration'] == "no") { echo 'checked'; } else { echo ''; } @endphp >
                        <label class="custom-control-label" for="customRadio14">No</label>
                    </div>

                </div>
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


</div>
