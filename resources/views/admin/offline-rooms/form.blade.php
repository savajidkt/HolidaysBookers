<script>
    var HotelsList = {!! json_encode($HotelsList) !!};
    var HotelsRoomType = {!! json_encode($HotelsRoomType) !!};
    var HotelsRoomMealPlan = {!! json_encode($HotelsRoomMealPlan) !!};
    var HotelsAmenities = {!! json_encode($HotelsAmenities) !!};
    var HotelsFreebies = {!! json_encode($HotelsFreebies) !!};
    var HotelsRoomID = "";
    var HotelsRoomMealPlanID = "";
    var HotelsAmenitiesIDs = [];
    var HotelsFreebiesIDs = [];
    var HotelID = 0;
    var currencyList = [];
    var currencyIDs = "";
</script>
@if ($offlinehotel)
    <script>
        var HotelID = "{!! $offlinehotel->id !!}";
    </script>
@endif

<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">HOTEL</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-md-4 mb-1 hotelDrp">
        <label>Select Hotel <span class="text-danger">*</span></label>
        <div class="form-group">
            <select class="select2-hotel form-control select2" name="hotel_id">
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
<div data-repeater-list="rooms" class="repeaterCLS">
    <div data-repeater-item>
        <div class="row d-flex ">
            <div class="col-12">
                <div class="d-flex align-items-center mb-1 mt-1">
                    <h5 class="roomTitile" id="room-1" room-title="room-name">Room 1</h5>
                </div>
            </div>

            <div class="col-6">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="itemname">Room Type <span class="text-danger">*</span></label>
                        <a class="badge badge-success roomTypeBTN" style="color:#FFF; float: right;">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New Room Type
                        </a>
                        <select class="select2-room-types form-control select2" name="room_type"></select>
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
                        <label for="itemname">Room Amenity <span class="text-danger">*</span></label>
                        <a class="badge badge-success roomAmenityBTN" style="color:#FFF; float: right;">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New Amenity
                        </a>
                        <select class="select2 select2-room-amenities form-control" multiple
                            name="room_amenities"></select>
                        <div class="room_amenitiesCLS"></div>
                        @error('room_amenities')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>           
            <div class="col-6">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label for="itemname">Room Freebies</label>
                        <a class="badge badge-success roomFreebiesBTN" style="color:#FFF; float: right;">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New Freebies
                        </a>
                        <select class="select2 select2-room-freebies form-control" multiple
                            name="room_freebies"></select>
                        <div class="room_freebiesCLS"></div>
                        @error('room_freebies')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex align-items-center mb-1 mt-1">
                    <h4 class="">Max Occupancy :</h4>
                </div>
            </div>
            <div class="col-md-4 col-4">
                <div class="form-group">
                    <label>Max Occupancy <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="occ_sleepsmax" value="{{ old('occ_sleepsmax') }}"
                        data-error="Max Occupancy is required" />
                    @error('occ_sleepsmax')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-4">
                <div class="form-group">
                    <label>No. of Beds <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="occ_num_beds" value="{{ old('occ_num_beds') }}"
                        data-error="Max Occupancy is required" />
                    <small class="text-muted" style="font-size: 10px;">No. of Beds Base occupancy for room price.
                        Number of people who can be accommodated on existing bedding of the room. Leave it is as
                        default 2 if unsure</small>
                    @error('occ_num_beds')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 col-4">
                <div class="form-group">
                    <label>Max Adults <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="occ_max_adults"
                        value="{{ old('occ_max_adults') }}" data-error="Max Occupancy is required" />
                    @error('occ_max_adults')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-4">
                <div class="form-group">
                    <label>Max Children When Max Adults <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="occ_max_child_w_max_adults"
                        value="{{ old('occ_max_child_w_max_adults') }}" data-error="Max Occupancy is required" />
                    @error('occ_max_child_w_max_adults')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="col-md-4 col-4">
                <div class="form-group">
                    <label>Max Children Without Extra Bed <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="occ_max_child_wo_extra_bed"
                        value="{{ old('occ_max_child_wo_extra_bed') }}" data-error="Max Occupancy is required" />
                    <small class="text-muted" style="font-size: 10px;"></small>
                    @error('occ_max_child_wo_extra_bed')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-4">
                <div class="form-group">
                    <label class="form-label" for="role">Status <span class="text-danger">*</span></label>
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

            <div class="col-3">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label class="form-label" for="cancel_days">Room Image</label>
                        <div class="dropzone clsbox roomImageDropzone" id="roomImageDropzone_0"
                            name="roomImageDropzone" dropzonename="roomImageDropzone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label class="form-label" for="cancel_days">Room Gallery</label>
                        <div class="dropzone clsbox roomGalleryDropzone" id="roomGalleryDropzone_0"
                            name="roomGalleryDropzone" dropzonegallery="roomGalleryDropzone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row col-4">
                <div class="col-md-2 col-12 mb-50">
                    <div class="form-group">
                        <button class="btn btn-outline-danger btn-sm text-nowrap px-1" data-repeater-delete
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
</div>
<div class="row">
    <div class="col-12">
        <button class="btn btn-icon btn-primary " type="button" data-repeater-create>
            <i data-feather="plus"></i>
            <span>Add More Room</span>
        </button>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>
    <script src="{{ asset('js/form/Offline-Room.js') }}"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
    <!-- END: Page JS-->
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;

        // Dropzone class:
        var roomImageDropzone = new Dropzone("div#roomImageDropzone_0", {
            url: "/file/post",
            autoProcessQueue: false,
            maxFilesize: 1,
            acceptedFiles: 'image/*',
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    // Create the remove button
                    var removeButton = Dropzone.createElement(
                        "<button class='btn btn-outline-danger btn-sm' style='margin-left: 7px;margin-top: 7px;'>Remove file</button>"
                    );
                    // Capture the Dropzone instance as closure.
                    var _this = this;
                    // Listen to the click event
                    removeButton.addEventListener("click", function(e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                        this.on("maxfilesexceeded", function(file) {
                            this.removeFile(file);
                        });
                    });
                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });
            }
        });


        var roomGalleryDropzone = new Dropzone("div#roomGalleryDropzone_0", {
            url: "/file/post",
            autoProcessQueue: false,
            acceptedFiles: 'image/*',
            init: function() {
                this.on('addedfile', function(file) {
                    // Create the remove button
                    var removeButton = Dropzone.createElement(
                        "<button class='btn btn-outline-danger btn-sm' style='margin-left: 7px;margin-top: 7px;'>Remove file</button>"
                    );
                    // Capture the Dropzone instance as closure.
                    var _this = this;
                    // Listen to the click event
                    removeButton.addEventListener("click", function(e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                        this.on("maxfilesexceeded", function(file) {
                            this.removeFile(file);
                        });
                    });
                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });
            }
        });
    </script>
    <script type="text/javascript">
        var moduleConfig = {
            addRoomTypeURL: "{!! route('add-room-type') !!}",
            addRoomMealPlanURL: "{!! route('add-meal-plan') !!}",
            addAmenityURL: "{!! route('add-amenity') !!}",
            addFreebiesURL: "{!! route('add-freebies') !!}",
            addRoomsURL: "{!! route('offlinerooms.store') !!}",
            listRoomsURL: "{!! route('offlinerooms.index') !!}",
            getHotelRoomsURL: "{!! route('get-hotel-rooms-url', '') !!}",
            changeRoomsStatusURL: "{!! route('change-offline-room-status', '') !!}",
        };
    </script>
@endsection
