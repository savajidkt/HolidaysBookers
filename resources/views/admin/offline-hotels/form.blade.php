<script>
    var HotelsAmenities = {!! json_encode($HotelsAmenities) !!};
</script>
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
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_country">Country</label>
            <select class="select2 form-control form-control-lg" id="hotel_country" name="hotel_country"
                data-error="{{ __('agent/agent.hotel_country') }}">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $model->agent_country == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}</option>
                @endforeach
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_country')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group myState">
            <label class="form-label" for="hotel_state">State</label>
            <select class="select2 form-control form-control-lg" id="hotel_state" name="hotel_state" data-error="State">
                <option value="">Select State</option>
                @php $states = getCountryStates($model->hotel_state);  @endphp
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
    </div>
    <div class="col-4">
        <div class="form-group myCity">
            <label class="form-label" for="hotel_city">City</label>
            <select class="select2 form-control form-control-lg" id="hotel_city" name="hotel_city" data-error="City">
                <option value="">Select City</option>
                @php $cities = getStateCities($model->hotel_city);  @endphp
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
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="category">Category</label>
            <select class="select2 form-control form-control-lg" id="category" name="category" data-error="Category">
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
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_group_id">Hotel Group</label>
            <select class="select2 form-control form-control-lg" id="hotel_group_id" name="hotel_group_id"
                data-error="Hotel Group">
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
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control"
                placeholder="Phone Number"
                value="{{ isset($model->phone_number) ? $model->phone_number : old('phone_number') }}"
                data-error="Phone Number" />
            <div class="valid-feedback">Looks good!</div>
            @error('phone_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
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
    <div class="col-4">
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

    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_email">Email</label>
            <input type="text" id="hotel_email" name="hotel_email" class="form-control" placeholder="Email"
                value="{{ isset($model->agent_email) ? $model->agent_email : old('hotel_email') }}"
                data-error="Email" />
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_email')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_amenities">Hotel Amenities</label>
            <select class="select2 select2-hotel-amenities form-control" multiple name="hotel_amenities"></select>
            <div class="hotel_amenitiesCLS"></div>

            <div class="valid-feedback">Looks good!</div>
            @error('hotel_amenities')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="property_type_id">Property Type</label>
            <input type="text" id="property_type_id" name="property_type_id" class="form-control"
                placeholder="Property Type"
                value="{{ isset($model->property_type_id) ? $model->property_type_id : old('property_type_id') }}"
                data-error="Property Type" />
            <div class="valid-feedback">Looks good!</div>
            @error('property_type_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
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
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_latitude">Rating</label>
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
    <div class="col-4">
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
    <div class="col-4">
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
        };
    </script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-quill-editor.js') }}"></script>
    
    <script src="{{ asset('js/form/Offline-Hotel.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        // Dropzone class:
        var myDropzone = new Dropzone("div#mydropzone", {
            url: "/file/post",
            autoProcessQueue: false,
            maxFilesize: 1,
            acceptedFiles: 'image/*',
        });
        var myHotelDropzone = new Dropzone("div#hoteldropzone", {
            url: "/file/post",
            autoProcessQueue: false,
            acceptedFiles: 'image/*',
        });
        // If you use jQuery, you can use the jQuery plugin Dropzone ships with:
        $("div#myDrop").dropzone({
            url: "/file/post"
            
        });
    </script>
@endsection
