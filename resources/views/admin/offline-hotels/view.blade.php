@extends('admin.layout.app')
@section('page_title', 'Hotel View')
@section('content')
    <section id="page-account-settings">
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">Hotel : #{{ $model->hotel_name }}</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('offlinehotels.index') }}"><button type="reset"
                            class="btn btn-outline-secondary btn-sm  waves-effectt">
                            {{ __('core.back') }}</button></a>
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
                            <span class="font-weight-bold">Hotel Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-front-office" data-toggle="pill"
                            href="#account-vertical-front-office" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">Front Office</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-sales" data-toggle="pill"
                            href="#account-vertical-sales" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">Sales & Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-reservation" data-toggle="pill"
                            href="#account-vertical-reservation" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">Reservation</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-galleries-details" data-toggle="pill"
                            href="#account-vertical-galleries-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">Gallery</span>
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
                                   
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Country</label>
                                            <strong
                                                class="disp-below">{{ isset($model->country->name) ? $model->country->name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">City</label>
                                            <strong
                                                class="disp-below">{{ isset($model->city->name) ? $model->city->name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Category</label>
                                            <strong
                                                class="disp-below">{{ isset($model->category) ? $model->category : '' }} Star</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Hotel Group</label>
                                            <strong
                                                class="disp-below">{{ isset($model->hotelgroup->name) ? $model->hotelgroup->name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Phone Number</label>
                                            <strong
                                                class="disp-below">{{ isset($model->phone_number) ? $model->phone_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Fax Number</label>
                                            <strong
                                                class="disp-below">{{ isset($model->fax_number) ? $model->fax_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Address</label>
                                            <strong
                                                class="disp-below">{{ isset($model->hotel_address) ? $model->hotel_address : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Pincode</label>
                                            <strong
                                                class="disp-below">{{ isset($model->hotel_pincode) ? $model->hotel_pincode : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Email</label>
                                            <strong
                                                class="disp-below">{{ isset($model->hotel_email) ? $model->hotel_email : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Hotel Freebies</label>
                                            <strong
                                                class="disp-below">{{ $freebiesName }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Hotel Amenities</label>
                                            <strong
                                                class="disp-below">{{ $amenitiesName }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Property Type</label>
                                            <strong
                                                class="disp-below">{{ isset($model->property->property_name) ? $model->property->property_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Rating</label>
                                            <strong
                                                class="disp-below">{{ isset($model->hotel_review) ? $model->hotel_review : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Latitude</label>
                                            <strong
                                                class="disp-below">{{ isset($model->hotel_latitude) ? $model->hotel_latitude : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Longitude</label>
                                            <strong
                                                class="disp-below">{{ isset($model->hotel_longitude) ? $model->hotel_longitude : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Cancel Days</label>
                                            <strong
                                                class="disp-below">{{ isset($model->cancel_days) ? $model->cancel_days : '' }}</strong>
                                        </div>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-username"> Hotel Description </label>
                                            <strong
                                                class="disp-below">{!! isset($model->hotel_description) ? $model->hotel_description : '' !!}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-username">Cancellation Policy</label>
                                            <strong
                                                class="disp-below">{!! isset($model->cancellation_policy) ? $model->cancellation_policy : '' !!}</strong>
                                        </div>
                                    </div>
                                 </div>
                                 
                            </div>
                            <div class="tab-pane fade" id="account-vertical-front-office" role="tabpanel"
                                aria-labelledby="account-front-office" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Name</label>
                                            <strong
                                                class="disp-below">{{ isset($model->front_office_first_name) ? $model->front_office_first_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Designation</label>
                                            <strong
                                                class="disp-below">{{ isset($model->front_office_designation) ? $model->front_office_designation : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Contact Number</label>
                                            <strong
                                                class="disp-below">{{ isset($model->front_office_contact_number) ? $model->front_office_contact_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Email</label>
                                            <strong
                                                class="disp-below">{{ isset($model->front_office_email) ? $model->front_office_email : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-sales" role="tabpanel"
                                aria-labelledby="account-sales" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Name</label>
                                            <strong
                                                class="disp-below">{{ isset($model->sales_first_name) ? $model->sales_first_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Designation</label>
                                            <strong
                                                class="disp-below">{{ isset($model->sales_designation) ? $model->sales_designation : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Contact Number</label>
                                            <strong
                                                class="disp-below">{{ isset($model->sales_contact_number) ? $model->sales_contact_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Email</label>
                                            <strong
                                                class="disp-below">{{ isset($model->sales_email) ? $model->sales_email : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-reservation" role="tabpanel"
                                aria-labelledby="account-reservation" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Name</label>
                                            <strong
                                                class="disp-below">{{ isset($model->reservation_first_name) ? $model->reservation_first_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Designation</label>
                                            <strong
                                                class="disp-below">{{ isset($model->reservation_designation) ? $model->reservation_designation : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Contact Number</label>
                                            <strong
                                                class="disp-below">{{ isset($model->reservation_contact_number) ? $model->reservation_contact_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label for="account-username">Email</label>
                                            <strong
                                                class="disp-below">{{ isset($model->reservation_email) ? $model->reservation_email : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-galleries-details" role="tabpanel"
                                aria-labelledby="account-pill-galleries-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Galleries</h4>
                                            </div>
                                            <div class="card-body">
                                                @if ($model->images->count() > 0)
                                                    <div id="carouselExampleFade" class="carousel slide carousel-fade"
                                                        data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @php
                                                                $i = 0;
                                                            @endphp
                                                            @foreach ($model->images as $image)
                                                                
                                                                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                                                    <img src="{{ url('storage/app/upload/Hotel/' . $model->id . '/gallery/'. $image['file_path']) }}"
                                                                        class="img-fluid d-block w-100" alt="cf-img-1" />
                                                                </div>
                                                                @php
                                                                    $i++;
                                                                @endphp
                                                            @endforeach
                                                        </div>
                                                        <a class="carousel-control-prev" href="#carouselExampleFade"
                                                            role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#carouselExampleFade"
                                                            role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                @else
                                                    <p class="card-text">
                                                        Hotel galleries not found!
                                                    </p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
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
