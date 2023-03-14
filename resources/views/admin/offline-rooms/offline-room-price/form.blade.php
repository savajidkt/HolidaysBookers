<script>
    var HotelsList = "";
    var HotelsRoomType = "";
    var HotelsAmenities = "";
    var HotelsRoomID = "";
    var HotelsAmenitiesIDs = "";
</script>
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">HOTEL DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">Hotel Name</label>
            <strong class="disp-below">{{ isset($model->hotel->hotel_name) ? $model->hotel->hotel_name : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">Room Type</label>
            <strong
                class="disp-below">{{ isset($model->roomtype->room_type) ? $model->roomtype->room_type : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">Adult</label>
            <strong class="disp-below">{{ isset($model->total_adult) ? $model->total_adult : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">CWB</label>
            <strong class="disp-below">{{ isset($model->total_cwb) ? $model->total_cwb : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">CNB</label>
            <strong class="disp-below">{{ isset($model->total_cnb) ? $model->total_cnb : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">Min Pax</label>
            <strong class="disp-below">{{ isset($model->min_pax) ? $model->min_pax : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">Max Pax</label>
            <strong class="disp-below">{{ isset($model->max_pax) ? $model->max_pax : '' }}</strong>
        </div>
    </div>
    <div class="col-12">
        <hr class="my-2" />
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">ROOM PRICE</h4>
        </div>
        <hr class="my-2" />
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemname">Price Type</label>
                <div class="demo-inline-spacing">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="Normal" name="price_type" class="custom-control-input"
                            value="1" {{ $pricemodel->price_type == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="Normal">Normal</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="BlackoutSale" name="price_type" class="custom-control-input"
                            value="2" {{ $pricemodel->price_type == 2 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="BlackoutSale">Blackout Sale</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="StopSale" name="price_type" class="custom-control-input"
                            value="0" {{ ( strlen($pricemodel->price_type) > 0 && $pricemodel->price_type == 0 ) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="StopSale">Stop Sale</label>
                    </div>
                </div>
                <div class="price_typeCLS"></div>
                @error('room_type')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Start Date</label>
                <input type="text" id="fp-default" name="start_date"
                    class="form-control flatpickr-basic flatpickr-input" placeholder="YYYY-MM-DD"
                    placeholder="Start Date"
                    value="{{ isset($pricemodel->from_date) ? $pricemodel->from_date : old('start_date') }}"
                    data-error="Start Date is required" />
                @error('start_date')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">End Date</label>
                <input type="text" id="fp-default" name="end_date"
                    class="form-control flatpickr-basic flatpickr-input" placeholder="YYYY-MM-DD"
                    placeholder="End Date"
                    value="{{ isset($pricemodel->to_date) ? $pricemodel->to_date : old('end_date') }}"
                    data-error="End Date is required" />
                @error('end_date')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4 is_stop_sale {{ ( strlen($pricemodel->price_type) > 0 && $pricemodel->price_type == 0 ) ? 'hide' : '' }}">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Double occupancy</label>
                <input type="number" class="form-control" name="double_occupancy" placeholder="Double occupancy"
                    value="{{ isset($pricemodel->adult_price) ? $pricemodel->adult_price : old('double_occupancy') }}"
                    data-error="Double occupancy is required" />
                @error('double_occupancy')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4 is_stop_sale {{ ( strlen($pricemodel->price_type) > 0 && $pricemodel->price_type == 0 ) ? 'hide' : '' }}">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Single occupancy</label>
                <input type="number" class="form-control" name="single_occupancy" placeholder="Single occupancy"
                    value="{{ isset($pricemodel->single_adult_price) ? $pricemodel->single_adult_price : old('single_occupancy') }}"
                    data-error="Single occupancy is required" />
                @error('single_occupancy')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4 is_stop_sale {{ ( strlen($pricemodel->price_type) > 0 && $pricemodel->price_type == 0 ) ? 'hide' : '' }}">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Extra Pax Price</label>
                <input type="number" class="form-control" name="extra_pax_price" placeholder="Extra pax price"
                    value="{{ isset($pricemodel->extra_bed_price) ? $pricemodel->extra_bed_price : old('extra_pax_price') }}"
                    data-error="Extra pax price is required" />
                @error('extra_pax_price')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div data-repeater-list="childrens" class="repeaterCLS">
    @if ($pricemodel->childprice->count() > 0)
        @foreach ($pricemodel->childprice as $childs)
            <div data-repeater-item>
                <div class="row d-flex align-items-end">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-1 mt-1">
                            <h5 class="childTitile" id="child-1" child-title="child-name">Children Details 1</h5>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="itemcost">Min Age</label>
                                <input type="number" class="form-control" name="main_age"
                                    value="{{ isset($childs->min_age) ? $childs->min_age : old('min_age') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="itemcost">Max Age</label>
                                <input type="number" class="form-control" name="max_age"
                                    value="{{ isset($childs->max_age) ? $childs->max_age : old('max_age') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="itemcost">CWB Price</label>
                                <input type="number" class="form-control" name="cwb_price"
                                    value="{{ isset($childs->cwb_price) ? $childs->cwb_price : old('cwb_price') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="itemcost">CNB Price</label>
                                <input type="number" class="form-control" name="cnb_price"
                                    value="{{ isset($childs->cnb_price) ? $childs->cnb_price : old('cnb_price') }}" />
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $childs->id }}" />
                    <input type="hidden" name="room_id" value="{{ $childs->room_id }}" />
                    <input type="hidden" name="price_id" value="{{ $childs->price_id }}" />
                    <div class="row col-4">
                        <div class="col-md-2 col-12 mb-50">
                            <div class="form-group">
                                <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete
                                    type="button">
                                    <i data-feather="x" class="mr-25"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
            </div>
        @endforeach
    @else
        <div data-repeater-item>
            <div class="row d-flex align-items-end">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-1 mt-1">
                        <h5 class="childTitile" id="child-1" child-title="child-name">Children Details 1</h5>
                    </div>
                </div>
                <div class="col-2">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="itemcost">Min Age</label>
                            <input type="number" class="form-control" name="main_age" />
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="itemcost">Max Age</label>
                            <input type="number" class="form-control" name="max_age" />
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="itemcost">CWB Price</label>
                            <input type="number" class="form-control" name="cwb_price" />
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="itemcost">CNB Price</label>
                            <input type="number" class="form-control" name="cnb_price" />
                        </div>
                    </div>
                </div>

                <div class="row col-4">
                    <div class="col-md-2 col-12 mb-50">
                        <div class="form-group">
                            <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete
                                type="button">
                                <i data-feather="x" class="mr-25"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
        </div>
    @endif
</div>
<div class="row">
    <div class="col-12">
        <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
            <i data-feather="plus" class="mr-25"></i>
            <span>Add More Children</span>
        </button>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('js/form/Offline-Room.js') }}"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <!-- END: Page JS-->
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <!-- BEGIN: Page JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
    <!-- END: Page JS-->
@endsection
