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
                            <span class="font-weight-bold">HOTEL DETAILS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-front-office" data-toggle="pill"
                            href="#account-vertical-front-office" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">FRONT OFFICE</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-sales" data-toggle="pill"
                            href="#account-vertical-sales" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">SALES & MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-reservation" data-toggle="pill"
                            href="#account-vertical-reservation" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">RESERVATION</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-galleries-details" data-toggle="pill"
                            href="#account-vertical-galleries-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">GALLERY</span>
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
                                            <strong for="account-username">Country</strong>
                                            <span
                                                class="disp-below">{{ isset($model->country->name) ? $model->country->name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">City</strong>
                                            <span
                                                class="disp-below">{{ isset($model->city->name) ? $model->city->name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Category</strong>
                                            <span
                                                class="disp-below">{{ isset($model->category) ? $model->category : '' }} Star</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Hotel Group</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotelgroup->name) ? $model->hotelgroup->name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Phone Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->phone_number) ? $model->phone_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Fax Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->fax_number) ? $model->fax_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Address</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_address) ? $model->hotel_address : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Pincode</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_pincode) ? $model->hotel_pincode : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Email</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_email) ? $model->hotel_email : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Hotel Freebies</strong>
                                            <span
                                                class="disp-below">{{ $freebiesName }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Hotel Amenities</strong>
                                            <span
                                                class="disp-below">{{ $amenitiesName }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Property Type</strong>
                                            <span
                                                class="disp-below">{{ isset($model->property->property_name) ? $model->property->property_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Rating</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_review) ? $model->hotel_review : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Latitude</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_latitude) ? $model->hotel_latitude : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Longitude</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_longitude) ? $model->hotel_longitude : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Cancel Days</strong>
                                            <span
                                                class="disp-below">{{ isset($model->cancel_days) ? $model->cancel_days : '' }}</span>
                                        </div>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <strong for="account-username"> Hotel Description </strong>
                                            <span
                                                class="disp-below">{!! isset($model->hotel_description) ? $model->hotel_description : '' !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <strong for="account-username">Cancellation Policy</strong>
                                            <span
                                                class="disp-below">{!! isset($model->cancellation_policy) ? $model->cancellation_policy : '' !!}</span>
                                        </div>
                                    </div>
                                 </div>
                                 
                            </div>
                            <div class="tab-pane fade" id="account-vertical-front-office" role="tabpanel"
                                aria-labelledby="account-front-office" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Name</strong>
                                            <span
                                                class="disp-below">{{ isset($model->front_office_first_name) ? $model->front_office_first_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Designation</strong>
                                            <span
                                                class="disp-below">{{ isset($model->front_office_designation) ? $model->front_office_designation : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Contact Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->front_office_contact_number) ? $model->front_office_contact_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Email</strong>
                                            <span
                                                class="disp-below">{{ isset($model->front_office_email) ? $model->front_office_email : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-sales" role="tabpanel"
                                aria-labelledby="account-sales" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Name</strong>
                                            <span
                                                class="disp-below">{{ isset($model->sales_first_name) ? $model->sales_first_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Designation</strong>
                                            <span
                                                class="disp-below">{{ isset($model->sales_designation) ? $model->sales_designation : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Contact Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->sales_contact_number) ? $model->sales_contact_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Email</strong>
                                            <span
                                                class="disp-below">{{ isset($model->sales_email) ? $model->sales_email : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-reservation" role="tabpanel"
                                aria-labelledby="account-reservation" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Name</strong>
                                            <span
                                                class="disp-below">{{ isset($model->reservation_first_name) ? $model->reservation_first_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Designation</strong>
                                            <span
                                                class="disp-below">{{ isset($model->reservation_designation) ? $model->reservation_designation : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Contact Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->reservation_contact_number) ? $model->reservation_contact_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Email</strong>
                                            <span
                                                class="disp-below">{{ isset($model->reservation_email) ? $model->reservation_email : '' }}</span>
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
                                                            @if (strlen($model->hotel_image_location)> 0)
                                                            <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                                                                <img src="{{ url('storage/app/upload/Hotel/' . $model->id . '/'  . $model->hotel_image_location) }}"
                                                                    class="img-fluid d-block w-100" alt="cf-img-1" style="height: 550px !important;" />
                                                            </div>
                                                            @endif
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
