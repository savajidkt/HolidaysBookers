
<script>
    var HotelsList = "";
    var HotelsRoomType = "";
    var HotelsRoomMealPlan = {!! json_encode($HotelsRoomMealPlan) !!};
    var HotelsAmenities = "";
    var HotelsFreebies = "";
    var HotelsRoomID = "";
    var HotelsRoomMealPlanID = "{!! $pricemodel->meal_plan_id !!}";    
    var HotelsAmenitiesIDs = "";
    var HotelsFreebiesIDs = "";
    var HotelID = "";
    var currencyList = {!! json_encode($currencyList) !!};
    var currencyIDs = "{!! $pricemodel->currency_id !!}";

    var RoomMinDate = "{!! date('Y-m-d') !!}";
    var TravelStartDate = "{!! isset($pricemodel->from_date) ? $pricemodel->from_date : '' !!}";
    var TravelEndDate = "{!! isset($pricemodel->to_date) ? $pricemodel->to_date : '' !!}";
    var BookingStartDate = "{!! isset($pricemodel->booking_start_date) ? $pricemodel->booking_start_date : '' !!}";
    var BookingEndDate = "{!! isset($pricemodel->booking_end_date) ? $pricemodel->booking_end_date : '' !!}";
</script>
<style>
    .input-group-addon {
        padding: 10px;
        background: #6E6B7B;
        color: #FFF;
    }

    .mrgin_top_21 {
        margin-top: 21px;
    }
