@extends('layouts.app')
@section('page_title', 'Hotel Details ')
@section('content')
    @php
        $search_from = date('m-d-Y', strtotime(date('Y-m-d')));
        $search_to = date('m-d-Y', strtotime(date('Y-m-d')));
    @endphp
    <script>
        var check_in_startDate = "{!! $search_from !!}";
        var check_in_endDate = "{!! $search_to !!}";
        var filterObj = {};
        filterObj.hotel_amenities = "";
        filterObj.room_amenities = "";
        filterObj.star = "";
        filterObj.price_range = "";
        filterObj.page = 1;
        filterObj.requested_city_id = "";
        filterObj.requested_country_id = "";
        filterObj.requested_search_from = "";
        filterObj.requested_search_to = "";
        filterObj.requested_adult = "";
        filterObj.requested_child = "";
        filterObj.requested_room = "";
        filterObj.start_price_range = "";
        filterObj.end_price_range = "";
    </script>


    <section class="py-10 bg-dark-2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mainSearch bg-white px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-4">
                        <div class="button-grid items-center">

                            <div class="searchMenu-loc pl-10 pr-30 lg:py-20 lg:px-0 js-form-dd js-liverSearch">

                                <div data-x-dd-click="searchMenu-loc">
                                    <h4 class="text-15 fw-500 ls-2 lh-16">Location</h4>

                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                        <input autocomplete="off" type="search" placeholder="Where are you going?"
                                            class="js-search js-dd-focus" name="location" id="location" />
                                        <input type="hidden" class="hidden_city_id" name="city_id" />
                                        <input type="hidden" class="hidden_country_id" name="country_id" />
                                    </div>
                                    <span id="basic-addon-location-error" class="help-block help-block-error"></span>
                                </div>

                                <div class="searchMenu-loc__field shadow-2 js-popup-window" data-x-dd="searchMenu-loc"
                                    data-x-dd-toggle="-is-active">
                                    <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                                        <div class="y-gap-5 js-results">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="searchMenu-date px-30 lg:py-20 lg:px-0 js-form-dd js-calendar">
                                <div data-x-dd-click="searchMenu-date">
                                    <h4 class="text-15 fw-500 ls-2 lh-16">Check in - Check out</h4>
                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                        <input class="form-control" placeholder="Check in - Check out" name="daterange" />
                                        <input type="hidden" id="hidden_from" name="search_from" value="">
                                        <input type="hidden" id="hidden_to" name="search_to" value="">
                                    </div>
                                    <span id="basic-addon-date-error" class="help-block help-block-error"></span>
                                </div>
                                <div style="display: none" class="searchMenu-date__field shadow-2"
                                    data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">
                                </div>
                            </div>
                            <div class="searchMenu-guests px-30 lg:py-20 lg:px-0 js-form-dd js-form-counters">
                                <div data-x-dd-click="searchMenu-guests">
                                    <h4 class="text-15 fw-500 ls-2 lh-16">Guest</h4>
                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                        <span class="js-count-adult">1</span> adults
                                        -
                                        <span class="js-count-child">0</span> childeren
                                        -
                                        <span class="js-count-room">1</span> room
                                    </div>
                                    <span id="basic-addon-guest-error" class="help-block help-block-error"></span>
                                </div>
                                <div class="searchMenu-guests__field shadow-2" data-x-dd="searchMenu-guests"
                                    data-x-dd-toggle="-is-active">
                                    <div class="bg-white px-30 py-30 rounded-4">
                                        <div class="row y-gap-10 justify-between items-center">
                                            <div class="col-auto">
                                                <div class="text-15 fw-500">Adults</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="d-flex items-center js-counter"
                                                    data-value-change=".js-count-adult">
                                                    <button type="button"
                                                        class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                        <i class="icon-minus text-12"></i>
                                                    </button>
                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                        <div class="text-15 js-count count-adults">1
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                        <i class="icon-plus text-12"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top-light mt-24 mb-24"></div>
                                        <div class="row y-gap-10 justify-between items-center">
                                            <div class="col-auto">
                                                <div class="text-15 lh-12 fw-500">Children</div>
                                                <div class="text-14 lh-12 text-light-1 mt-5">Ages 0 -
                                                    17
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="d-flex items-center js-counter"
                                                    data-value-change=".js-count-child">
                                                    <button type="button"
                                                        class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                        <i class="icon-minus text-12"></i>
                                                    </button>
                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                        <div class="text-15 js-count count-childs">0
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                        <i class="icon-plus text-12"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top-light mt-24 mb-24"></div>
                                        <div class="row y-gap-10 justify-between items-center">
                                            <div class="col-auto">
                                                <div class="text-15 fw-500">Rooms</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="d-flex items-center js-counter"
                                                    data-value-change=".js-count-room">
                                                    <button type="button"
                                                        class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                        <i class="icon-minus text-12"></i>
                                                    </button>
                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                        <div class="text-15 js-count count-rooms">1
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                        <i class="icon-plus text-12"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-item">
                                <button
                                    class="mainSearch__submit button -dark-1 py-15 px-35 h-60 col-12 rounded-4 bg-blue-1 text-white">
                                    <i class="icon-search text-20 mr-10"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="py-10 d-flex items-center bg-light-2">
        <div class="container">
            <div class="row y-gap-10 items-center justify-between">
                <div class="col-auto">
                    <div class="row x-gap-10 y-gap-5 items-center text-14 text-light-1">
                        <div class="col-auto">
                            <div class="">Home</div>
                        </div>
                        <div class="col-auto">
                            <div class="">></div>
                        </div>
                        <div class="col-auto">
                            <div class="">{{ $hotelsDetails->country->name }} Hotels</div>
                        </div>
                        <div class="col-auto">
                            <div class="">></div>
                        </div>
                        <div class="col-auto">
                            <div class="text-dark-1">{{ $hotelsDetails->hotel_name }}</div>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </section> --}}

    <section class="pt-40">
        <div class="container">
            <div class="hotelSingleGrid">
                <div>
                    <div class="galleryGrid -type-2">
                        <div class="galleryGrid__item relative d-flex justify-end">
                            @if (strlen($hotelsDetails->hotel_image_location) > 0)
                                <img class="rounded-4"
                                    src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails->id . '/' . $hotelsDetails->hotel_image_location)) }}"
                                    alt="{{ $hotelsDetails->hotel_name }}">
                            @else
                                <img src="{{ asset('assets/front') }}/img/gallery/1/1.png"
                                    alt="{{ $hotelsDetails->hotel_name }}" class="rounded-4">
                            @endif
                            <div class="absolute px-20 py-20">
                                <button class="button -blue-1 size-40 rounded-full bg-white">
                                    <i class="icon-heart text-16"></i>
                                </button>
                            </div>
                        </div>
                        @if ($hotelsDetails->images->count() > 0)
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($hotelsDetails->images as $key => $img)
                                @if ($i == 0 || $i == 1)
                                    <div class="galleryGrid__item">
                                        <img src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails->id . '/gallery/' . $img['file_path'])) }}"
                                            alt="{{ $hotelsDetails->hotel_name }}" class="rounded-4">
                                    </div>
                                @endif
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        @endif

                        @if ($hotelsDetails->images->count() > 2)
                            @php
                                $j = 0;
                            @endphp
                            <div class="galleryGrid__item relative d-flex justify-end items-end">
                                @foreach ($hotelsDetails->images as $key => $img)
                                    @if ($j == 2)
                                        <img src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails->id . '/gallery/' . $img['file_path'])) }}"
                                            alt="{{ $hotelsDetails->hotel_name }}" class="rounded-4">
                                    @endif
                                    @php
                                        $j++;
                                    @endphp
                                @endforeach
                                @php
                                    $k = 0;
                                @endphp
                                <div class="absolute px-10 py-10">
                                    @foreach ($hotelsDetails->images as $key => $img)
                                        @if ($k == 3)
                                            <a href="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails->id . '/gallery/' . $img['file_path'])) }}"
                                                class="button -blue-1 px-24 py-15 bg-white text-dark-1 js-gallery"
                                                data-gallery="gallery2">
                                                See All {{ $hotelsDetails->images->count() }} Photos
                                            </a>
                                        @else
                                            <a href="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails->id . '/gallery/' . $img['file_path'])) }}"
                                                class="js-gallery" data-gallery="gallery2"></a>
                                        @endif
                                        @php
                                            $k++;
                                        @endphp
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row justify-between items-end pt-40">
                        <div class="col-auto">
                            <div class="row x-gap-20 y-gap-20 items-center">
                                <div class="col-auto">
                                    <h1 class="text-26 fw-600">{{ $hotelsDetails->hotel_name }}</h1>
                                </div>
                                @if ($hotelsDetails->category > 0)
                                    <div class="col-auto">
                                        @for ($i = 1; $i <= $hotelsDetails->category; $i++)
                                            <i class="icon-star text-10 text-yellow-1"></i>
                                        @endfor
                                    </div>
                                @endif
                            </div>

                            <div class="row x-gap-20 y-gap-20 items-center">
                                <div class="col-auto">
                                    <div class="text-15 text-light-1">{{ $hotelsDetails->hotel_address }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="text-14 text-right">
                                From
                                <span class="text-22 text-dark-1 fw-500">US$72</span>
                            </div>


                            <a href="#" class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5">
                                Select Room <div class="icon-arrow-top-right ml-15"></div>
                            </a>

                        </div>
                    </div>

                    <div id="overview" class="row y-gap-40 pt-40">
                        <div class="col-12">
                            <h3 class="text-22 fw-500 pt-40 border-top-light">Overview</h3>
                            <p class="text-dark-1 text-15 mt-20">
                                {!! $hotelsDetails->hotel_description !!}
                            </p>
                        </div>
                        @if ($hotelsDetails->hotelamenity->count())
                            <div class="col-12">
                                <h3 class="text-22 fw-500 pt-40 border-top-light">Most Popular Hotel Amenities</h3>
                                <div class="row y-gap-10 pt-20">
                                    @foreach ($hotelsDetails->hotelamenity as $hotelamenities)
                                        <div class="col-md-5">
                                            <div class="d-flex x-gap-15 y-gap-15 items-center">
                                                <i class="icon-check"></i>
                                                <div class="text-15">{{ $hotelamenities->amenity_name }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif                        
                        @if ($hotelsDetails->hotelfreebies->count())
                            <div class="col-12">
                                <h3 class="text-22 fw-500 pt-40 border-top-light">Most Popular Hotel Amenities</h3>
                                <div class="row y-gap-10 pt-20">
                                    @foreach ($hotelsDetails->hotelfreebies as $hotelfreebies)
                                        <div class="col-md-5">
                                            <div class="d-flex x-gap-15 y-gap-15 items-center">
                                                <i class="icon-check"></i>
                                                <div class="text-15">{{ $hotelfreebies->name }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif                        
                    </div>
                </div>

                <div>
                    <div class="px-30 py-30 border-light rounded-4">
                        <div class="flex-center ratio ratio-15:9 mb-15 js-lazy"
                            data-bg="{{ asset('assets/front') }}/img/general/map.png">
                        </div>

                        <div class="row y-gap-10">
                            <div class="col-12">
                                <div class="d-flex items-center">
                                    <i class="icon-award text-20 text-blue-1"></i>
                                    <div class="text-14 fw-500 ml-10">Exceptional location - Inside city center</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex items-center">
                                    <i class="icon-pedestrian text-20 text-blue-1"></i>
                                    <div class="text-14 fw-500 ml-10">Exceptional for walking</div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top-light mt-15 mb-15"></div>

                        <div class="text-15 fw-500">Popular landmarks</div>

                        <div class="d-flex justify-between pt-10">
                            <div class="text-14">Royal Pump Room Museum</div>
                            <div class="text-14 text-light-1">0.1 km</div>
                        </div>

                        <div class="d-flex justify-between pt-5">
                            <div class="text-14">Harrogate Turkish Baths</div>
                            <div class="text-14 text-light-1">0.1 km</div>
                        </div>

                        <a href="#" class="d-block text-14 fw-500 underline text-blue-1 mt-10">Show More</a>
                    </div>

                    <div class="px-30 py-30 border-light rounded-4 mt-30">
                        <div class="d-flex items-center">
                            <div class="size-40 flex-center bg-blue-1 rounded-4">
                                <div class="text-14 fw-600 text-white">4.8</div>
                            </div>

                            <div class="text-14 ml-10">
                                <div class="lh-15 fw-500">Exceptional</div>
                                <div class="lh-15 text-light-1">3,014 reviews</div>
                            </div>
                        </div>

                        <div class="d-flex mt-20">
                            <i class="icon-group text-16 mr-10 pt-5"></i>
                            <div class="text-15">Highly rated by guests – 86% would recommend</div>
                        </div>

                        <div class="border-top-light mt-20 mb-20"></div>

                        <div class="row x-gap-10 y-gap-10">
                            <div class="col-auto">
                                <div class="d-flex items-center py-5 px-20 rounded-100 border-light">
                                    <i class="icon-like text-12 text-blue-1 mr-10"></i>
                                    <div class="text-14 lh-15">
                                        Breakfast <span class="fw-500 text-blue-1">25</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="d-flex items-center py-5 px-20 rounded-100 border-light">
                                    <i class="icon-like text-12 text-blue-1 mr-10"></i>
                                    <div class="text-14 lh-15">
                                        WiFi <span class="fw-500 text-blue-1">14</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="d-flex items-center py-5 px-20 rounded-100 border-light">
                                    <i class="icon-like text-12 text-blue-1 mr-10"></i>
                                    <div class="text-14 lh-15">
                                        Food & Dining <span class="fw-500 text-blue-1">67</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-30 py-30 border-light rounded-4 mt-30">
                        <div class="text-18 fw-500">Property highlights</div>

                        <div class="row x-gap-20 y-gap-20 pt-20">
                            <div class="col-auto">
                                <i class="icon-city text-24 text-blue-1"></i>
                            </div>
                            <div class="col-auto">
                                <div class="text-15">In London City Centre</div>
                            </div>
                        </div>

                        <div class="row x-gap-20 y-gap-20 pt-5">
                            <div class="col-auto">
                                <i class="icon-airplane text-24 text-blue-1"></i>
                            </div>
                            <div class="col-auto">
                                <div class="text-15">Airport transfer</div>
                            </div>
                        </div>

                        <div class="row x-gap-20 y-gap-20 pt-5">
                            <div class="col-auto">
                                <i class="icon-bell-ring text-24 text-blue-1"></i>
                            </div>
                            <div class="col-auto">
                                <div class="text-15">Front desk [24-hour]</div>
                            </div>
                        </div>

                        <div class="row x-gap-20 y-gap-20 pt-5">
                            <div class="col-auto">
                                <i class="icon-tv text-24 text-blue-1"></i>
                            </div>
                            <div class="col-auto">
                                <div class="text-15">Premium TV channels</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-30">
        <div class="container">
            <div class="row y-gap-30">
                <div class="col-12">
                    <div class="px-24 py-20 rounded-4 bg-green-1">
                        <div class="row x-gap-20 y-gap-20 items-center">
                            <div class="col-auto">
                                <div class="flex-center size-60 rounded-full bg-white">
                                    <i class="icon-star text-yellow-1 text-30"></i>
                                </div>
                            </div>

                            <div class="col-auto">
                                <h4 class="text-18 lh-15 fw-500">This property is in high demand!</h4>
                                <div class="text-15 lh-15">7 travelers have booked today.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="rooms" class="pt-30">
        <div class="container">
            <div class="row pb-20">
                <div class="col-auto">
                    <h3 class="text-22 fw-500">Available Rooms</h3>
                </div>
            </div>


            <div class="bg-blue-2 rounded-4 px-30 py-30 sm:px-20 sm:py-20">
                <div class="row y-gap-30">
                    <div class="col-xl-auto">
                        <div class="ratio ratio-1:1 col-12 col-md-4 col-xl-12">
                            <img src="{{ asset('assets/front') }}/img/backgrounds/1.png" alt="image"
                                class="img-ratio rounded-4">
                        </div>

                        <div class="">
                            <div class="text-18 fw-500 mt-10">Standard Twin Room</div>

                            <div class="y-gap-5 pt-5">

                                <div class="d-flex items-center">
                                    <i class="icon-no-smoke text-20 mr-10"></i>
                                    <div class="text-15">Non-smoking rooms</div>
                                </div>

                                <div class="d-flex items-center">
                                    <i class="icon-wifi text-20 mr-10"></i>
                                    <div class="text-15">Free WiFi</div>
                                </div>

                                <div class="d-flex items-center">
                                    <i class="icon-parking text-20 mr-10"></i>
                                    <div class="text-15">Parking</div>
                                </div>

                                <div class="d-flex items-center">
                                    <i class="icon-kitchen text-20 mr-10"></i>
                                    <div class="text-15">Kitchen</div>
                                </div>

                            </div>

                            <a href="#" class="d-block text-15 fw-500 underline text-blue-1 mt-15">Show Room
                                Information</a>
                        </div>
                    </div>

                    <div class="col-xl">


                        <div class="bg-white rounded-4 px-30 py-30">

                            <div class="row y-gap-30">
                                <div class="col-lg col-md-6">
                                    <div class="text-15 fw-500 mb-10">Your price includes:</div>

                                    <div class="y-gap-5">

                                        <div class="d-flex items-center text-green-2">
                                            <i class="icon-check text-12 mr-10"></i>
                                            <div class="text-15">Pay at the hotel</div>
                                        </div>

                                        <div class="d-flex items-center text-green-2">
                                            <i class="icon-check text-12 mr-10"></i>
                                            <div class="text-15">Pay nothing until March 30, 2022</div>
                                        </div>

                                        <div class="d-flex items-center text-green-2">
                                            <i class="icon-check text-12 mr-10"></i>
                                            <div class="text-15">Free cancellation before April 1, 2022</div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                    <div class="px-40 lg:px-0">
                                        <div class="text-15 fw-500 mb-20">Sleeps</div>

                                        <div class="d-flex items-center text-light-1">
                                            <div class="icon-man text-24"></div>
                                            <div class="icon-man text-24"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                    <div class="px-40 lg:px-0">
                                        <div class="text-15 fw-500 mb-20">Select Rooms</div>


                                        <div class="dropdown js-dropdown js-price-1-active">
                                            <div class="dropdown__button d-flex items-center rounded-4 border-light px-15 h-50 text-14"
                                                data-el-toggle=".js-price-1-toggle"
                                                data-el-toggle-active=".js-price-1-active">
                                                <span class="js-dropdown-title">1 (US$ 3,120)</span>
                                                <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                                            </div>

                                            <div class="toggle-element -dropdown  js-click-dropdown js-price-1-toggle">
                                                <div class="text-14 y-gap-15 js-dropdown-list">

                                                    <div><a href="#" class="d-block js-dropdown-link">2 (US$
                                                            3,120)</a></div>

                                                    <div><a href="#" class="d-block js-dropdown-link">3 (US$
                                                            3,120)</a></div>

                                                    <div><a href="#" class="d-block js-dropdown-link">4 (US$
                                                            3,120)</a></div>

                                                    <div><a href="#" class="d-block js-dropdown-link">5 (US$
                                                            3,120)</a></div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none text-right lg:text-left">
                                    <div class="pl-40 lg:pl-0">
                                        <div class="text-14 lh-14 text-light-1 mb-5">3 rooms for</div>
                                        <div class="text-20 lh-14 fw-500">US$72</div>


                                        <a href="#" class="button h-50 px-35 -dark-1 bg-blue-1 text-white mt-10">
                                            Reserve <div class="icon-arrow-top-right ml-15"></div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="bg-white rounded-4 px-30 py-30 mt-20">

                            <div class="row y-gap-30">
                                <div class="col-lg col-md-6">
                                    <div class="text-15 fw-500 mb-10">Your price includes:</div>

                                    <div class="y-gap-5">

                                        <div class="d-flex items-center text-green-2">
                                            <i class="icon-check text-12 mr-10"></i>
                                            <div class="text-15">Pay at the hotel</div>
                                        </div>

                                        <div class="d-flex items-center text-green-2">
                                            <i class="icon-check text-12 mr-10"></i>
                                            <div class="text-15">Pay nothing until March 30, 2022</div>
                                        </div>

                                        <div class="d-flex items-center text-green-2">
                                            <i class="icon-check text-12 mr-10"></i>
                                            <div class="text-15">Free cancellation before April 1, 2022</div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                    <div class="px-40 lg:px-0">
                                        <div class="text-15 fw-500 mb-20">Sleeps</div>

                                        <div class="d-flex items-center text-light-1">
                                            <div class="icon-man text-24"></div>
                                            <div class="icon-man text-24"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                    <div class="px-40 lg:px-0">
                                        <div class="text-15 fw-500 mb-20">Select Rooms</div>


                                        <div class="dropdown js-dropdown js-price-2-active">
                                            <div class="dropdown__button d-flex items-center rounded-4 border-light px-15 h-50 text-14"
                                                data-el-toggle=".js-price-2-toggle"
                                                data-el-toggle-active=".js-price-2-active">
                                                <span class="js-dropdown-title">1 (US$ 3,120)</span>
                                                <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                                            </div>

                                            <div class="toggle-element -dropdown  js-click-dropdown js-price-2-toggle">
                                                <div class="text-14 y-gap-15 js-dropdown-list">

                                                    <div><a href="#" class="d-block js-dropdown-link">2 (US$
                                                            3,120)</a></div>

                                                    <div><a href="#" class="d-block js-dropdown-link">3 (US$
                                                            3,120)</a></div>

                                                    <div><a href="#" class="d-block js-dropdown-link">4 (US$
                                                            3,120)</a></div>

                                                    <div><a href="#" class="d-block js-dropdown-link">5 (US$
                                                            3,120)</a></div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none text-right lg:text-left">
                                    <div class="pl-40 lg:pl-0">
                                        <div class="text-14 lh-14 text-light-1 mb-5">3 rooms for</div>
                                        <div class="text-20 lh-14 fw-500">US$72</div>


                                        <a href="#" class="button h-50 px-35 -dark-1 bg-blue-1 text-white mt-10">
                                            Reserve <div class="icon-arrow-top-right ml-15"></div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="bg-white rounded-4 px-30 py-30 mt-20">

                            <div class="row y-gap-30">
                                <div class="col-lg col-md-6">
                                    <div class="text-15 fw-500 mb-10">Your price includes:</div>

                                    <div class="y-gap-5">

                                        <div class="d-flex items-center text-green-2">
                                            <i class="icon-check text-12 mr-10"></i>
                                            <div class="text-15">Pay at the hotel</div>
                                        </div>

                                        <div class="d-flex items-center text-green-2">
                                            <i class="icon-check text-12 mr-10"></i>
                                            <div class="text-15">Pay nothing until March 30, 2022</div>
                                        </div>

                                        <div class="d-flex items-center text-green-2">
                                            <i class="icon-check text-12 mr-10"></i>
                                            <div class="text-15">Free cancellation before April 1, 2022</div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                    <div class="px-40 lg:px-0">
                                        <div class="text-15 fw-500 mb-20">Sleeps</div>

                                        <div class="d-flex items-center text-light-1">
                                            <div class="icon-man text-24"></div>
                                            <div class="icon-man text-24"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                    <div class="px-40 lg:px-0">
                                        <div class="text-15 fw-500 mb-20">Select Rooms</div>


                                        <div class="dropdown js-dropdown js-price-3-active">
                                            <div class="dropdown__button d-flex items-center rounded-4 border-light px-15 h-50 text-14"
                                                data-el-toggle=".js-price-3-toggle"
                                                data-el-toggle-active=".js-price-3-active">
                                                <span class="js-dropdown-title">1 (US$ 3,120)</span>
                                                <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                                            </div>

                                            <div class="toggle-element -dropdown  js-click-dropdown js-price-3-toggle">
                                                <div class="text-14 y-gap-15 js-dropdown-list">

                                                    <div><a href="#" class="d-block js-dropdown-link">2 (US$
                                                            3,120)</a></div>

                                                    <div><a href="#" class="d-block js-dropdown-link">3 (US$
                                                            3,120)</a></div>

                                                    <div><a href="#" class="d-block js-dropdown-link">4 (US$
                                                            3,120)</a></div>

                                                    <div><a href="#" class="d-block js-dropdown-link">5 (US$
                                                            3,120)</a></div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none text-right lg:text-left">
                                    <div class="pl-40 lg:pl-0">
                                        <div class="text-14 lh-14 text-light-1 mb-5">3 rooms for</div>
                                        <div class="text-20 lh-14 fw-500">US$72</div>


                                        <a href="#" class="button h-50 px-35 -dark-1 bg-blue-1 text-white mt-10">
                                            Reserve <div class="icon-arrow-top-right ml-15"></div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="mt-20">

                <div class="bg-blue-2 rounded-4 px-30 py-30 sm:px-20 sm:py-20">
                    <div class="row y-gap-30">
                        <div class="col-xl-auto">
                            <div class="ratio ratio-1:1 col-12 col-md-4 col-xl-12">
                                <img src="{{ asset('assets/front') }}/img/backgrounds/1.png" alt="image"
                                    class="img-ratio rounded-4">
                            </div>

                            <div class="">
                                <div class="text-18 fw-500 mt-10">Standard Twin Room</div>

                                <div class="y-gap-5 pt-5">

                                    <div class="d-flex items-center">
                                        <i class="icon-no-smoke text-20 mr-10"></i>
                                        <div class="text-15">Non-smoking rooms</div>
                                    </div>

                                    <div class="d-flex items-center">
                                        <i class="icon-wifi text-20 mr-10"></i>
                                        <div class="text-15">Free WiFi</div>
                                    </div>

                                    <div class="d-flex items-center">
                                        <i class="icon-parking text-20 mr-10"></i>
                                        <div class="text-15">Parking</div>
                                    </div>

                                    <div class="d-flex items-center">
                                        <i class="icon-kitchen text-20 mr-10"></i>
                                        <div class="text-15">Kitchen</div>
                                    </div>

                                </div>

                                <a href="#" class="d-block text-15 fw-500 underline text-blue-1 mt-15">Show Room
                                    Information</a>
                            </div>
                        </div>

                        <div class="col-xl">


                            <div class="bg-white rounded-4 px-30 py-30">

                                <div class="row y-gap-30">
                                    <div class="col-lg col-md-6">
                                        <div class="text-15 fw-500 mb-10">Your price includes:</div>

                                        <div class="y-gap-5">

                                            <div class="d-flex items-center text-green-2">
                                                <i class="icon-check text-12 mr-10"></i>
                                                <div class="text-15">Pay at the hotel</div>
                                            </div>

                                            <div class="d-flex items-center text-green-2">
                                                <i class="icon-check text-12 mr-10"></i>
                                                <div class="text-15">Pay nothing until March 30, 2022</div>
                                            </div>

                                            <div class="d-flex items-center text-green-2">
                                                <i class="icon-check text-12 mr-10"></i>
                                                <div class="text-15">Free cancellation before April 1, 2022</div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                        <div class="px-40 lg:px-0">
                                            <div class="text-15 fw-500 mb-20">Sleeps</div>

                                            <div class="d-flex items-center text-light-1">
                                                <div class="icon-man text-24"></div>
                                                <div class="icon-man text-24"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                        <div class="px-40 lg:px-0">
                                            <div class="text-15 fw-500 mb-20">Select Rooms</div>


                                            <div class="dropdown js-dropdown js-price-2-1-active">
                                                <div class="dropdown__button d-flex items-center rounded-4 border-light px-15 h-50 text-14"
                                                    data-el-toggle=".js-price-2-1-toggle"
                                                    data-el-toggle-active=".js-price-2-1-active">
                                                    <span class="js-dropdown-title">1 (US$ 3,120)</span>
                                                    <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                                                </div>

                                                <div
                                                    class="toggle-element -dropdown  js-click-dropdown js-price-2-1-toggle">
                                                    <div class="text-14 y-gap-15 js-dropdown-list">

                                                        <div><a href="#" class="d-block js-dropdown-link">2 (US$
                                                                3,120)</a></div>

                                                        <div><a href="#" class="d-block js-dropdown-link">3 (US$
                                                                3,120)</a></div>

                                                        <div><a href="#" class="d-block js-dropdown-link">4 (US$
                                                                3,120)</a></div>

                                                        <div><a href="#" class="d-block js-dropdown-link">5 (US$
                                                                3,120)</a></div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div
                                        class="col-lg-auto col-md-6 border-left-light lg:border-none text-right lg:text-left">
                                        <div class="pl-40 lg:pl-0">
                                            <div class="text-14 lh-14 text-light-1 mb-5">3 rooms for</div>
                                            <div class="text-20 lh-14 fw-500">US$72</div>


                                            <a href="#"
                                                class="button h-50 px-35 -dark-1 bg-blue-1 text-white mt-10">
                                                Reserve <div class="icon-arrow-top-right ml-15"></div>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="bg-white rounded-4 px-30 py-30 mt-20">

                                <div class="row y-gap-30">
                                    <div class="col-lg col-md-6">
                                        <div class="text-15 fw-500 mb-10">Your price includes:</div>

                                        <div class="y-gap-5">

                                            <div class="d-flex items-center text-green-2">
                                                <i class="icon-check text-12 mr-10"></i>
                                                <div class="text-15">Pay at the hotel</div>
                                            </div>

                                            <div class="d-flex items-center text-green-2">
                                                <i class="icon-check text-12 mr-10"></i>
                                                <div class="text-15">Pay nothing until March 30, 2022</div>
                                            </div>

                                            <div class="d-flex items-center text-green-2">
                                                <i class="icon-check text-12 mr-10"></i>
                                                <div class="text-15">Free cancellation before April 1, 2022</div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                        <div class="px-40 lg:px-0">
                                            <div class="text-15 fw-500 mb-20">Sleeps</div>

                                            <div class="d-flex items-center text-light-1">
                                                <div class="icon-man text-24"></div>
                                                <div class="icon-man text-24"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                        <div class="px-40 lg:px-0">
                                            <div class="text-15 fw-500 mb-20">Select Rooms</div>


                                            <div class="dropdown js-dropdown js-price-2-2-active">
                                                <div class="dropdown__button d-flex items-center rounded-4 border-light px-15 h-50 text-14"
                                                    data-el-toggle=".js-price-2-2-toggle"
                                                    data-el-toggle-active=".js-price-2-2-active">
                                                    <span class="js-dropdown-title">1 (US$ 3,120)</span>
                                                    <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                                                </div>

                                                <div
                                                    class="toggle-element -dropdown  js-click-dropdown js-price-2-2-toggle">
                                                    <div class="text-14 y-gap-15 js-dropdown-list">

                                                        <div><a href="#" class="d-block js-dropdown-link">2 (US$
                                                                3,120)</a></div>

                                                        <div><a href="#" class="d-block js-dropdown-link">3 (US$
                                                                3,120)</a></div>

                                                        <div><a href="#" class="d-block js-dropdown-link">4 (US$
                                                                3,120)</a></div>

                                                        <div><a href="#" class="d-block js-dropdown-link">5 (US$
                                                                3,120)</a></div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div
                                        class="col-lg-auto col-md-6 border-left-light lg:border-none text-right lg:text-left">
                                        <div class="pl-40 lg:pl-0">
                                            <div class="text-14 lh-14 text-light-1 mb-5">3 rooms for</div>
                                            <div class="text-20 lh-14 fw-500">US$72</div>


                                            <a href="#"
                                                class="button h-50 px-35 -dark-1 bg-blue-1 text-white mt-10">
                                                Reserve <div class="icon-arrow-top-right ml-15"></div>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div id="facilities"></div>
    <section class="mt-40">
        <div class="container">
            <div class="row x-gap-40 y-gap-40">
                <div class="col-12">
                    <h3 class="text-22 fw-500">Facilities of The Crown Hotel</h3>

                    <div class="row x-gap-40 y-gap-40 pt-20">
                        <div class="col-xl-4">
                            <div class="row y-gap-30">
                                <div class="col-12">

                                    <div class="">
                                        <div class="d-flex items-center text-16 fw-500">
                                            <i class="icon-bathtub text-20 mr-10"></i>
                                            Bathroom
                                        </div>

                                        <ul class="text-15 pt-10">

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Towels
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Bath or shower
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Private bathroom
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Toilet
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Free toiletries
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Hairdryer
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Bath
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="">
                                        <div class="d-flex items-center text-16 fw-500">
                                            <i class="icon-bed text-20 mr-10"></i>
                                            Bedroom
                                        </div>

                                        <ul class="text-15 pt-10">

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Linen
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Wardrobe or closet
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="">
                                        <div class="d-flex items-center text-16 fw-500">
                                            <i class="icon-bell-ring text-20 mr-10"></i>
                                            Reception services
                                        </div>

                                        <ul class="text-15 pt-10">

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Invoice provided
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Private check-in/check-out
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Luggage storage
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                24-hour front desk
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="row y-gap-30">
                                <div class="col-12">

                                    <div class="">
                                        <div class="d-flex items-center text-16 fw-500">
                                            <i class="icon-tv text-20 mr-10"></i>
                                            Media &amp; Technology
                                        </div>

                                        <ul class="text-15 pt-10">

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Flat-screen TV
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Satellite channels
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Radio
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Telephone
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                TV
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="">
                                        <div class="d-flex items-center text-16 fw-500">
                                            <i class="icon-juice text-20 mr-10"></i>
                                            Food &amp; Drink
                                        </div>

                                        <ul class="text-15 pt-10">

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Kid meals
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Special diet menus (on request)
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Breakfast in the room
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Bar
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Restaurant
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Tea/Coffee maker
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="">
                                        <div class="d-flex items-center text-16 fw-500">
                                            <i class="icon-washing-machine text-20 mr-10"></i>
                                            Cleaning services
                                        </div>

                                        <ul class="text-15 pt-10">

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Daily housekeeping
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Dry cleaning
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Laundry
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="row y-gap-30">
                                <div class="col-12">

                                    <div class="">
                                        <div class="d-flex items-center text-16 fw-500">
                                            <i class="icon-shield text-20 mr-10"></i>
                                            Safety &amp; security
                                        </div>

                                        <ul class="text-15 pt-10">

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Fire extinguishers
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                CCTV in common areas
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Smoke alarms
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                24-hour security
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="">
                                        <div class="d-flex items-center text-16 fw-500">
                                            <i class="icon-city-2 text-20 mr-10"></i>
                                            General
                                        </div>

                                        <ul class="text-15 pt-10">

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Hypoallergenic
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Non-smoking throughout
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Wake-up service
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Heating
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Packed lunches
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Carpeted
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Lift
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Fan
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Family rooms
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Facilities for disabled guests
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Ironing facilities
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Non-smoking rooms
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Iron
                                            </li>

                                            <li class="d-flex items-center">
                                                <i class="icon-check text-10 mr-20"></i>
                                                Room service
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-40 mb-40">
        <div class="border-top-light"></div>
    </div>





    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Popular properties similar to The Crown Hotel</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">Interdum et malesuada fames ac ante ipsum</p>
                    </div>
                </div>
            </div>

            <div class="row y-gap-30 pt-40 sm:pt-20">

                <div class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="hotel-single-1.html" class="hotelsCard -type-1 ">
                        <div class="hotelsCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/hotels/1.png"
                                        alt="image">


                                </div>

                                <div class="cardImage__wishlist">
                                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>


                                <div class="cardImage__leftBadge">
                                    <div
                                        class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-dark-1 text-white">
                                        Breakfast included
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="hotelsCard__content mt-10">
                            <h4 class="hotelsCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>The Montcalm At Brewery London City</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5">Westminster Borough, London</p>

                            <div class="d-flex items-center mt-20">
                                <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">4.8</div>
                                <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                            </div>

                            <div class="mt-5">
                                <div class="fw-500">
                                    Starting from <span class="text-blue-1">US$72</span>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="hotel-single-1.html" class="hotelsCard -type-1 ">
                        <div class="hotelsCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">


                                    <div class="cardImage-slider rounded-4 overflow-hidden js-cardImage-slider">
                                        <div class="swiper-wrapper">

                                            <div class="swiper-slide">
                                                <img class="col-12" src="{{ asset('assets/front') }}/img/hotels/2.png"
                                                    alt="image">
                                            </div>

                                            <div class="swiper-slide">
                                                <img class="col-12" src="{{ asset('assets/front') }}/img/hotels/1.png"
                                                    alt="image">
                                            </div>

                                            <div class="swiper-slide">
                                                <img class="col-12" src="{{ asset('assets/front') }}/img/hotels/3.png"
                                                    alt="image">
                                            </div>

                                        </div>

                                        <div class="cardImage-slider__pagination js-pagination"></div>

                                        <div class="cardImage-slider__nav -prev">
                                            <button class="button -blue-1 bg-white size-30 rounded-full shadow-2 js-prev">
                                                <i class="icon-chevron-left text-10"></i>
                                            </button>
                                        </div>

                                        <div class="cardImage-slider__nav -next">
                                            <button class="button -blue-1 bg-white size-30 rounded-full shadow-2 js-next">
                                                <i class="icon-chevron-right text-10"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <div class="cardImage__wishlist">
                                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>


                            </div>

                        </div>

                        <div class="hotelsCard__content mt-10">
                            <h4 class="hotelsCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>Staycity Aparthotels Deptford Bridge Station</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5">Ciutat Vella, Barcelona</p>

                            <div class="d-flex items-center mt-20">
                                <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">4.8</div>
                                <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                            </div>

                            <div class="mt-5">
                                <div class="fw-500">
                                    Starting from <span class="text-blue-1">US$72</span>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="hotel-single-1.html" class="hotelsCard -type-1 ">
                        <div class="hotelsCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/hotels/3.png"
                                        alt="image">


                                </div>

                                <div class="cardImage__wishlist">
                                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>


                                <div class="cardImage__leftBadge">
                                    <div
                                        class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-blue-1 text-white">
                                        Best Seller
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="hotelsCard__content mt-10">
                            <h4 class="hotelsCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>The Westin New York at Times Square</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5">Manhattan, New York</p>

                            <div class="d-flex items-center mt-20">
                                <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">4.8</div>
                                <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                            </div>

                            <div class="mt-5">
                                <div class="fw-500">
                                    Starting from <span class="text-blue-1">US$72</span>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="hotel-single-1.html" class="hotelsCard -type-1 ">
                        <div class="hotelsCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/hotels/4.png"
                                        alt="image">


                                </div>

                                <div class="cardImage__wishlist">
                                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>


                                <div class="cardImage__leftBadge">
                                    <div
                                        class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-yellow-1 text-dark-1">
                                        Top Rated
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="hotelsCard__content mt-10">
                            <h4 class="hotelsCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>DoubleTree by Hilton Hotel New York Times Square West</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5">Vaticano Prati, Rome</p>

                            <div class="d-flex items-center mt-20">
                                <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">4.8</div>
                                <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                            </div>

                            <div class="mt-5">
                                <div class="fw-500">
                                    Starting from <span class="text-blue-1">US$72</span>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-md bg-dark-2">
        <div class="container">
            <div class="row y-gap-30 justify-between items-center">
                <div class="col-auto">
                    <div class="row y-gap-20  flex-wrap items-center">
                        <div class="col-auto">
                            <div class="icon-newsletter text-60 sm:text-40 text-white"></div>
                        </div>

                        <div class="col-auto">
                            <h4 class="text-26 text-white fw-600">Your Travel Journey Starts Here</h4>
                            <div class="text-white">Sign up and we'll send the best deals to you</div>
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    <div class="single-field -w-410 d-flex x-gap-10 y-gap-20">
                        <div>
                            <input class="bg-white h-60" type="text" placeholder="Your Email">
                        </div>

                        <div>
                            <button class="button -md h-60 bg-blue-1 text-white">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/search-form/Search.js') }}"></script>
    <script type="text/javascript">
        var moduleConfig = {
            searchLocationByName: "{!! route('city-hotel-list') !!}",
        };
    </script>
@endsection
