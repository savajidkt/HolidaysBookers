<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">Hotel Order Edit</h4>
        </div>
        <hr class="my-2" />
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label class="form-label" for="role">Order Status</label>
            <select name="status" class="form-control" id="status" data-error="Status is required">
                <option value="">Select Status</option>
                <option value="1" {{ ($model->status == 1) ? 'selected' : '' }}>
                    Processed </option>
                <option value="2" {{ ($model->status == 2) ? 'selected' : '' }}>
                    Confirmed</option>
                <option value="3" {{  ($model->status == 3) ? 'selected' : '' }}>
                    Cancelled</option>                
            </select>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4 Extrainformation {{ ($model->payment_status == 0) ? 'hide' : '' }}">
        <div class="form-group">
            <label for="basicInput">Extra information
                </label>
            <input type="text" class="form-control" id="basicInput" name="status_comments"
                placeholder="Extra information" value="{{ $model->status_comments }}">           
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemname">Payment Received</label>
            <div class="demo-inline-spacing">
                <div class="custom-control custom-radio">
                    <input onchange="handleChange(this);"  type="radio" id="yes" name="payment_status" class="custom-control-input PaymentReceived" value="1"
                        {{ ($model->payment_status == 1) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="yes">Yes</label>
                </div>
                <div class="custom-control custom-radio">
                    <input onchange="handleChange(this);"  type="radio" id="no" name="payment_status" class="custom-control-input PaymentReceived" value="0"
                        {{ ($model->payment_status == 0) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="no">No</label>
                </div>                
            </div>
            <div class="paymentCLS"></div>
            @error('payment')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="col-md-12 col-12">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Comments</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="comments" rows="3" placeholder="Comments">{{ $model->comments }}</textarea>
        </div>
    </div>
</div>
@section('extra-script')
<script type="text/javascript">
                   
    function handleChange(src) {     
     if( src.value == 1 ){
         $('.Extrainformation').removeClass('hide');
     } else{
         $('.Extrainformation').addClass('hide');
     }
 }
</script>
@endsection