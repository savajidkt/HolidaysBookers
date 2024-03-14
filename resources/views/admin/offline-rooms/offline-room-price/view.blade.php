@extends('admin.layout.app')
@section('page_title', 'Hotel Room')
@section('content')

<div class="card-header border-bottom d-flex justify-content-between align-items-center my-2">
   
    <div class="col-md-6">        
        
        <a class="btn btn-outline-secondary waves-effect" href="{{ route('offlinerooms.edit',$model->room->id) }}">Back</a>
    </div>
    <div class="col-md-6 text-right">                        
         
        <a href="{{ route('add-room-price', $model->room_id) }}" class="btn btn-primary btn-sm waves-effect waves-float waves-light" data-toggle="tooltip" data-original-title="Add Room Price" data-animation="false"><i class="fa fa-plus" aria-hidden="true"></i> Add Room Price</a>                
        <a href="{{ route('edit-room-price', $model->id) }}" class="btn btn-primary btn-sm waves-effect waves-float waves-light" data-toggle="tooltip" data-original-title="Edit Room Price" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i> Edit Room Price</a>                
        <a href="{{ route('room-create', $model->room->hotel->id) }}" class="btn btn-primary btn-sm waves-effect waves-float waves-light" data-toggle="tooltip" data-original-title="Add Room" data-animation="false"><i class="fa fa-plus" aria-hidden="true"></i> Add Room</a>
    </div>    
