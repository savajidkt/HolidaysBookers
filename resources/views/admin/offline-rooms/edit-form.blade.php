@php
    $imageMainPath = '';
    $images = [];
    if (isset($model->images)) {
        foreach ($model->images as $key => $img) {
            $images[$key]['images'] = url(Storage::url('app/upload/Hotel/' . $model->hotel_id . '/Room/' . $model->id . '/Gallery/' . $img['images']));
        }
    }
    if (strlen($model->room_image) > 0) {
        $imageMainPath = url(Storage::url('app/upload/Hotel/' . $model->hotel_id . '/Room/' . $model->id . '/' . $model->room_image));
    }
    
@endphp



<script>
    var HotelsList = {!! json_encode($HotelsList) !!};
    var HotelsRoomType = {!! json_encode($HotelsRoomType) !!};
    var HotelsRoomMealPlan = {!! json_encode($HotelsRoomMealPlan) !!};
    var HotelsAmenities = {!! json_encode($HotelsAmenities) !!};
    var HotelsFreebies = {!! json_encode($HotelsFreebies) !!};
    var HotelsRoomID = "{!! $model->room_type_id !!}";
    var HotelsAmenitiesIDs = {!! json_encode($HotelsAmenitiesIDS) !!};
    var HotelsFreebiesIDs = {!! json_encode($HotelsFreebiesIDs) !!};
    var images = {!! json_encode($images) !!};
    var $imageMainPathjs = "{!! $imageMainPath !!}";
    var HotelID = "{!! $model->hotel_id !!}";
    var HotelsRoomMealPlanID = "{!! $model->meal_plan_id !!}";
    var currencyList = [];
    var currencyIDs = "";
</script>

<style>
    .dropzone .dz-preview .dz-image img {
        display: block;
        width: 120px;
        height: 120px;
    }
</style>
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
            <select class="select2-hotel form-control select2" name="hotel_id" >
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

<div class="row d-flex ">
    <div class="col-6">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemname">Room Type</label>
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
                <label for="itemname">Room Amenity</label>
                <a class="badge badge-success roomAmenityBTN" style="color:#FFF; float: right;">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New Amenity
                </a>
                <select class="select2 select2-room-amenities form-control" multiple name="room_amenities[]"></select>
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
                <select class="select2 select2-room-freebies form-control" multiple name="room_freebies[]"></select>
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
            <label>Max Occupancy</label>
            <input type="number" class="form-control" name="occ_sleepsmax"
                value="{{ isset($model->occ_sleepsmax) ? $model->occ_sleepsmax : old('occ_sleepsmax') }}"
                data-error="Max Occupancy is required" />
            @error('occ_sleepsmax')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4 col-4">
        <div class="form-group">
            <label>No. of Beds</label>
            <input type="number" class="form-control" name="occ_num_beds"
                value="{{ isset($model->occ_num_beds) ? $model->occ_num_beds : old('occ_num_beds') }}"
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
            <label>Max Adults</label>
            <input type="number" class="form-control" name="occ_max_adults"
                value="{{ isset($model->occ_max_adults) ? $model->occ_max_adults : old('occ_max_adults') }}"
                data-error="Max Occupancy is required" />
            @error('occ_max_adults')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label>Max Children When Max Adults</label>
            <input type="number" class="form-control" name="occ_max_child_w_max_adults"
                value="{{ isset($model->occ_max_child_w_max_adults) ? $model->occ_max_child_w_max_adults : old('occ_max_child_w_max_adults') }}"
                data-error="Max Occupancy is required" />
            @error('occ_max_child_w_max_adults')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4 col-4">
        <div class="form-group">
            <label>Max Children Without Extra Bed</label>
            <input type="number" class="form-control" name="occ_max_child_wo_extra_bed"
                value="{{ isset($model->occ_max_child_wo_extra_bed) ? $model->occ_max_child_wo_extra_bed : old('occ_max_child_wo_extra_bed') }}"
                data-error="Max Occupancy is required" />
            <small class="text-muted" style="font-size: 10px;"></small>
            @error('occ_max_child_wo_extra_bed')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label class="form-label" for="role">Status</label>
            <select name="status" class="form-control" id="status" data-error="Status is required">
                <option value="">Select Status</option>
                <option value="1" {{ isset($model->id) && $model->status == 1 ? 'selected' : '' }}>
                    {{ __('core.active') }}</option>
                <option value="0" {{ isset($model->id) && $model->status == 0 ? 'selected' : '' }}>
                    {{ __('core.inactive') }}</option>
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
                <div class="dropzone clsbox roomImageDropzone" id="roomImageDropzone_0" name="roomImageDropzone"
                    dropzonename="roomImageDropzone">
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
</div>
<hr />






@section('extra-script')
    <script src="{{ asset('js/form/Offline-Room.js') }}"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
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
            addRemoveLinks: true,
            removedfile: function(file) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('delete-room-image') }}",
                    data: {
                        filename: file.url
                    },
                    success: function(data) {
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
        });

        if ($imageMainPathjs) {
            var mockFile = {
                url: '{!! $imageMainPath !!}'
            };
            roomImageDropzone.emit("addedfile", mockFile);
            roomImageDropzone.emit("thumbnail", mockFile, '{!! $imageMainPath !!}');
            roomImageDropzone.emit("complete", mockFile);
            // var existingFileCount = 1;
            // roomImageDropzone.options.maxFiles = roomImageDropzone.options.maxFiles - existingFileCount;
        }

        var roomGalleryDropzone = new Dropzone("div#roomGalleryDropzone_0", {
            url: "/file/post",
            autoProcessQueue: false,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            removedfile: function(file) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('delete-room-gallery-image') }}",
                    data: {
                        filename: file.url
                    },
                    success: function(data) {
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
        });


        // If you use jQuery, you can use the jQuery plugin Dropzone ships with:
        for (let i = 0; i < images.length; i++) {
            let img = images[i];
            // Create the mock file:
            var mockFile = {
                url: img.images
            };
            // Call the default addedfile event handler
            roomGalleryDropzone.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            roomGalleryDropzone.emit("thumbnail", mockFile, img.images);
            // Make sure that there is no progress bar, etc...
            roomGalleryDropzone.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            roomGalleryDropzone.options.maxFiles = roomGalleryDropzone.options.maxFiles - existingFileCount;

        }
    </script>
    <script type="text/javascript">
        var moduleConfig = {
            addRoomTypeURL: "{!! route('add-room-type') !!}",
            addRoomMealPlanURL: "{!! route('add-meal-plan') !!}",
            addAmenityURL: "{!! route('add-amenity') !!}",
            addFreebiesURL: "{!! route('add-freebies') !!}",
            editRoomURL: "{!! route('offlinerooms.update', $model) !!}",
            listRoomsURL: "{!! route('offlinerooms.index') !!}",
            getHotelRoomsURL: "{!! route('get-hotel-rooms-url', '') !!}",
        };
    </script>
@endsection
