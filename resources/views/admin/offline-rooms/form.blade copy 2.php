<script>
    var HotelsList = {!! json_encode($HotelsList) !!};
    var HotelsRoomType = {!! json_encode($HotelsRoomType) !!};
    var HotelsAmenities = {!! json_encode($HotelsAmenities) !!};
</script>
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">HOTEL</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-md-4 mb-1 hotelDrp">
        <label>Select Hotel</label>
        <div class="form-group">
            <select class="select2-hotel form-control" name="hotel_id">

            </select>
            <div class="hotel_idCLS"></div>
            @error('hotel_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
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
            <h4 class="mb-0 ml-75">ROOM DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemname">Room Type</label>
                <select class="select2-room-types form-control" name="room_type"></select>
                <div class="room_typeCLS"></div>
                @error('room_type')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemname">Room Amenities</label>
                <select class="select2 select2-room-amenities form-control" multiple name="room_amenities"></select>
                <div class="room_amenitiesCLS"></div>
                @error('room_amenities')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <h4 class="">Accommodation policy :</h4>
        </div>
    </div>
    <div class="col-4">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Max Pax</label>
                <input type="number" class="form-control" name="max_pax" />
                @error('max_pax')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Min Pax</label>
                <input type="number" class="form-control" name="min_pax" />
                @error('min_pax')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">No of CWB</label>
                <input type="number" class="form-control" name="no_of_cwb" />
                @error('no_of_cwb')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">No of CNB</label>
                <input type="number" class="form-control" name="no_of_cnb" />
                @error('no_of_cnb')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">No of Adult</label>
                <input type="number" class="form-control" name="no_of_adult" />
                @error('no_of_adult')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label class="form-label" for="role">Status</label>
                <select name="status" class="form-control" id="status" data-error="Status is required">
                    <option value="">Select Status</option>
                    <option value="1"> {{ __('core.active') }}</option>
                    <option value="0"> {{ __('core.inactive') }}</option>
                </select>
                @error('status')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
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
                            value="1">
                        <label class="custom-control-label" for="Normal">Normal</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="BlackoutSale" name="price_type" class="custom-control-input"
                            value="2">
                        <label class="custom-control-label" for="BlackoutSale">Blackout Sale</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="StopSale" name="price_type" class="custom-control-input"
                            value="0">
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
                    placeholder="Start Date" value="{{ old('start_date') }}" data-error="Start Date is required" />
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
                    placeholder="End Date" value="{{ old('end_date') }}" data-error="End Date is required" />
                @error('end_date')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4 is_stop_sale">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Double occupancy</label>
                <input type="number" class="form-control" name="double_occupancy" placeholder="Double occupancy"
                    value="{{ old('double_occupancy') }}" data-error="Double occupancy is required" />
                @error('double_occupancy')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4 is_stop_sale">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Single occupancy</label>
                <input type="number" class="form-control" name="single_occupancy" placeholder="Single occupancy"
                    value="{{ old('single_occupancy') }}" data-error="Single occupancy is required" />
                @error('single_occupancy')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4 is_stop_sale">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Extra Pax Price</label>
                <input type="number" class="form-control" name="extra_pax_price" placeholder="Extra pax price"
                    value="{{ old('extra_pax_price') }}" data-error="Extra pax price is required" />
                @error('extra_pax_price')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div data-repeater-list="childrens" class="repeaterCLS">
    <div data-repeater-item>
        <div class="row d-flex align-items-end">
            <div class="col-12">
                <div class="d-flex align-items-center mb-1 mt-1">
                    <h5 class="roomTitile" id="room-1" room-title="room-name">Children Details 1</h5>
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
                        <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                            <i data-feather="x" class="mr-25"></i>
                            <span>Delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <hr />
    </div>
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

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
    <!-- END: Page JS-->
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
    <!-- END: Page JS-->
    <script type="text/javascript">
        var moduleConfig = {
            hotelUrl: "",
        };
    </script>
@endsection
