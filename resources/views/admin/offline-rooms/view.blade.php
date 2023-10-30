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
                    <a href="{{ route('offlinerooms.index') }}"><button type="reset"
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
                        <a class="nav-link" id="account-pill-room-details" data-toggle="pill"
                            href="#account-vertical-room-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">ROOM DETAILS</span>
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
                                            <strong for="account-username">Hotel Name</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel->hotel_name) ? $model->hotel->hotel_name : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-room-details" role="tabpanel"
                                aria-labelledby="account-pill-room-details-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <strong for="account-username">Type</strong>
                                            <span
                                                class="disp-below">{{ isset($model->roomtype->room_type) ? $model->roomtype->room_type : '' }}</span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-username">Meal Plan</label>
                                            <strong
                                                class="disp-below">{{ isset($model->mealplan->name) ? $model->mealplan->name : '' }}</strong>
                                        </div>
                                    </div> --}}
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <strong for="account-username">Amenities</strong>
                                            <span class="disp-below">
                                                {{ $amenitiesName }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <strong for="account-username">Freebies</strong>
                                            <span class="disp-below">
                                                {{ $freebiesName }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Max Occupancy</strong>
                                            <span
                                                class="disp-below">{{ isset($model->occ_sleepsmax) ? $model->occ_sleepsmax : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">No. of Beds</strong>
                                            <span
                                                class="disp-below">{{ isset($model->occ_num_beds) ? $model->occ_num_beds : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Max Adults</strong>
                                            <span
                                                class="disp-below">{{ isset($model->occ_max_adults) ? $model->occ_max_adults : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Max Children When Max Adults</strong>
                                            <span
                                                class="disp-below">{{ isset($model->occ_max_child_w_max_adults) ? $model->occ_max_child_w_max_adults : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <strong for="account-username">Max Children Without Extra Bed</strong>
                                            <span
                                                class="disp-below">{{ isset($model->occ_max_child_wo_extra_bed) ? $model->occ_max_child_wo_extra_bed : '' }}</span>
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
                                                                @php
                                                                    $i++;
                                                                @endphp
                                                                <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                                                                    <img src="{{ url('storage/app/upload/Hotel/' . $model->hotel_id . '/Room/' . $model->id . '/Gallery/' . $image['images']) }}"
                                                                        class="img-fluid d-block w-100" alt="cf-img-1" style="height: 550px !important;" />
                                                                </div>
                                                            @endforeach
                                                            @if (strlen($model->room_image)> 0)
                                                            <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                                                                <img src="{{ url('storage/app/upload/Hotel/' . $model->hotel_id . '/Room/' . $model->id . '/' . $model->room_image) }}"
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