</div>

    <section id="page-account-settings">
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">Hotel Room Price: #{{ $model->id }}</h4>
                </div>               
            </div>

        </div>
        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column nav-left">
                    <li class="nav-item">
                        <a class="nav-link active" id="account-pill-hotel-details" data-toggle="pill"
                            href="#account-vertical-hotel-details" aria-expanded="true">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">HOTEL DETAILS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-room-details" data-toggle="pill"
                            href="#account-vertical-room-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">ROOM PRICE DETAILS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-galleries-details" data-toggle="pill"
                            href="#account-vertical-galleries-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">ROOM CHILDREN DETAILS</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--/ left menu section -->

            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="account-vertical-hotel-details"
                                aria-labelledby="account-pill-hotel-details" aria-expanded="true">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Hotel Name</label>
                                            <strong
                                                class="disp-below">{{ isset($model->room->hotel->hotel_name) ? $model->room->hotel->hotel_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Room Type</label>
                                            <strong
                                                class="disp-below">{{ isset($model->room->roomtype->room_type) ? $model->room->roomtype->room_type : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Max Occupancy</label>
                                            <strong
                                                class="disp-below">{{ isset($model->room->occ_sleepsmax) ? $model->room->occ_sleepsmax : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">No. of Beds</label>
                                            <strong
                                                class="disp-below">{{ isset($model->room->occ_num_beds) ? $model->room->occ_num_beds : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Max Adults</label>
                                            <strong
                                                class="disp-below">{{ isset($model->room->occ_max_adults) ? $model->room->occ_max_adults : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Max Children When Max Adults</label>
                                            <strong
                                                class="disp-below">{{ isset($model->room->occ_max_child_w_max_adults) ? $model->room->occ_max_child_w_max_adults : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Max Children Without Extra Bed</label>
                                            <strong
                                                class="disp-below">{{ isset($model->room->occ_max_child_wo_extra_bed) ? $model->room->occ_max_child_wo_extra_bed : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-room-details" role="tabpanel"
                                aria-labelledby="account-pill-room-details-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Price Type</label>
                                            <strong
                                                class="disp-below">{{ isset($model->price_type) ? $model::PRICE_TYPE[$model->price_type] : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Travel Date Validity</label>
                                            <strong
                                                class="disp-below">{{ isset($model->from_date) ? dateFormat($model->from_date,'d-m-Y') . ' to ' . dateFormat($model->to_date,'d-m-Y') : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Booking Date Validity</label>
                                            <strong
                                                class="disp-below">{{ isset($model->booking_start_date) ? dateFormat($model->booking_start_date,'d-m-Y') . ' to ' . dateFormat($model->booking_end_date,'d-m-Y') : '' }}</strong>
                                        </div>
                                    </div>
                                     <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Meal Plan</label>
                                            <strong
                                                class="disp-below">{{ isset($model->mealplan->name) ? $model->mealplan->name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Currency</label>
                                            <strong
                                                class="disp-below">{{ isset($model->currency_id) ? getSelectedCurrency($currencyList, $model->currency_id) : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Cut-off for Price</label>
                                            <strong
                                                class="disp-below">{{ isset($model->cutoff_price) ? $model->cutoff_price : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Minimum Nights</label>
                                            <strong
                                                class="disp-below">{{ isset($model->min_nights) ? $model->min_nights : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Minimum Overall Nights</label>
                                            <strong
                                                class="disp-below">{{ isset($model->min_overall_nights) ? $model->min_overall_nights : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Market Price Per Night</label>
                                            <strong
                                                class="disp-below">{{ isset($model->market_price) ? $model->market_price : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Promo Code</label>
                                            <strong
                                                class="disp-below">{{ isset($model->promo_code) ? $model->promo_code : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Rate Offered</label>
                                            <strong
                                                class="disp-below">{{ isset($model->rate_offered) ? $model->rate_offered : '' }}</strong>
                                        </div>
                                    </div>
                                    @if (isset($model->rate_offered) && $model->rate_offered == 'COMMISSIONABLE')
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label for="account-username">Commission %</label>
                                                <strong
                                                    class="disp-below">{{ isset($model->commission) ? $model->commission : '' }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="itemcost">Days Valid</label>
                                            <div class="demo-inline-spacing">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="monday"
                                                        value="monday"
                                                        {{ isset($model->days_monday) && $model->days_monday == 1 ? 'checked disabled' : 'disabled' }} />
                                                    <label class="custom-control-label" for="monday">Monday</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="tuesday"
                                                        value="tuesday"
                                                        {{ isset($model->days_tuesday) && $model->days_tuesday == 1 ? 'checked disabled' : 'disabled' }} />
                                                    <label class="custom-control-label" for="tuesday">Tuesday</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="wednesday"
                                                        value="wednesday"
                                                        {{ isset($model->days_wednesday) && $model->days_wednesday == 1 ? 'checked disabled' : 'disabled' }} />
                                                    <label class="custom-control-label" for="wednesday">Wednesday</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="thursday"
                                                        value="thursday"
                                                        {{ isset($model->days_thursday) && $model->days_thursday == 1 ? 'checked disabled' : 'disabled' }} />
                                                    <label class="custom-control-label" for="thursday">Thursday</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="friday"
                                                        value="friday"
                                                        {{ isset($model->days_friday) && $model->days_friday == 1 ? 'checked disabled' : 'disabled' }} />
                                                    <label class="custom-control-label" for="friday">Friday</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="saturday"
                                                        value="saturday"
                                                        {{ isset($model->days_saturday) && $model->days_saturday == 1 ? 'checked disabled' : 'disabled' }} />
                                                    <label class="custom-control-label" for="saturday">Saturday</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="sunday"
                                                        value="sunday"
                                                        {{ isset($model->days_sunday) && $model->days_sunday == 1 ? 'checked disabled' : 'disabled' }} />
                                                    <label class="custom-control-label" for="sunday">Sunday</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-12">
                                        <div class="d-flex align-items-center mb-1 mt-1">
                                            <h4 class="">Price per night (including all taxes) :</h4>
                                        </div>
                                        <hr class="my-2" />
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Single Adult</label>
                                            <strong
                                                class="disp-below">{{ isset($model->price_p_n_single_adult) ? $model->price_p_n_single_adult : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Per Room</label>
                                            <strong
                                                class="disp-below">{{ isset($model->price_p_n_twin_sharing) ? $model->price_p_n_twin_sharing : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Extra Adult</label>
                                            <strong
                                                class="disp-below">{{ isset($model->price_p_n_extra_adult) ? $model->price_p_n_extra_adult : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Child with Bed</label>
                                            <strong
                                                class="disp-below">{{ isset($model->price_p_n_cwb) ? $model->price_p_n_cwb : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Child no Bed</label>
                                            <strong
                                                class="disp-below">{{ isset($model->price_p_n_cob) ? $model->price_p_n_cob : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Infant/Complimentary child</label>
                                            <strong
                                                class="disp-below">{{ isset($model->price_p_n_ccob) ? $model->price_p_n_ccob : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center mb-1 mt-1">
                                            <h4 class="">Tax per night (included in above price) :</h4>
                                        </div>
                                        <hr class="my-2" />
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Single Adult</label>
                                            <strong
                                                class="disp-below">{{ isset($model->tax_p_n_single_adult) ? $model->tax_p_n_single_adult : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Per Room</label>
                                            <strong
                                                class="disp-below">{{ isset($model->tax_p_n_twin_sharing) ? $model->tax_p_n_twin_sharing : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Extra Adult</label>
                                            <strong
                                                class="disp-below">{{ isset($model->tax_p_n_extra_adult) ? $model->tax_p_n_extra_adult : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Child with Bed</label>
                                            <strong
                                                class="disp-below">{{ isset($model->tax_p_n_cwb) ? $model->tax_p_n_cwb : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Child no Bed</label>
                                            <strong
                                                class="disp-below">{{ isset($model->tax_p_n_cob) ? $model->tax_p_n_cob : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Infant/Complimentary child</label>
                                            <strong
                                                class="disp-below">{{ isset($model->tax_p_n_ccob) ? $model->tax_p_n_ccob : '' }}</strong>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-galleries-details" role="tabpanel"
                                aria-labelledby="account-pill-galleries-details" aria-expanded="false">
                                <div class="row">
                                    @if ($model->childprice->count() > 0)
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($model->childprice as $childs)
                                            @php
                                                $i++;
                                            @endphp
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-1 mt-1">
                                                    <h4 class="">Children Details {{ $i }}</h4>
                                                </div>
                                                <hr class="my-2" />
                                            </div>

                                            <div class="col-12 col-sm-3">
                                                <div class="form-group">
                                                    <label for="account-username">Minimum child age</label>
                                                    <strong
                                                        class="disp-below">{{ isset($childs->min_age) ? $childs->min_age : '' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group">
                                                    <label for="account-username">Maximum child age</label>
                                                    <strong
                                                        class="disp-below">{{ isset($childs->max_age) ? $childs->max_age : '' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group">
                                                    <label for="account-username">Child with bed price</label>
                                                    <strong
                                                        class="disp-below">{{ isset($childs->cwb_price) ? $childs->cwb_price : '' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group">
                                                    <label for="account-username">Child without bed price</label>
                                                    <strong
                                                        class="disp-below">{{ isset($childs->cnb_price) ? $childs->cnb_price : '' }}</strong>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--/ right content section -->
        </div>
    </section>
@endsection
