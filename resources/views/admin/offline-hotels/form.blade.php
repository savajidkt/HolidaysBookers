@php
    $hotel_image_location = '';
    $images = [];
    if (isset($model->images)) {
        foreach ($model->images as $key => $img) {
            $images[$key]['file_path'] = url(Storage::url('app/upload/Hotel/' . $model->id . '/gallery/' . $img['file_path']));
        }
    }
    
    if (strlen($model->hotel_image_location) > 0) {
        $hotel_image_location = url(Storage::url('app/upload/Hotel/' . $model->id . '/' . $model->hotel_image_location));
    }
    
@endphp
<script>
    var HotelsFreebies = {!! json_encode($HotelsFreebies) !!};
    var HotelsAmenities = {!! json_encode($HotelsAmenities) !!};
    var HotelsAmenitiesIDs = {!! json_encode($HotelsAmenitiesIDs) !!};
    var HotelsFreebiesIDs = {!! json_encode($HotelsFreebiesIDs) !!};
    var images = {!! json_encode($images) !!};
    var $hotel_image_locationJS = "{!! $hotel_image_location !!}";
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
            <h4 class="mb-0 ml-75">Hotel Details</h4>
            <input type="hidden" value="{{ isset($model->id) ? 'yes' : 'no' }}" class="editPage" id="editPage">
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_name">Hotel Name</label>
            <input type="text" id="hotel_name" name="hotel_name" class="form-control" placeholder="Hotel Name"
                value="{{ isset($model->hotel_name) ? $model->hotel_name : old('hotel_name') }}"
                data-error="Hotel Name" />
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="hotel_country">Country</label>
            <select class="select2 form-control" id="hotel_country" name="hotel_country" data-error="Country">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $model->hotel_country == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_country')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    {{-- <div class="col-4">
        <div class="form-group myState">
            <label class="form-label" for="hotel_state">State</label>
            <select class="select2 form-control" id="hotel_state" name="hotel_state" data-error="State">
                <option value="">Select State</option>
                @php $states = getCountryStates($model->hotel_country);  @endphp
                @if ($states->count() > 0)
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" {{ $model->hotel_state == $state->id ? 'selected' : '' }}>
                            {{ $state->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="spinner-border spinner-border-sm hide" role="status">
                <span class="sr-only">{{ __('core.loading') }}</span>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_state')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div> --}}
    <div class="col-2">
        <div class="form-group myCity">
            <label class="form-label" for="hotel_city">City</label>
            <select class="select2 form-control" id="hotel_city" name="hotel_city" data-error="City">
                <option value="">Select City</option>
                @php $cities = getStateCities($model->hotel_country);  @endphp
                @if ($cities->count() > 0)
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ $model->hotel_city == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="spinner-border spinner-border-sm hide" role="status">
                <span class="sr-only">{{ __('core.loading') }}</span>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_city')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="category">Category</label>
            <select class="select2 form-control" id="category" name="category" data-error="Category">
                <option value="">Select Category</option>
                @foreach ($categories as $key => $category)
                    <option value="{{ $key }}" {{ $model->category == $key ? 'selected' : '' }}>
                        {{ $category }}</option>
                @endforeach
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('category')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="hotel_group_id">Hotel Group</label>
            <a class="badge badge-success HotelGroupPopup" style="color:#FFF; float: right;">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Group
            </a>
            <select class="select2 form-control" id="hotel_group_id" name="hotel_group_id" data-error="Hotel Group">
                <option value="">Select Hotel Group</option>
                @foreach ($hotelGroups as $key => $hg)
                    <option value="{{ $hg->id }}" {{ $model->hotel_group_id == $hg->id ? 'selected' : '' }}>
                        {{ $hg->name }}</option>
                @endforeach
            </select>
            @error('hotel_group_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Phone Number"
                value="{{ isset($model->phone_number) ? $model->phone_number : old('phone_number') }}"
                data-error="Phone Number" />
            <div class="valid-feedback">Looks good!</div>
            @error('phone_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="fax_number">Fax Number</label>
            <input type="text" id="fax_number" name="fax_number" class="form-control" placeholder="Fax Number"
                value="{{ isset($model->fax_number) ? $model->fax_number : old('fax_number') }}"
                data-error="Fax Number" />
            <div class="valid-feedback">Looks good!</div>
            @error('fax_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_address">Address</label>
            <textarea id="hotel_address" name="hotel_address" class="form-control" data-error="Address" placeholder="Address"
                cols="30" rows="2">{{ isset($model->hotel_address) ? $model->hotel_address : old('hotel_address') }}</textarea>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_address')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="hotel_pincode">Pincode</label>
            <input type="text" id="hotel_pincode" name="hotel_pincode" class="form-control"
                placeholder="Pincode"
                value="{{ isset($model->hotel_pincode) ? $model->hotel_pincode : old('hotel_pincode') }}"
                data-error="Pincode" />
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_pincode')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="hotel_email">Email</label>
            <input type="text" id="hotel_email" name="hotel_email" class="form-control" placeholder="Email"
                value="{{ isset($model->hotel_email) ? $model->hotel_email : old('hotel_email') }}"
                data-error="Email" />
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_email')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_freebies">Hotel Freebies</label>
            <a class="badge badge-success freebiesBTN" style="color:#FFF; float: right;">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Freebies
            </a>
            <select class="select2 select2-hotel-freebies form-control" multiple name="hotel_freebies"></select>
            <div class="hotel_freebiesCLS"></div>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_freebies')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_amenities">Hotel Amenities</label>
            <a class="badge badge-success roomAmenityBTN" style="color:#FFF; float: right;">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Amenities
            </a>
            <select class="select2 select2-hotel-amenities form-control" multiple name="hotel_amenities"></select>
            <div class="hotel_amenitiesCLS"></div>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_amenities')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="property_type_id">Property Type</label>
            <a class="badge badge-success PropertyPopup" style="color:#FFF; float: right;">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Property Type
            </a>
            <select class="select2 form-control" id="property_type_id" name="property_type_id"
                data-error="Property Type">
                <option value="">Select Property Type</option>
                @foreach ($propertyTypes as $key => $type)
                    <option value="{{ $type->id }}"
                        {{ $model->property_type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->property_name }}</option>
                @endforeach
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('property_type_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="hotel_review">Rating</label>
            <input type="text" id="hotel_review" name="hotel_review" class="form-control" placeholder="Rating"
                value="{{ isset($model->hotel_review) ? $model->hotel_review : old('hotel_review') }}"
                data-error="Rating" />
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_review')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="hotel_latitude">Latitude</label>
            <input type="text" id="hotel_latitude" name="hotel_latitude" class="form-control"
                placeholder="Latitude"
                value="{{ isset($model->hotel_latitude) ? $model->hotel_latitude : old('hotel_latitude') }}"
                data-error="Latitude" />
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_latitude')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="hotel_longitude">Longitude</label>
            <input type="text" id="hotel_longitude" name="hotel_longitude" class="form-control"
                placeholder="Longitude"
                value="{{ isset($model->hotel_longitude) ? $model->hotel_longitude : old('hotel_longitude') }}"
                data-error="Longitude" />
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_longitude')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="form-label" for="cancel_days">Cancel Days</label>
            <input type="text" id="cancel_days" name="cancel_days" class="form-control"
                placeholder="Cancel Days"
                value="{{ isset($model->cancel_days) ? $model->cancel_days : old('cancel_days') }}"
                data-error="Cancel Days" />
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_review')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

</div>
<div class="row">
    <div class="col-4">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">Front Office</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="front_office_first_name">Name</label>
                <input type="text" id="front_office_first_name" name="front_office_first_name" class="form-control"
                    placeholder="Name"
                    value="{{ isset($model->front_office_first_name) ? $model->front_office_first_name : old('front_office_first_name') }}"
                    data-error="Name" />
                <div class="valid-feedback">Looks good!</div>
                @error('front_office_first_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="front_office_designation">Designation</label>
                <input type="text" id="front_office_designation" name="front_office_designation" class="form-control"
                    placeholder="Designation"
                    value="{{ isset($model->front_office_designation) ? $model->front_office_designation : old('front_office_designation') }}"
                    data-error="Designation" />
                <div class="valid-feedback">Looks good!</div>
                @error('front_office_designation')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="front_office_contact_number">Contact Number</label>
                <input type="text" id="front_office_contact_number" name="front_office_contact_number" class="form-control"
                    placeholder="Contact Number"
                    value="{{ isset($model->reserve_contact_number) ? $model->front_office_contact_number : old('front_office_contact_number') }}"
                    data-error="Contact Number" />
                <div class="valid-feedback">Looks good!</div>
                @error('front_office_contact_number')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="front_office_email">Email</label>
                <input type="text" id="front_office_email" name="front_office_email" class="form-control"
                    placeholder="Email"
                    value="{{ isset($model->front_office_email) ? $model->front_office_email : old('front_office_email') }}"
                    data-error="Email" />
                <div class="valid-feedback">Looks good!</div>
                @error('front_office_email')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">Sales & Management</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="sales_first_name">Name</label>
                <input type="text" id="sales_first_name" name="sales_first_name" class="form-control"
                    placeholder="Name"
                    value="{{ isset($model->sales_first_name) ? $model->sales_first_name : old('sales_first_name') }}"
                    data-error="Name" />
                <div class="valid-feedback">Looks good!</div>
                @error('sales_first_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="sales_designation">Designation</label>
                <input type="text" id="sales_designation" name="sales_designation" class="form-control"
                    placeholder="Designation"
                    value="{{ isset($model->sales_designation) ? $model->sales_designation : old('sales_designation') }}"
                    data-error="Designation" />
                <div class="valid-feedback">Looks good!</div>
                @error('sales_designation')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="sales_contact_number">Contact Number</label>
                <input type="text" id="sales_contact_number" name="sales_contact_number" class="form-control"
                    placeholder="Contact Number"
                    value="{{ isset($model->reserve_contact_number) ? $model->sales_contact_number : old('sales_contact_number') }}"
                    data-error="Contact Number" />
                <div class="valid-feedback">Looks good!</div>
                @error('sales_contact_number')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="sales_email">Email</label>
                <input type="text" id="sales_email" name="sales_email" class="form-control"
                    placeholder="Email"
                    value="{{ isset($model->sales_email) ? $model->sales_email : old('sales_email') }}"
                    data-error="Email" />
                <div class="valid-feedback">Looks good!</div>
                @error('sales_email')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">Reservation</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="reservation_first_name">Name</label>
                <input type="text" id="reservation_first_name" name="reservation_first_name" class="form-control"
                    placeholder="Name"
                    value="{{ isset($model->reservation_first_name) ? $model->reservation_first_name : old('reservation_first_name') }}"
                    data-error="Name" />
                <div class="valid-feedback">Looks good!</div>
                @error('reservation_first_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="reservation_designation">Designation</label>
                <input type="text" id="reservation_designation" name="reservation_designation" class="form-control"
                    placeholder="Designation"
                    value="{{ isset($model->reservation_designation) ? $model->reservation_designation : old('reservation_designation') }}"
                    data-error="Designation" />
                <div class="valid-feedback">Looks good!</div>
                @error('reservation_designation')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="reservation_contact_number">Contact Number</label>
                <input type="text" id="reservation_contact_number" name="reservation_contact_number" class="form-control"
                    placeholder="Contact Number"
                    value="{{ isset($model->reserve_contact_number) ? $model->reservation_contact_number : old('reservation_contact_number') }}"
                    data-error="Contact Number" />
                <div class="valid-feedback">Looks good!</div>
                @error('reservation_contact_number')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="reservation_email">Email</label>
                <input type="text" id="reservation_email" name="reservation_email" class="form-control"
                    placeholder="Email"
                    value="{{ isset($model->reservation_email) ? $model->reservation_email : old('reservation_email') }}"
                    data-error="Email" />
                <div class="valid-feedback">Looks good!</div>
                @error('reservation_email')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="hotel_description">Hotel Description</label>
            <div id="full-wrapper">
                <div id="hdescription">
                    <div class="editor">
                        {{ $model->hotel_description }}
                    </div>
                </div>
                <textarea style="display: none" id="hotel_description" name="hotel_description">{{ $model->hotel_description }}</textarea>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_review')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="cancellation_policy">Cancellation Policy</label>
            <div id="full-wrapper">
                <div id="cpolicy">
                    <div class="editor">
                        {{ $model->cancellation_policy }}
                    </div>
                </div>
                <textarea style="display: none" id="cancellation_policy" name="cancellation_policy">{{ $model->cancellation_policy }}</textarea>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_review')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="cancel_days">Hotel Image</label>
            <div class="dropzone clsbox" id="mydropzone">
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="form-group">
            <label class="form-label" for="cancel_days">Hotel Images Gallery</label>
            <div class="dropzone clsbox" id="hoteldropzone">
            </div>
        </div>
    </div>
</div>


@section('extra-script')
    <script type="text/javascript">
        var moduleConfig = {
            redirectUrl: "{!! route('get-state-list') !!}",
            getCities: "{!! route('get-city-list') !!}",
            addAmenityURL: "{!! route('add-amenity') !!}",
            addGroupURL: "{!! route('add-group') !!}",
            addPropertyURL: "{!! route('add-property') !!}",
            // addStoreURL: "{!! route('offlinehotels.store') !!}",
            addFreebiesURL: "{!! route('add-freebies') !!}",
            indexURL: "{!! route('offlinehotels.index') !!}",
        };
    </script>
    @if ($model->id)
        <script type="text/javascript">
            moduleConfig['addStoreURL'] = "{!! route('offlinehotels.update', $model) !!}";
        </script>
    @else
        <script type="text/javascript">
            moduleConfig['addStoreURL'] = "{!! route('offlinehotels.store') !!}";
        </script>
    @endif
    <script type="text/javascript">
        console.log(moduleConfig);
    </script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>


    <script src="{{ asset('js/form/Offline-Hotel.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("div#mydropzone", {
            url: "/file/post",
            autoProcessQueue: false,
            maxFilesize: 1,
            uploadMultiple: false,
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
                    url: "{{ route('delete-hotel-image') }}",
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

        if ($hotel_image_locationJS) {
            var mockFile = {
                url: '{!! $hotel_image_location !!}'
            };
            myDropzone.emit("addedfile", mockFile);
            myDropzone.emit("thumbnail", mockFile, '{!! $hotel_image_location !!}');
            myDropzone.emit("complete", mockFile);
            var existingFileCount = 1;
            myDropzone.options.maxFiles = myDropzone.options.maxFiles - existingFileCount;
        }

        var myHotelDropzone = new Dropzone("div#hoteldropzone", {
            url: "/file/post",
            autoProcessQueue: false,
            acceptedFiles: 'image/*',
            maxFiles: 20,
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
            createImageThumbnails: true,
            thumbnailWidth: "250",
            thumbnailHeight: "250",
            addRemoveLinks: true,
            removedfile: function(file) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('delete-hotel-gallery-image') }}",
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
                url: img.file_path
            };
            // Call the default addedfile event handler
            myHotelDropzone.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myHotelDropzone.emit("thumbnail", mockFile, img.file_path);
            // Make sure that there is no progress bar, etc...
            myHotelDropzone.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myHotelDropzone.options.maxFiles = myHotelDropzone.options.maxFiles - existingFileCount;

        }

        (function(window, document, $) {
            'use strict';
            var Font = Quill.import('formats/font');
            Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
            Quill.register(Font, true);
            var modulesSettings = {
                formula: true,
                syntax: true,
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                            color: []
                        },
                        {
                            background: []
                        }
                    ],
                    [{
                            script: 'super'
                        },
                        {
                            script: 'sub'
                        }
                    ],
                    [{
                            header: '1'
                        },
                        {
                            header: '2'
                        },
                        'blockquote',
                        'code-block'
                    ],
                    [{
                            list: 'ordered'
                        },
                        {
                            list: 'bullet'
                        },
                        {
                            indent: '-1'
                        },
                        {
                            indent: '+1'
                        }
                    ],
                    [
                        'direction',
                        {
                            align: []
                        }
                    ],
                    ['link', 'image', 'video', 'formula'],
                    ['clean']
                ]
            };
            var hotel_description = new Quill('#hdescription .editor', {
                bounds: '#hdescription .editor',
                modules: modulesSettings,
                theme: 'snow'
            });
            var cancellation_policy = new Quill('#cpolicy .editor', {
                bounds: '#cpolicy .editor',
                modules: modulesSettings,
                theme: 'snow'
            });

            hotel_description.on('text-change', function(delta, oldDelta, source) {
                $('#hotel_description').val(hotel_description.container.firstChild.innerHTML);
            });
            cancellation_policy.on('text-change', function(delta, oldDelta, source) {
                $('#cancellation_policy').val(cancellation_policy.container.firstChild.innerHTML);
            });

            var editors = [hotel_description, cancellation_policy];
        })(window, document, jQuery);
    </script>
@endsection
