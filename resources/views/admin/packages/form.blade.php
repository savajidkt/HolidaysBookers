@php
    $images = [];
    if (isset($model->packageimages)) {
        foreach ($model->packageimages as $key => $img) {
            $images[$key]['images'] = url(Storage::url('app/upload/packages/' . $img['package_id'] . '/gallery/' . $img['images_path']));
        }
    }
@endphp

<style>
    .ql-container {
        min-height: 10rem;
        height: 100%;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .ql-editor {
        height: 100%;
        flex: 1;
        overflow-y: auto;
        width: 100%;
    }

    .alert-primary .close {
        color: #EA5455 !important;
    }

    .dropzone .dz-preview .dz-image img {
        display: block;
        width: 120px;
        height: 120px;
    }
</style>
<script>
    var hotelList = {!! json_encode($offlinehotel) !!};
    var RoomTypeList = {!! json_encode($roomTypes) !!};
    var MealPlanList = {!! json_encode($mealPlan) !!};

    var countriesList = {!! json_encode($countries) !!};
    var images = {!! json_encode($images) !!};
    var cityList = {!! json_encode($cities) !!};
    var countrListIDs = {!! json_encode($model->packagecountry->pluck('id')->toArray()) !!};
    var cityListIDs = {!! json_encode($model->packagecity->pluck('id')->toArray()) !!};
    var nationalityIDs = "{!! $model->nationality !!}";
    var PackageMinDate = "{!! date('Y-m-d') !!}";
    var PackageStartDate = "{!! isset($model->valid_from) ? $model->valid_from : '' !!}";
    var PackageEndDate = "{!! isset($model->valid_till) ? $model->valid_till : '' !!}";

    var PackageTravelStartDate = "{!! isset($model->travel_valid_from) ? $model->travel_valid_from : '' !!}";
    var PackageTravelEndDate = "{!! isset($model->travel_valid_till) ? $model->travel_valid_till : '' !!}";
    var PackageSoldStartDate = "{!! isset($model->sold_out_from) ? $model->sold_out_from : '' !!}";
    var PackageSoldEndDate = "{!! isset($model->sold_out_till) ? $model->sold_out_till : '' !!}";

    var PackageItinerariesCount = "{!! isset($model->packageitineraries) ? $model->packageitineraries->count() : 0 !!}";
    var currencyList = {!! json_encode($currencyList) !!};
    var currencyID = "{!! $model->currency_id !!}";
    var mealPalnID = "{!! $model->meal_plan_id !!}";
    var hotelID = "{!! $model->hotel_name_id !!}";
    var RoomTypeID = "{!! $model->room_type_id !!}";
</script>
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">PACKAGE DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label>Package Name</label>
            <input type="text" class="form-control" name="package_name"
                value="{{ isset($model->package_name) ? $model->package_name : old('package_name') }}"
                data-error="Package name is required" />
            @error('package_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label>Package Code</label>
            <input type="text" class="form-control" name="package_code"
                value="{{ isset($model->package_code) ? $model->package_code : old('package_code') }}"
                data-error="Package code is required" />
            @error('package_code')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Package Validity</label>
            <div class="input-group input-daterange">
                <input type="text" name="package_validity" class="form-control package-basic flatpickr-input"
                    placeholder="YYYY-MM-DD To YYYY-MM-DD"
                    value="{{ isset($pricemodel->package_validity) ? $pricemodel->package_validity : old('package_validity') }}"
                    data-error="Package validity is required" />
            </div>
            <div class="PackageValidity"></div>
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemname">Country</label>
            {{-- <a class="badge badge-success addCountryBTN" style="color:#FFF; float: right;">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New Country
            </a> --}}
            <select class="select2-add-country form-control" name="country_ids" data-error="Country is required"
                id="country_ids"></select>
            <div class="addCountryCLS"></div>
            @error('country_ids')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4 myCity">
        <div class="form-group">
            <label for="itemname">City</label>
            {{-- <a class="badge badge-success addCityBTN" style="color:#FFF; float: right;">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New City
            </a> --}}
            <select class="select2-add-city form-control" name="city_ids" id="city_ids"
                data-error="City is required"></select>
            <div class="spinner-border spinner-border-sm hide" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="addCityCLS"></div>
            @error('city_ids')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemname">Nationality</label>
            <select class="select2-nationality form-control" name="nationality"
                data-error="Nationality is required"></select>
            <div class="nationalityCLS"></div>
            @error('nationality')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    {{-- <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Rate Per Adult</label>
            <input type="number" name="rate_per_adult" class="form-control" data-error="Rate per adult is required"
                value="{{ isset($model->rate_per_adult) ? $model->rate_per_adult : old('rate_per_adult') }}" />
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Rate per child (CWB)</label>
            <input type="number" name="rate_per_child_cwb" class="form-control"
                data-error="Rate per child (CWB) is required"
                value="{{ isset($model->rate_per_child_cwb) ? $model->rate_per_child_cwb : old('rate_per_child_cwb') }}" />
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Rate per child (CNB)</label>
            <input type="number" name="rate_per_child_cnb" class="form-control"
                data-error="Rate per child (CNB) is required"
                value="{{ isset($model->rate_per_child_cnb) ? $model->rate_per_child_cnb : old('rate_per_child_cnb') }}" />
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Rate Per Infant(0-2)</label>
            <input type="number" name="rate_per_infant" class="form-control"
                data-error="Rate Per Infant(0-2) is required"
                value="{{ isset($model->rate_per_infant) ? $model->rate_per_infant : old('rate_per_infant') }}" />
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Minimum PAX</label>
            <input type="number" name="minimum_pax" class="form-control" data-error="Minimum Pax is required"
                value="{{ isset($model->minimum_pax) ? $model->minimum_pax : old('minimum_pax') }}" />
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Maximum PAX</label>
            <input type="number" name="maximum_pax" class="form-control" data-error="Maximum Pax is required"
                value="{{ isset($model->maximum_pax) ? $model->maximum_pax : old('maximum_pax') }}" />
        </div>
    </div> --}}
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Cancel Day</label>
            <input type="number" name="cancel_day" class="form-control" data-error="Cancel Day is required"
                value="{{ isset($model->cancel_day) ? $model->cancel_day : old('cancel_day') }}" />
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Terms and Conditions (only pdf) </label>
            @if (strlen($model->terms_and_conditions_pdf) > 0)
                <a target="_blank" title="{{ $model->package_name }}"
                    href="{{ url('storage/app/upload/packages/' . $model->id . '/' . $model->terms_and_conditions_pdf) }}"
                    class="badge badge-success" style="color:#FFF; float: right;">
                    <i class="fa fa-eye" aria-hidden="true"></i> View
                </a>
            @endif
            <input type="file" name="terms_and_conditions_pdf" class="form-control" />
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
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Origin City</label>
            <a class="badge badge-success textBoxCityAdd" data-name="origin_city" style="color:#FFF; float: right;">
                <i class="fa fa-plus" aria-hidden="true"></i> Add City
            </a>
            <input type="text" name="origin_city" class="form-control" data-error="Origin city is required" />
            <input type="hidden" name="total_origin_city" id="total_origin_city"
                value="{{ isset($model->origincityname) ? count($model->origincityname) : 0 }}">
            <div class="total_origin_city_req"></div>
        </div>
        <div class="demo-spacing-0 hide_origin_city {{ isset($model->origincityname) ? '' : 'hide' }}">
            @if (count($model->origincityname) > 0)
                @foreach ($model->origincityname as $origincityname)
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <div class="alert-body">{{ $origincityname->city_name }}</div>
                        <button data-dismiss="alert" aria-label="Close" type="button" class="close"
                            data-id="1" data-name="origin_city">
                            <span aria-hidden="true">×</span>
                        </button>
                        <input type="hidden" name="origin_city_arr[]"
                            value="{{ isset($origincityname->city_name) ? $origincityname->city_name : '' }}">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Inclusion</label>
            <a class="badge badge-success textBoxInclusionAdd" data-name="inclusion"
                style="color:#FFF; float: right;">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Inclusion
            </a>
            <input type="text" name="inclusion" class="form-control" data-error="Inclusion is required" />
            <input type="hidden" name="total_inclusion" id="total_inclusion"
                value="{{ isset($model->inclusionname) ? count($model->inclusionname) : 0 }}">
        </div>

        <div class="demo-spacing-0 hide_inclusion {{ isset($model->inclusionname) ? '' : 'hide' }}">
            @if (count($model->inclusionname) > 0)
                @foreach ($model->inclusionname as $inclusionname)
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <div class="alert-body">{{ $inclusionname->inclusion_name }}</div>
                        <button data-dismiss="alert" aria-label="Close" type="button" class="close"
                            data-id="1" data-name="inclusion">
                            <span aria-hidden="true">×</span>
                        </button>
                        <input type="hidden" name="inclusion_arr[]"
                            value="{{ isset($inclusionname->inclusion_name) ? $inclusionname->inclusion_name : '' }}">
                    </div>
                @endforeach
            @endif
        </div>

    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Exclusion</label>
            <a class="badge badge-success textBoxExclusionAdd" data-name="exclusion"
                style="color:#FFF; float: right;">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Exclusion
            </a>
            <input type="text" name="exclusion" class="form-control" data-error="Exclusion is required" />
            <input type="hidden" name="total_exclusion" id="total_exclusion"
                value="{{ isset($model->exclusionname) ? count($model->exclusionname) : 0 }}">
        </div>
        <div class="demo-spacing-0 hide_exclusion {{ isset($model->exclusionname) ? '' : 'hide' }}">

            @if (count($model->exclusionname) > 0)
                @foreach ($model->exclusionname as $exclusionname)
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <div class="alert-body">{{ $exclusionname->exclusion_name }}</div>
                        <button data-dismiss="alert" aria-label="Close" type="button" class="close"
                            data-id="1" data-name="exclusion">
                            <span aria-hidden="true">×</span>
                        </button>
                        <input type="hidden" name="exclusion_arr[]"
                            value="{{ isset($exclusionname->exclusion_name) ? $exclusionname->exclusion_name : '' }}">
                    </div>
                @endforeach
            @endif

        </div>
    </div>

    <div class="col-md-6 col-6">
        <div class="form-group">
            <label class="form-label" for="Highlights">Highlights</label>
            <textarea name="highlights" class="my-highlights" id="highlights" cols="30" rows="10">{{ isset($model->highlights) ? $model->highlights : '' }}</textarea>
            <div class="valid-feedback">Looks good!</div>
            @error('highlights')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
            <div class="highlightsErr"></div>
        </div>
    </div>
    <div class="col-md-6 col-6">
        <div class="form-group">
            <label class="form-label" for="Terms_and_Conditions">Terms and Conditions</label>
            <textarea name="terms_and_conditions" class="my-terms_and_conditions" id="terms_and_conditions" cols="30"
                rows="10">{{ isset($model->terms_and_conditions) ? $model->terms_and_conditions : '' }}</textarea>
            <div class="valid-feedback">Looks good!</div>
            @error('terms_and_conditions')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
            <div class="terms_and_conditionsErr"></div>
        </div>
    </div>
    <div class="col-md-12 col-12">
        <div class="form-group">
            <label class="form-label" for="image_upload">Image Upload (gif, jpg, png)</label>
            <div class="dropzone clsbox packageGalleryDropzone" id="packageGalleryDropzone" name="package_gallery"
                dropzonegallery="packageGalleryDropzone">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">HOTEL DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-12">
        <div class="form-group">
            <label for="itemname">Hotel Name</label>
            <select class="select2-hotel-name form-control" name="hotel_name_id" data-error="Hotel is required"
                id="hotel_name_id"></select>
            <div class="hotelNameIDCLS"></div>
            @error('hotel_name_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemname">Select Room Type</label>
            <select class="select2-hotel-room-type form-control" name="room_type" data-error="Room type is required"
                id="room_type"></select>
            <div class="room_typeCLS"></div>
            @error('room_type')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemname">Select Meal Plan</label>
            <select class="select2-hotel-meal-paln form-control" name="meal_plan" data-error="Meal plan is required"
                id="meal_plan"></select>
            <div class="meal_planCLS"></div>
            @error('meal_plan')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Travel Valid Date</label>
            <div class="input-group input-daterange">
                <input type="text" name="travel_validity"
                    class="form-control package-travel-basic flatpickr-input" placeholder="YYYY-MM-DD To YYYY-MM-DD"
                    value="" data-error="Travel valid date is required" />
            </div>
            <div class="travel_validity"></div>
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemname">Cut-off for Booking</label>
            <select name="cutoff_price" class="form-control" id="cutoff_price"
                data-error="Cut-off for price is required">
                @php echo forLoopByNumber(0, 60, '' ,'Days', ['90', '120']); @endphp
            </select>
            <div class="hotelNameIDCLS"></div>
            @error('hotel_name_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemname">Min length of stay</label>
            <select class="form-control" name="duration" data-error="Duration required" id="duration">
                <option value="1" {{ isset($model->id) && $model->duration == 1 ? 'selected' : '' }}>One Night
                </option>
                <option value="2" {{ isset($model->id) && $model->duration == 2 ? 'selected' : '' }}>Two Nights
                </option>
                <option value="3" {{ isset($model->id) && $model->duration == 3 ? 'selected' : '' }}>Three Nights
                </option>
                <option value="4" {{ isset($model->id) && $model->duration == 4 ? 'selected' : '' }}>Four Nights
                </option>
                <option value="5" {{ isset($model->id) && $model->duration == 5 ? 'selected' : '' }}>Five Nights
                </option>
                <option value="6" {{ isset($model->id) && $model->duration == 6 ? 'selected' : '' }}>Six Nights
                </option>
                <option value="7" {{ isset($model->id) && $model->duration == 7 ? 'selected' : '' }}>One Week
                </option>
                <option value="14" {{ isset($model->id) && $model->duration == 14 ? 'selected' : '' }}>Two Weeks
                </option>
            </select>
            @error('duration')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 col-4">
        <div class="form-group">
            <label for="itemcost">Sold out dates (if any)</label>
            <div class="input-group input-daterange">
                <input type="text" name="sold_out_dates" class="form-control package-sold-basic flatpickr-input"
                    placeholder="YYYY-MM-DD To YYYY-MM-DD" value="" data-error="Sold out dates is required" />
            </div>
            <div class="sold_out_dates"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">ROOM OCCUPANCY</h4>
        </div>
        <hr class="my-2" />
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-2">
        <div class="form-group">
            <label for="itemname">Max Allowed (Adults + Child)</label>
            <input type="number" name="sleepsmax" class="form-control"
                data-error="Max Allowed (Adults + Child) is required"
                value="{{ isset($model->sleepsmax) ? $model->sleepsmax : 0 }}" />
            @error('sleepsmax')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-2 col-2">
        <div class="form-group">
            <label for="itemname">Max adults allowed in the room</label>
            <input type="number" name="maxadults" class="form-control"
                data-error="Max adults allowed in the room is required"
                value="{{ isset($model->maxadults) ? $model->maxadults : 0 }}" />
            @error('maxadults')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-2 col-2">
        <div class="form-group">
            <label for="itemname">Max children when max adults</label>
            <input type="number" name="maxchildwmaxadults" class="form-control"
                data-error="Max children when max adults is required"
                value="{{ isset($model->maxchildwmaxadults) ? $model->maxchildwmaxadults : 0 }}" />
            @error('maxchildwmaxadults')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-2 col-2">
        <div class="form-group">
            <label for="itemname">Max children without extra bed</label>
            <input type="number" name="maxchildwoextrabed" class="form-control"
                data-error="Max children without extra bed is required"
                value="{{ isset($model->maxchildwoextrabed) ? $model->maxchildwoextrabed : 0 }}" />
            @error('maxchildwoextrabed')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-2 col-2">
        <div class="form-group">
            <label for="itemname">Min. Child with bed age</label>
            <input type="number" name="mincwbage" class="form-control"
                data-error="Min. Child with bed age is required"
                value="{{ isset($model->mincwbage) ? $model->mincwbage : 0 }}" />
            @error('mincwbage')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-2 col-2">
        <div class="form-group">
            <label for="itemname">Min. Child w/o bed age</label>
            <input type="number" name="mincwobage" class="form-control"
                data-error="Min. Child w/o bed age is required"
                value="{{ isset($model->mincwobage) ? $model->mincwobage : 0 }}" />
            @error('mincwobage')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">ADD PRICING (PER ROOM PER NIGHT)</h4>
        </div>
        <hr class="my-2" />
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label class="form-label" for="role">Currency</label>
            <select class="select2-room-currency form-control" name="currency_id"
                data-error="Currency is required"></select>
            <div class="CurrencyError"></div>
            @error('currency_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Market Price Per Night</label>
            <input type="number" name="marketprice" class="form-control"
                data-error="Market price per night is required"
                value="{{ isset($model->marketprice) ? $model->marketprice : 0 }}" />
            @error('marketprice')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Rate Offered</label>
            <select name="rate_offered" class="form-control" id="rate_offered"
                data-error="Rate offered is required">
                <option value="NET_RATE"
                    {{ isset($pricemodel->id) && $pricemodel->rate_offered == 'NET_RATE' ? 'selected' : '' }}>Net
                    Rate</option>
                <option value="COMMISSIONABLE"
                    {{ isset($pricemodel->id) && $pricemodel->rate_offered == 'COMMISSIONABLE' ? 'selected' : '' }}>
                    Commissionable</option>
            </select>
            @error('rate_offered')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div
        class="col-3 is_rate_offered {{ strlen($model->rate_offered) > 0 && $model->rate_offered == 'COMMISSIONABLE' ? 'show' : 'hide' }}">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Commission %</label>
                <select name="commission" class="form-control" id="commission" data-error="Commission is required">
                    @php echo forLoopByNumber(5, 50, isset($model->commission) ? $model->commission : '', '%'); @endphp
                </select>
                @error('commission')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Single Sharing</label>
            <input type="number" name="singleadult" class="form-control" data-error="Single sharing is required"
                value="{{ isset($model->singleadult) ? $model->singleadult : 0 }}" />
            @error('singleadult')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Twin Sharing</label>
            <input type="number" name="twinsharing" class="form-control" data-error="Twin sharing is required"
                value="{{ isset($model->twinsharing) ? $model->twinsharing : 0 }}" />
            @error('twinsharing')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Extra Adult</label>
            <input type="number" name="extraadult" class="form-control" data-error="Extra adult is required"
                value="{{ isset($model->extraadult) ? $model->extraadult : 0 }}" />
            @error('extraadult')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Child with bed</label>
            <input type="number" name="cwb" class="form-control" data-error="Child with bed is required"
                value="{{ isset($model->cwb) ? $model->cwb : 0 }}" />
            @error('cwb')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Child without bed</label>
            <input type="number" name="cob" class="form-control" data-error="Child without bed is required"
                value="{{ isset($model->cob) ? $model->cob : 0 }}" />
            @error('cob')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Infant/Complimentary child</label>
            <input type="number" name="ccob" class="form-control"
                data-error="Infant/Complimentary child is required"
                value="{{ isset($model->ccob) ? $model->ccob : 0 }}" />
            @error('ccob')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">TAX INCLUDED IN ABOVE PRICES (PER ROOM PER NIGHT)</h4>
        </div>
        <hr class="my-2" />
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Single Sharing</label>
            <input type="number" name="singleadulttax" class="form-control" data-error="Single sharing is required"
                value="{{ isset($model->singleadulttax) ? $model->singleadulttax : 0 }}" />
            @error('singleadulttax')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Twin Sharing</label>
            <input type="number" name="twinsharingtax" class="form-control" data-error="Twin sharing is required"
                value="{{ isset($model->twinsharingtax) ? $model->twinsharingtax : 0 }}" />
            @error('twinsharingtax')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Extra Adult</label>
            <input type="number" name="extraadulttax" class="form-control" data-error="Extra adult is required"
                value="{{ isset($model->extraadulttax) ? $model->extraadulttax : 0 }}" />
            @error('extraadulttax')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Child with bed</label>
            <input type="number" name="cwbtax" class="form-control" data-error="Child with bed is required"
                value="{{ isset($model->cwbtax) ? $model->cwbtax : 0 }}" />
            @error('cwbtax')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Child without bed</label>
            <input type="number" name="cobtax" class="form-control" data-error="Child without bed is required"
                value="{{ isset($model->cobtax) ? $model->cobtax : 0 }}" />
            @error('cobtax')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-3">
        <div class="form-group">
            <label for="itemname">Infant/Complimentary child</label>
            <input type="number" name="ccobtax" class="form-control"
                data-error="Infant/Complimentary child is required"
                value="{{ isset($model->ccobtax) ? $model->ccobtax : 0 }}" />
            @error('ccobtax')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <hr class="my-2" />
    </div>
</div>
<div data-repeater-list="packages" class="repeaterCLS">
    @if ($model->packageitineraries->count() > 0)
        @php
            $i = 0;
        @endphp
        @foreach ($model->packageitineraries as $childs)
            <div data-repeater-item>
                <div class="row d-flex ">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-1 mt-1">
                            <h5 class="packageTitile" id="package-1" package-title="package-name">Itinerary Item 1
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label>Heading</label>
                            <input type="hidden" name="edit_id" value="{{ $childs->id }}" />
                            <input type="hidden" name="edit_package_id" value="{{ $childs->package_id }}" />
                            <input type="text" class="form-control" name="heading"
                                value="{{ isset($childs->heading) ? $childs->heading : old('heading') }}"
                                data-error="Heading is required" />
                            @error('heading')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" class="form-control" name="display_order"
                                value="{{ isset($childs->display_order) ? $childs->display_order : old('display_order') }}"
                                data-error="Display order is required" />
                            @error('display_order')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label class="form-label" for="description">Description</label>
                            <textarea name="description" data-desc="description" class="my-description" id="my-description-{{ $i }}"
                                cols="30" rows="10">{{ isset($childs->description) ? $childs->description : old('description') }}</textarea>
                            <div class="valid-feedback">Looks good!</div>
                            @error('description')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
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
            @php
                $i++;
            @endphp
        @endforeach
    @else
        <div data-repeater-item>
            <div class="row d-flex ">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-1 mt-1">
                        <h5 class="packageTitile" id="package-1" package-title="package-name">Itinerary Item 1</h5>
                    </div>
                </div>
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <label>Heading</label>
                        <input type="text" class="form-control" name="heading" value="{{ old('heading') }}"
                            data-error="Heading is required" />
                        @error('heading')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" class="form-control" name="display_order"
                            value="{{ old('display_order') }}" data-error="Display order is required" />
                        @error('display_order')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" data-desc="description" class="my-description" id="my-description-0" cols="30"
                            rows="10"></textarea>
                        <div class="valid-feedback">Looks good!</div>
                        @error('description')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
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
    @endif


</div>
<div class="row mb-2">
    <div class="col-12">
        <button class="btn btn-icon btn-primary " type="button" data-repeater-create>
            <i data-feather="plus"></i>
            <span>Add More Itinerary</span>
        </button>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('js/form/Packages.js') }}"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
    <!-- END: Page JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater-without-dropzone.js') }}"></script>
    <!-- END: Page JS-->
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    {{-- <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script> --}}
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <script type="text/javascript">
        var packageBasic = $('.package-basic');
        if (packageBasic.length) {
            packageBasic.flatpickr({
                minDate: PackageMinDate,
                mode: 'range',
                defaultDate: [PackageStartDate, PackageEndDate]
            });
        }
        var packageTravelBasic = $('.package-travel-basic');
        if (packageTravelBasic.length) {
            packageTravelBasic.flatpickr({
                minDate: PackageMinDate,
                mode: 'range',
                defaultDate: [PackageTravelStartDate, PackageTravelEndDate]
            });
        }
        var packageSoldBasic = $('.package-sold-basic');
        if (packageSoldBasic.length) {
            packageSoldBasic.flatpickr({
                minDate: PackageMinDate,
                mode: 'range',
                defaultDate: [PackageSoldStartDate, PackageSoldEndDate]
            });
        }

        Dropzone.autoDiscover = false;
        var packageGalleryDropzone = new Dropzone("div#packageGalleryDropzone", {
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

        // If you use jQuery, you can use the jQuery plugin Dropzone ships with:
        for (let i = 0; i < images.length; i++) {
            let img = images[i];
            // Create the mock file:
            var mockFile = {
                url: img.images
            };
            // Call the default addedfile event handler
            packageGalleryDropzone.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            packageGalleryDropzone.emit("thumbnail", mockFile, img.images);
            // Make sure that there is no progress bar, etc...
            packageGalleryDropzone.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            packageGalleryDropzone.options.maxFiles = packageGalleryDropzone.options.maxFiles - existingFileCount;

        }

        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
        CKEDITOR.replace('highlights', options);
        CKEDITOR.replace('terms_and_conditions', options);
        if (PackageItinerariesCount) {
            for (let i = 0; i <= PackageItinerariesCount; i++) {
                CKEDITOR.replace('my-description-' + i, options);
            }
        } else {
            CKEDITOR.replace('my-description-0', options);
        }
    </script>
    <script type="text/javascript">
        var moduleConfig = {
            getCitiesByCountryURL: "{!! route('get-cities-by-country-url', '') !!}",
            addPackageURL: "{{ isset($model->id) ? route('packages.update', $model) : route('packages.store') }}",
            listPackageURL: "{!! route('packages.index') !!}",
            getHotelWiseRoomTypeURL: "{!! route('get-room-type-by-hotel-url', '') !!}",
        };
    </script>
@endsection
