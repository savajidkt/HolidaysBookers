@extends('admin.layout.app')
@section('page_title', 'Hotel Room')
@section('content')
    <section id="page-account-settings">
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">Hotel Room: #{{ $model->id }}</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('customers.index') }}"><button type="reset"
                            class="btn btn-outline-secondary waves-effectt">
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
                            <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">Hotel</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-room-details" data-toggle="pill"
                            href="#account-vertical-room-details" aria-expanded="false">
                            <i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">ROOM DETAILS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-room-price-details" data-toggle="pill"
                            href="#account-vertical-room-price-details" aria-expanded="false">
                            <i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">ROOM PRICE</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-children-details" data-toggle="pill"
                            href="#account-vertical-children-details" aria-expanded="false">
                            <i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">CHILDREN DETAILS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-galleries-details" data-toggle="pill"
                            href="#account-vertical-galleries-details" aria-expanded="false">
                            <i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">GALLERIES</span>
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
                                                class="disp-below">{{ isset($model->hotel->hotel_name) ? $model->hotel->hotel_name : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-room-details" role="tabpanel"
                                aria-labelledby="account-pill-room-details-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Room Type</label>
                                            <strong
                                                class="disp-below">{{ isset($model->roomtype->room_type) ? $model->roomtype->room_type : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Room Amenities</label>
                                            <strong
                                                class="disp-below">{{ isset($model->amenity->amenity_name) ? $model->amenity->amenity_name : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-pill-room-price-details" role="tabpanel"
                                aria-labelledby="account-pill-room-price-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Email</label>
                                            <strong
                                                class="disp-below">{{ isset($model->user->email) ? $model->user->email : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-pill-children-details" role="tabpanel"
                                aria-labelledby="account-pill-children-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Email</label>
                                            <strong
                                                class="disp-below">{{ isset($model->user->email) ? $model->user->email : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-pill-galleries-details" role="tabpanel"
                                aria-labelledby="account-pill-galleries-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Email</label>
                                            <strong
                                                class="disp-below">{{ isset($model->user->email) ? $model->user->email : '' }}</strong>
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
