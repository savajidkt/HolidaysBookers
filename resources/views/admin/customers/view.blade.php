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
                                            <label for="account-username">First Name</label>
                                            <strong
                                                class="disp-below">{{ isset($model->user->first_name) ? $model->user->first_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Last Name</label>

                                            <strong
                                                class="disp-below">{{ isset($model->user->last_name) ? $model->user->last_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Date Of Birth</label>
                                            <strong class="disp-below">{{ isset($model->dob) ? $model->dob : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Country</label>
                                            @php
                                                $country = '';
                                            @endphp
                                            @foreach ($countries as $country)
                                                @if ($model->country == $country->id)
                                                    @php
                                                        $country = $country->name;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <strong class="disp-below">{{ isset($country) ? $country : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">State</label>
                                            @php
                                                $state = '';
                                            @endphp
                                            @php $states = getCountryStates($model->country);  @endphp
                                            @if ($states->count() > 0)
                                                @foreach ($states as $state)
                                                    @if ($model->state == $state->id)
                                                        @php
                                                            $state = $state->name;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                            <strong class="disp-below">{{ isset($state) ? $state : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">City</label>
                                            @php
                                                $city = '';
                                            @endphp
                                            @php $cities = getStateCities($model->state);  @endphp
                                            @if ($cities->count() > 0)
                                                @foreach ($cities as $city)
                                                    @if ($model->city == $city->id)
                                                        @php
                                                            $city = $city->name;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                            <strong class="disp-below">{{ isset($city) ? $city : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Zipcode</label>
                                            <strong
                                                class="disp-below">{{ isset($model->zipcode) ? $model->zipcode : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Telephone</label>
                                            <strong
                                                class="disp-below">{{ isset($model->telephone) ? $model->telephone : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Mobile Number</label>
                                            <strong
                                                class="disp-below">{{ isset($model->mobile_number) ? $model->mobile_number : '' }}</strong>
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
                                            <label for="account-username">Email</label>
                                            <strong
                                                class="disp-below">{{ isset($model->user->email) ? $model->user->email : '' }}</strong>
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
