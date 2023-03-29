@extends('admin.layout.app')
@section('page_title', 'Package')
@section('content')
    <section id="page-account-settings">
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">Package: #{{ $model->id }}</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('packages.index') }}"><button type="reset"
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
                            <span class="font-weight-bold">PACKAGE DETAILS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-room-details" data-toggle="pill"
                            href="#account-vertical-room-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">ITINERARY</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-galleries-details" data-toggle="pill"
                            href="#account-vertical-galleries-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
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
                                            <label for="account-username">Package Name</label>
                                            <strong
                                                class="disp-below">{{ isset($model->package_name) ? $model->package_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Package Code</label>
                                            <strong
                                                class="disp-below">{{ isset($model->package_code) ? $model->package_code : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Package Validity</label>
                                            <strong
                                                class="disp-below">{{ isset($model->valid_from) ? $model->valid_from : '' }}
                                                To {{ isset($model->valid_till) ? $model->valid_till : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Country</label>
                                            <strong
                                                class="disp-below">{{ implode(' | ', $model->packagecountry->pluck('name')->toArray()) }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">City</label>
                                            <strong
                                                class="disp-below">{{ implode(' | ', $model->packagecity->pluck('name')->toArray()) }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Nationality</label>
                                            <strong class="disp-below">{{ $nationality }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Rate Per Adult</label>
                                            <strong
                                                class="disp-below">{{ isset($model->rate_per_adult) ? $model->rate_per_adult : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Rate per child (CWB)</label>
                                            <strong
                                                class="disp-below">{{ isset($model->rate_per_child_cwb) ? $model->rate_per_child_cwb : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Rate per child (CNB)</label>
                                            <strong
                                                class="disp-below">{{ isset($model->rate_per_child_cnb) ? $model->rate_per_child_cnb : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Rate Per Infant(0-2)</label>
                                            <strong
                                                class="disp-below">{{ isset($model->rate_per_infant) ? $model->rate_per_infant : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Minimum PAX</label>
                                            <strong
                                                class="disp-below">{{ isset($model->minimum_pax) ? $model->minimum_pax : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Maximum PAX</label>
                                            <strong
                                                class="disp-below">{{ isset($model->maximum_pax) ? $model->maximum_pax : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Cancel Day</label>
                                            <strong
                                                class="disp-below">{{ isset($model->cancel_day) ? $model->cancel_day : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-5">
                                        <div class="form-group">
                                            <label for="account-username">Terms and Conditions (pdf)</label>
                                            @if (strlen($model->terms_and_conditions_pdf) > 0)
                                                <strong class="disp-below">
                                                    <a target="_blank" title="{{ $model->package_name }}"
                                                        href="{{ url('storage/app/upload/packages/' . $model->id . '/' . $model->terms_and_conditions_pdf) }}"
                                                        class="badge badge-success" style="color:#FFF;">
                                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                                    </a>
                                                </strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Origin City</label>
                                            <strong class="disp-below">
                                                @if (count($model->origincityname) > 0)
                                                    @foreach ($model->origincityname as $origincityname)
                                                        <div class="alert alert-primary alert-dismissible fade show"
                                                            role="alert">
                                                            <div class="alert-body">{{ $origincityname->city_name }}</div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Inclusion</label>
                                            <strong class="disp-below">
                                                @if (count($model->inclusionname) > 0)
                                                    @foreach ($model->inclusionname as $inclusionname)
                                                        <div class="alert alert-primary alert-dismissible fade show"
                                                            role="alert">
                                                            <div class="alert-body">{{ $inclusionname->inclusion_name }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Exclusion</label>
                                            <strong class="disp-below">
                                                @if (count($model->exclusionname) > 0)
                                                    @foreach ($model->exclusionname as $exclusionname)
                                                        <div class="alert alert-primary alert-dismissible fade show"
                                                            role="alert">
                                                            <div class="alert-body">{{ $exclusionname->exclusion_name }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-username">Highlights</label>
                                            <strong
                                                class="disp-below">{{ isset($model->highlights) ? $model->highlights : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-username">Terms and Conditions</label>
                                            <strong
                                                class="disp-below">{{ isset($model->terms_and_conditions) ? $model->terms_and_conditions : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-room-details" role="tabpanel"
                                aria-labelledby="account-pill-room-details-details" aria-expanded="false">
                                <div class="row">
                                    @if ($model->packageitineraries->count() > 0)
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($model->packageitineraries as $childs)
                                            @php
                                                $i++;
                                            @endphp
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-1 mt-1">
                                                    <h4 class="">Itinerary Item {{ $i }}</h4>
                                                </div>
                                                <hr class="my-2" />
                                            </div>

                                            <div class="col-12 col-sm-10">
                                                <div class="form-group">
                                                    <label for="account-username">Heading</label>
                                                    <strong
                                                        class="disp-below">{{ isset($childs->heading) ? $childs->heading : '' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group">
                                                    <label for="account-username">Display Order</label>
                                                    <strong
                                                        class="disp-below">{{ isset($childs->display_order) ? $childs->display_order : '' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group">
                                                    <label for="account-username">Description</label>
                                                    <strong
                                                        class="disp-below">{{ isset($childs->description) ? $childs->description : old('description') }}</strong>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
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
                                                @if ($model->packageimages->count() > 0)
                                                    <div id="carouselExampleFade" class="carousel slide carousel-fade"
                                                        data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @php
                                                                $i = 0;
                                                            @endphp
                                                            @foreach ($model->packageimages as $image)
                                                                @php

                                                                    $i++;
                                                                @endphp
                                                                <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                                                                    <img src="{{ url('storage/app/upload/packages/' . $image->package_id . '/gallery/' . $image->images_path) }}"
                                                                        class="img-fluid d-block w-100" alt="cf-img-1"
                                                                        style="height: 550px !important;" />
                                                                </div>
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
                                                        Room galleries not found!
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
