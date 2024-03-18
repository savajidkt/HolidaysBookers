@extends('admin.layout.app')
@section('page_title', 'Customer')
@section('content')
    <section id="page-account-settings">
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">Customer Profile: #{{ $model->id }}</h4>
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
                    <!-- customer-details -->
                    <li class="nav-item">
                        <a class="nav-link active" id="account-pill-customer-details" data-toggle="pill"
                            href="#account-vertical-customer-details" aria-expanded="true">
                            <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">CUSTOMER DETAILS</span>
                        </a>
                    </li>
                    <!-- access-details -->
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-access-details" data-toggle="pill"
                            href="#account-vertical-access-details" aria-expanded="false">
                            <i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">ACCESS DETAILS</span>
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
                            <!-- company-details tab -->
                            <div role="tabpanel" class="tab-pane active" id="account-vertical-customer-details"
                                aria-labelledby="account-pill-customer-details" aria-expanded="true">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">First Name</strong>
                                            <span
                                                class="disp-below">{{ isset($model->first_name) ? $model->first_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Last Name</strong>

                                            <span
                                                class="disp-below">{{ isset($model->last_name) ? $model->last_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Date Of Birth</strong>
                                            <span class="disp-below">{{(isset($model->customers->dob))? dateFormat($model->customers->dob,'d/m/Y'):''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Country</strong>                                            
                                            <span class="disp-below">{{ isset($model->customers->countryname->name) ? $model->customers->countryname->name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">State</strong>                                           
                                            <span class="disp-below">{{ isset($model->customers->statename->name) ? $model->customers->statename->name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">City</strong>
                                           
                                            <span class="disp-below">{{ isset($model->customers->cityname->name) ? $model->customers->cityname->name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Zipcode</strong>
                                            <span
                                                class="disp-below">{{ isset($model->customers->zipcode) ? $model->customers->zipcode : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Telephone</strong>
                                            <span
                                                class="disp-below">{{ isset($model->customers->telephone) ? $model->customers->telephone : '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Mobile Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->customers->mobile_number) ? $model->customers->mobile_number : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ company-details tab -->
                            <!-- access-details -->
                            <div class="tab-pane fade" id="account-vertical-access-details" role="tabpanel"
                                aria-labelledby="account-pill-access-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Email</strong>
                                            <span
                                                class="disp-below">{{ isset($model->email) ? $model->email : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ access-details -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ right content section -->
        </div>
    </section>
@endsection