</style>
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
            <label for="account-username">Max Occupancy</label>
            <strong class="disp-below">{{ isset($model->occ_sleepsmax) ? $model->occ_sleepsmax : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">No. of Beds</label>
            <strong class="disp-below">{{ isset($model->occ_num_beds) ? $model->occ_num_beds : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">Max Adults</label>
            <strong class="disp-below">{{ isset($model->occ_max_adults) ? $model->occ_max_adults : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">Max Children When Max Adults</label>
            <strong
                class="disp-below">{{ isset($model->occ_max_child_w_max_adults) ? $model->occ_max_child_w_max_adults : '' }}</strong>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <label for="account-username">Max Children Without Extra Bed</label>
            <strong
                class="disp-below">{{ isset($model->occ_max_child_wo_extra_bed) ? $model->occ_max_child_wo_extra_bed : '' }}</strong>
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
                        <input type="radio" id="Promotional" name="price_type" class="custom-control-input"
                            value="3" {{ $pricemodel->price_type == 3 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="Promotional">Promotional</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="BlackoutSale" name="price_type" class="custom-control-input"
                            value="2" {{ $pricemodel->price_type == 2 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="BlackoutSale">Blackout Sale</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="StopSale" name="price_type" class="custom-control-input"
                            value="0"
                            {{ strlen($pricemodel->price_type) > 0 && $pricemodel->price_type == 0 ? 'checked' : '' }}>
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
                <label for="itemcost">Travel Date Validity</label>
                <div class="input-group input-daterange">
                    <input type="text" id="start_date" name="start_date"
                        class="form-control start-date-basic flatpickr-input" placeholder="YYYY-MM-DD To YYYY-MM-DD"
                        placeholder="Start Date" data-error="Start Date is required" />
                </div>
                <div class="TravelDateValidity"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Booking Date Validity</label>
                <div class="input-group input-daterange">
                    <input type="text" name="booking_start_date"
                        class="form-control booking-basic flatpickr-input" placeholder="YYYY-MM-DD To YYYY-MM-DD"
                        value="{{ isset($pricemodel->booking_start_date) ? $pricemodel->booking_start_date : old('booking_start_date') }}"
                        data-error="Booking start date is required" />
                </div>
                <div class="BookingDateValidity"></div>
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemname">Room Meal Plan</label>
                <a class="badge badge-success roomMealPlanBTN" style="color:#FFF; float: right;">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New Meal Plan
                </a>
                <select class="select2-room-meal-plan form-control" name="meal_plan"></select>
                <div class="room_MealPlanCLS"></div>
                @error('meal_plan')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="col-md-12 col-12">
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
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label class="form-label" for="role">Cut-off for Price</label>
                <select name="cutoff_price" class="form-control" id="cutoff_price"
                    data-error="Cut-off for price is required">
                    @php echo forLoopByNumber(0, 60,  isset($pricemodel->cutoff_price) ? $pricemodel->cutoff_price : '' ,'Days', ['90', '120']); @endphp
                </select>
                @error('cutoff_price')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label class="form-label" for="role">Minimum Nights</label>
                <select name="min_nights" class="form-control" id="min_nights"
                    data-error="Minimum nights is required">
                    @php echo forLoopByNumber(0, 20, isset($pricemodel->min_nights) ? $pricemodel->min_nights : ''); @endphp
                </select>
                @error('min_nights')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label class="form-label" for="role">Minimum Overall Nights</label>
                <select name="min_overall_nights" class="form-control" id="min_overall_nights"
                    data-error="Minimum overall nights is required">
                    @php echo forLoopByNumber(0, 20, isset($pricemodel->min_overall_nights) ? $pricemodel->min_overall_nights : ''); @endphp
                </select>
                @error('min_overall_nights')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <h4 class="">Price per night (including all taxes) :</h4>
        </div>
        <hr class="my-2" />
    </div>


    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Single Adult</label>
                <input type="number" class="form-control" name="price_p_n_single_adult"
                    value="{{ isset($pricemodel->price_p_n_single_adult) ? $pricemodel->price_p_n_single_adult : old('price_p_n_single_adult') }}"
                    data-error="Single adult is required" />
                @error('price_p_n_single_adult')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Per Room</label>
                <input type="number" class="form-control" name="price_p_n_twin_sharing"
                    value="{{ isset($pricemodel->price_p_n_twin_sharing) ? $pricemodel->price_p_n_twin_sharing : old('price_p_n_twin_sharing') }}"
                    data-error="Per room is required" />
                @error('price_p_n_twin_sharing')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Extra Adult</label>
                <input type="number" class="form-control" name="price_p_n_extra_adult"
                    value="{{ isset($pricemodel->price_p_n_extra_adult) ? $pricemodel->price_p_n_extra_adult : old('price_p_n_extra_adult') }}"
                    data-error="Extra adult is required" />
                @error('price_p_n_extra_adult')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Child with Bed</label>
                <input type="number" class="form-control" name="price_p_n_cwb"
                    value="{{ isset($pricemodel->price_p_n_cwb) ? $pricemodel->price_p_n_cwb : old('price_p_n_cwb') }}"
                    data-error="Child with bed is required" />
                @error('price_p_n_cwb')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Child no Bed</label>
                <input type="number" class="form-control" name="price_p_n_cob"
                    value="{{ isset($pricemodel->price_p_n_cob) ? $pricemodel->price_p_n_cob : old('price_p_n_cob') }}"
                    data-error="Child no bed is required" />
                @error('price_p_n_cob')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Infant/Complimentary child</label>
                <input type="number" class="form-control" name="price_p_n_ccob"
                    value="{{ isset($pricemodel->price_p_n_ccob) ? $pricemodel->price_p_n_ccob : old('price_p_n_ccob') }}"
                    data-error="Infant/Complimentary child is required" />
                @error('price_p_n_ccob')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <h4 class="">Tax per night (included in above price) :</h4>
        </div>
        <hr class="my-2" />
    </div>

    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Single Adult</label>
                <input type="number" class="form-control" name="tax_p_n_single_adult"
                    value="{{ isset($pricemodel->tax_p_n_single_adult) ? $pricemodel->tax_p_n_single_adult : old('tax_p_n_single_adult') }}"
                    data-error="Single adult is required" />
                @error('tax_p_n_single_adult')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Per Room</label>
                <input type="number" class="form-control " name="tax_p_n_twin_sharing"
                    value="{{ isset($pricemodel->tax_p_n_twin_sharing) ? $pricemodel->tax_p_n_twin_sharing : old('tax_p_n_twin_sharing') }}"
                    data-error="Per room is required" />
                @error('tax_p_n_twin_sharing')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Extra Adult</label>
                <input type="number" class="form-control " name="tax_p_n_extra_adult"
                    value="{{ isset($pricemodel->tax_p_n_extra_adult) ? $pricemodel->tax_p_n_extra_adult : old('tax_p_n_extra_adult') }}"
                    data-error="Extra adult is required" />
                @error('tax_p_n_extra_adult')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Child with Bed</label>
                <input type="number" class="form-control " name="tax_p_n_cwb"
                    value="{{ isset($pricemodel->tax_p_n_cwb) ? $pricemodel->tax_p_n_cwb : old('tax_p_n_cwb') }}"
                    data-error="Child with bed is required" />
                @error('tax_p_n_cwb')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Child no Bed</label>
                <input type="number" class="form-control " name="tax_p_n_cob"
                    value="{{ isset($pricemodel->tax_p_n_cob) ? $pricemodel->tax_p_n_cob : old('tax_p_n_cob') }}"
                    data-error="Child no bed is required" />
                @error('tax_p_n_cob')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Infant/Complimentary child</label>
                <input type="number" class="form-control " name="tax_p_n_ccob"
                    value="{{ isset($pricemodel->tax_p_n_ccob) ? $pricemodel->tax_p_n_ccob : old('tax_p_n_ccob') }}"
                    data-error="Infant/Complimentary child is required" />
                @error('tax_p_n_ccob')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-12">
        <hr class="my-2" />
    </div>
    <div class="col-3">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Market Price Per Night</label>
                <input type="number" class="form-control" name="market_price" placeholder="Market Price Per Night"
                    value="{{ isset($pricemodel->market_price) ? $pricemodel->market_price : old('market_price') }}"
                    data-error="Market price per night is required" />
                @error('market_price')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Promo Code</label>
                <input type="text" class="form-control" name="promo_code" placeholder="Promo Code"
                    value="{{ isset($pricemodel->promo_code) ? $pricemodel->promo_code : old('promo_code') }}"
                    data-error="Promo code is required" />
                <small class="text-muted" style="font-size: 10px;">Sent at the time of confirmation mail</small>
                @error('promo_code')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Rate Offered</label>
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
    </div>
    <div
        class="col-3 is_rate_offered {{ strlen($pricemodel->rate_offered) > 0 && $pricemodel->rate_offered == 'COMMISSIONABLE' ? 'show' : 'hide' }}">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Commission %</label>
                <select name="commission" class="form-control" id="commission" data-error="Commission is required">
                    @php echo forLoopByNumber(5, 50, isset($pricemodel->commission) ? $pricemodel->commission : '', '%'); @endphp
                </select>
                @error('commission')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="itemcost">Days Valid</label>
                <div class="demo-inline-spacing">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="monday" value="monday"
                            name="days_monday"
                            {{ isset($pricemodel->days_monday) && $pricemodel->days_monday == 1 ? 'checked' : '' }} />
                        <label class="custom-control-label" for="monday">Monday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="tuesday" value="tuesday"
                            name="days_tuesday"
                            {{ isset($pricemodel->days_tuesday) && $pricemodel->days_tuesday == 1 ? 'checked' : '' }} />
                        <label class="custom-control-label" for="tuesday">Tuesday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="wednesday" value="wednesday"
                            name="days_wednesday"
                            {{ isset($pricemodel->days_wednesday) && $pricemodel->days_wednesday == 1 ? 'checked' : '' }} />
                        <label class="custom-control-label" for="wednesday">Wednesday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="thursday" value="thursday"
                            name="days_thursday"
                            {{ isset($pricemodel->days_thursday) && $pricemodel->days_thursday == 1 ? 'checked' : '' }} />
                        <label class="custom-control-label" for="thursday">Thursday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="friday" value="friday"
                            name="days_friday"
                            {{ isset($pricemodel->days_friday) && $pricemodel->days_friday == 1 ? 'checked' : '' }} />
                        <label class="custom-control-label" for="friday">Friday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="saturday" value="saturday"
                            name="days_saturday"
                            {{ isset($pricemodel->days_saturday) && $pricemodel->days_saturday == 1 ? 'checked' : '' }} />
                        <label class="custom-control-label" for="saturday">Saturday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="sunday" value="sunday"
                            name="days_sunday"
                            {{ isset($pricemodel->days_sunday) && $pricemodel->days_sunday == 1 ? 'checked' : '' }} />
                        <label class="custom-control-label" for="sunday">Sunday</label>
                    </div>
                </div>

                @error('double_occupancy')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
            <div class="days_validError"></div>
        </div>
    </div>
</div>
<hr class="my-2" />
<div data-repeater-list="childrens" class="repeaterCLS">
    @if ($pricemodel->childprice->count() > 0)
        @foreach ($pricemodel->childprice as $childs)
            <div data-repeater-item>

                <input type="hidden" name="id" value="{{ $childs->id }}" />
                <input type="hidden" name="room_id" value="{{ $childs->room_id }}" />
                <input type="hidden" name="price_id" value="{{ $childs->price_id }}" />

                <div class="row d-flex align-items-end">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-1 mt-1">
                            <h5 class="childTitile" id="child-1" child-title="child-name">Children Details 1</h5>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="itemcost">Minimum child age</label>
                                <input type="number" class="form-control" name="main_age"
                                    value="{{ isset($childs->min_age) ? $childs->min_age : old('min_age') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="itemcost">Maximum child age</label>
                                <input type="number" class="form-control" name="max_age"
                                    value="{{ isset($childs->max_age) ? $childs->max_age : old('max_age') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="itemcost">Child with bed price</label>
                                <input type="number" class="form-control" name="cwb_price"
                                    value="{{ isset($childs->cwb_price) ? $childs->cwb_price : old('cwb_price') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="itemcost">Child without bed price</label>
                                <input type="number" class="form-control" name="cnb_price"
                                    value="{{ isset($childs->cnb_price) ? $childs->cnb_price : old('cnb_price') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row col-4">
                        <div class="col-md-2 col-12 mb-50">
                            <div class="form-group">
                                <button data-delete="{{ $childs->id }}"
                                    class="btn btn-outline-danger btn-sm  text-nowrap px-1" data-repeater-delete
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
                            <label for="itemcost">Minimum child age</label>
                            <input type="number" class="form-control" name="main_age" />
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="itemcost">Maximum child age</label>
                            <input type="number" class="form-control" name="max_age" />
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="itemcost">Child with bed price</label>
                            <input type="number" class="form-control" name="cwb_price" />
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="itemcost">Child without bed price</label>
                            <input type="number" class="form-control" name="cnb_price" />
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
    @endif
</div>
<div class="row">
    <div class="col-12">
        <button class="btn btn-icon btn-primary " type="button" data-repeater-create>
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
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <!-- BEGIN: Page JS-->
    <!-- BEGIN: Page JS-->

    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater-without-dropzone.js') }}"></script>


    <!-- END: Page JS-->
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
            deleteRepeterURL: "{!! route('delete-repeter') !!}",
        };
    </script>    
@endsection
