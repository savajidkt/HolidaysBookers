<script>
    var HotelsList = {!! json_encode($HotelsList) !!};
    var HotelsRoomType = {!! json_encode($HotelsRoomType) !!};
    var HotelsAmenities = {!! json_encode($HotelsAmenities) !!};
    var HotelsRoomID = "{!! $model->room_type_id !!}";
    var HotelsAmenitiesIDs = {!! json_encode($HotelsAmenitiesIDS) !!};
</script>

<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">ROOM DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>
</div>

<div class="row d-flex align-items-end">
    <div class="col-6">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemname">Room Type</label>
                <a class="badge badge-success roomTypeBTN" style="color:#FFF; float: right;">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New Room Type
                </a>
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
                <a class="badge badge-success roomAmenityBTN" style="color:#FFF; float: right;">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New Room Amenities
                </a>
                <select class="select2 select2-room-amenities form-control" multiple name="room_amenities[]"></select>
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
                <input type="number" class="form-control" name="max_pax"
                    value="{{ isset($model->max_pax) ? $model->max_pax : old('max_pax') }}" />
                @error('max_pax')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Min Pax</label>
                <input type="number" class="form-control" name="min_pax"
                    value="{{ isset($model->min_pax) ? $model->min_pax : old('min_pax') }}" />
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
                <input type="number" class="form-control" name="no_of_cwb"
                    value="{{ isset($model->total_cwb) ? $model->total_cwb : old('total_cwb') }}" />
                @error('no_of_cwb')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">No of CNB</label>
                <input type="number" class="form-control" name="no_of_cnb"
                    value="{{ isset($model->total_cnb) ? $model->total_cnb : old('total_cnb') }}" />
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
                <input type="number" class="form-control" name="no_of_adult"
                    value="{{ isset($model->total_adult) ? $model->total_adult : old('total_adult') }}" />
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

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
    <!-- END: Page JS-->
    <script type="text/javascript">
        var moduleConfig = {
            addRoomTypeURL: "{!! route('add-room-type') !!}",
            addAmenityURL: "{!! route('add-amenity') !!}",
        };
    </script>
@endsection
