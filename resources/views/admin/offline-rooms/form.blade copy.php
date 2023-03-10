<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">HOTEL</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-md-4 mb-1">
        <label>Select Hotel</label>
        <div class="form-group">
            <select class="select2-hotel form-control" name="hotel_id"></select>
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
<div data-repeater-list="rooms" class="repeaterCLS">
    <div data-repeater-item>
        <div class="row d-flex align-items-end">
            <div class="col-12">
                <div class="d-flex align-items-center mb-1 mt-1">
                    <h5 class="roomTitile" id="room-1" room-title="room-name">Room 1</h5>
                </div>
            </div>
            <div class="row col-12">
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="itemname">Room Type</label>
                        <select class="select2-room-types form-control" name="room_type"></select>
                        @error('room_type')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="itemname">Room Amenities</label>
                        <select class="select2 select2-room-amenities form-control" multiple
                            name="room_amenities"></select>
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
            <div class="row col-3">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="itemcost">Max Pax</label>
                        <input type="number" class="form-control" name="max_pax" />
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="itemcost">Min Pax</label>
                        <input type="number" class="form-control" name="min_pax" />
                    </div>
                </div>
            </div>
            <div class="row col-3">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="itemcost">No of CWB</label>
                        <input type="number" class="form-control" name="no_of_cwb" />
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="itemcost">No of CNB</label>
                        <input type="number" class="form-control" name="no_of_cnb" />
                    </div>
                </div>
            </div>
            <div class="row col-3">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="itemcost">No of Adult</label>
                        <input type="number" class="form-control" name="no_of_adult" />
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
            <div class="row col-3">
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
            <span>Add New Room</span>
        </button>
    </div>
</div>

@section('extra-script')
    <script src="{{ asset('js/form/Offline-Room.js') }}"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
    <!-- END: Page JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
    <!-- END: Page JS-->
@endsection
