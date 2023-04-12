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
                    <form class="" id="SearchFrm" method="get" enctype="multipart/form-data"
                        action="{{ route('hotel-list') }}">
                        {{-- @csrf --}}
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
                                            <input class="form-control" placeholder="Check in - Check out"
                                                name="daterange" />
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
                    </form>
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
                            @if (strlen($hotelsDetails['hotel']['hotel_image_location']) > 0)
                                <img class="rounded-4"
                                    src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/' . $hotelsDetails['hotel']['hotel_image_location'])) }}"
                                    alt="{{ $hotelsDetails['hotel']['hotel_name'] }}">
                            @else
                                <img src="{{ asset('assets/front') }}/img/gallery/1/1.png"
                                    alt="{{ $hotelsDetails['hotel']['hotel_name'] }}" class="rounded-4">
                            @endif
                            <div class="absolute px-20 py-20">
                                <button class="button -blue-1 size-40 rounded-full bg-white">
                                    <i class="icon-heart text-16"></i>
                                </button>
                            </div>
                        </div>
                        @if (count($hotelsDetails['hotel']['hotel_images']) > 0)
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($hotelsDetails['hotel']['hotel_images'] as $key => $img)
                                @if ($i == 0 || $i == 1)
                                    <div class="galleryGrid__item">
                                        <img src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/gallery/' . $img['file_path'])) }}"
                                            alt="{{ $hotelsDetails['hotel']['hotel_name'] }}" class="rounded-4">
                                    </div>
                                @endif
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        @endif

                        @if (count($hotelsDetails['hotel']['hotel_images']) > 2)
                            @php
                                $j = 0;
                            @endphp
                            <div class="galleryGrid__item relative d-flex justify-end items-end">
                                @foreach ($hotelsDetails['hotel']['hotel_images'] as $key => $img)
                                    @if ($j == 2)
                                        <img src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/gallery/' . $img['file_path'])) }}"
                                            alt="{{ $hotelsDetails['hotel']['hotel_name'] }}" class="rounded-4">
                                    @endif
                                    @php
                                        $j++;
                                    @endphp
                                @endforeach
                                @php
                                    $k = 0;
                                @endphp
                                <div class="absolute px-10 py-10">
                                    @foreach ($hotelsDetails['hotel']['hotel_images'] as $key => $img)
                                        @if ($k == 3)
                                            <a href="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/gallery/' . $img['file_path'])) }}"
                                                class="button -blue-1 px-24 py-15 bg-white text-dark-1 js-gallery"
                                                data-gallery="gallery2">
                                                See All {{ count($hotelsDetails['hotel']['hotel_images']) }} Photos
                                            </a>
                                        @else
                                            <a href="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/gallery/' . $img['file_path'])) }}"
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
                                    <h1 class="text-26 fw-600">{{ $hotelsDetails['hotel']['hotel_name'] }}</h1>
                                </div>
                                @if ($hotelsDetails['hotel']['category'] > 0)
                                    <div class="col-auto">
                                        @for ($i = 1; $i <= $hotelsDetails['hotel']['category']; $i++)
                                            <i class="icon-star text-10 text-yellow-1"></i>
                                        @endfor
                                    </div>
                                @endif
                            </div>

                            <div class="row x-gap-20 y-gap-20 items-center">
                                <div class="col-auto">
                                    <div class="text-15 text-light-1">{{ $hotelsDetails['hotel']['hotel_address'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            @if (isset($hotelsDetails['hotel']['price']))
                                <div class="text-14 text-right">
                                    From
                                    <span
                                        class="text-22 text-dark-1 fw-500">{{ isset($hotelsDetails['hotel']['price']) ? $hotelsDetails['hotel']['price'] : '' }}</span>
                                </div>
                            @endif


                            <a href="#" class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5">
                                Select Room <div class="icon-arrow-top-right ml-15"></div>
                            </a>

                        </div>
                    </div>

                    <div id="overview" class="row y-gap-40 pt-40">
                        <div class="col-12">
                            <h3 class="text-22 fw-500 pt-40 border-top-light">Overview</h3>
                            <p class="text-dark-1 text-15 mt-20">
                                {!! $hotelsDetails['hotel']['hotel_description'] !!}
                            </p>
                        </div>
                        @if (count($hotelsDetails['hotel']['hotel_amenities']) > 0)
                            <div class="col-12">
                                <h3 class="text-22 fw-500 pt-40 border-top-light">Most Popular Hotel Amenities</h3>
                                <div class="row y-gap-10 pt-20">
                                    @foreach ($hotelsDetails['hotel']['hotel_amenities'] as $hotelamenities)
                                        <div class="col-md-5">
                                            <div class="d-flex x-gap-15 y-gap-15 items-center">
                                                <i class="icon-check"></i>
                                                <div class="text-15">{{ $hotelamenities['amenity_name'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if (count($hotelsDetails['hotel']['hotel_freebies']) > 0)
                            <div class="col-12">
                                <h3 class="text-22 fw-500 pt-40 border-top-light">Most Popular Hotel Freebies</h3>
                                <div class="row y-gap-10 pt-20">
                                    @foreach ($hotelsDetails['hotel']['hotel_freebies'] as $hotelfreebies)
                                        <div class="col-md-5">
                                            <div class="d-flex x-gap-15 y-gap-15 items-center">
                                                <i class="icon-check"></i>
                                                <div class="text-15">{{ $hotelfreebies['name'] }}</div>
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

                        @if (strlen($hotelsDetails['hotel']['hotel_latitude']) > 0 && strlen($hotelsDetails['hotel']['hotel_longitude']) > 0)
                            <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{ $hotelsDetails['hotel']['hotel_latitude'] }},{{ $hotelsDetails['hotel']['hotel_longitude'] }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        @endif
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
                    </div>
                    <div class="px-30 py-30 border-light rounded-4 mt-30">
                        <div class="d-flex items-center">
                            <div class="size-40 flex-center bg-blue-1 rounded-4">
                                <div class="text-14 fw-600 text-white">{{ $hotelsDetails['hotel']['hotel_review'] }}</div>
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

                            @if ($hotelsDetails['hotel']['hotel_amenities'])
                                <div class="row x-gap-10 y-gap-10 pt-20">
                                    @foreach ($hotelsDetails['hotel']['hotel_amenities'] as $amenity)
                                        <div class="col-auto">
                                            <div class="d-flex items-center py-5 px-20 rounded-100 border-light">
                                                <i class="icon-like text-12 text-blue-1 mr-10"></i>
                                                <div class="text-14 lh-15">
                                                    {{ $amenity['amenity_name'] }} <span
                                                        class="fw-500 text-blue-1">25</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
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
            @if (isset($hotelsDetails['roomDetails']) && count($hotelsDetails['roomDetails']) > 0)
                @php
                    $i = 0;
                @endphp
                @foreach ($hotelsDetails['roomDetails'] as $key => $rooms)
                    @php
                        $i++;
                    @endphp
                    @if ($i != 1)
                        <div class="mt-20">
                    @endif


                    <div class="bg-blue-2 rounded-4 px-30 py-30 sm:px-20 sm:py-20">
                        <div class="row y-gap-30">
                            <div class="col-xl-auto">
                                @if (strlen($rooms['room']['room_image']) > 0)
                                    <div class="ratio ratio-1:1 col-12 col-md-4 col-xl-12">
                                        <img src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/Room/' . $rooms['room']['id'] . '/' . $rooms['room']['room_image'])) }}"
                                            alt="{{ $rooms['room']['types']['room_type'] ? $rooms['room']['types']['room_type'] : '' }}"
                                            class="img-ratio rounded-4">
                                    </div>
                                @endif
                                <div class="">
                                    <div class="text-18 fw-500 mt-10">
                                        {{ $rooms['room']['types']['room_type'] ? $rooms['room']['types']['room_type'] : '' }}
                                    </div>
                                    @if (count($rooms['room']['amenities']) > 0)
                                        <div class="y-gap-5 pt-5">
                                            @foreach ($rooms['room']['amenities'] as $roomamenities)
                                                <div class="d-flex items-center">
                                                    <i class="icon-check text-12 mr-10"></i>
                                                    <div class="text-15">{{ $roomamenities['amenity_name'] }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl">

                                @if (count($rooms['room']['child']) > 0)
                                    @php
                                        $j = 0;
                                    @endphp
                                    @foreach ($rooms['room']['child'] as $key_child => $value_child)
                                        @php
                                            $j++;
                                        @endphp
                                        @if ($j == 1)
                                            <div class="bg-white rounded-4 px-30 py-30">
                                            @else
                                                <div class="bg-white rounded-4 px-30 mt-20">
                                        @endif
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
                                            <div
                                                class="col-lg-auto col-md-6 border-left-light lg:border-none text-right lg:text-left">
                                                <div class="pl-40 lg:pl-0">
                                                    <div class="text-14 lh-14 text-light-1 mb-5">Min
                                                        {{ $value_child['min_nights'] }} night</div>
                                                    <div class="text-20 lh-14 fw-500">{{ $value_child['price'] }}</div>
                                                    <a href="#"
                                                        class="button h-50 px-35 -dark-1 bg-blue-1 text-white mt-10">
                                                        Reserve <div class="icon-arrow-top-right ml-15"></div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                @endforeach
            @endif
        </div>
        </div>
        </div>
        @if ($i != 1)
            </div>
        @endif
        @endforeach
        @endif
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

                @if (count($hotelsRelated) > 0)
                    @foreach ($hotelsRelated as $key => $value)
                        <div class="col-xl-3 col-lg-3 col-sm-6">
                            <a href="{{ route('hotel-details', $safeencryptionObj->encode($value['id'])) }}"
                                class="hotelsCard -type-1 ">
                                <div class="hotelsCard__image">
                                    <div class="cardImage ratio ratio-1:1">
                                        <div class="cardImage__content">
                                            @if (count($value['hotel_images']) > 0)
                                                <div
                                                    class="cardImage-slider rounded-4 overflow-hidden js-cardImage-slider">
                                                    <div class="swiper-wrapper">
                                                        @foreach ($value['hotel_images'] as $key => $img)
                                                            <div class="swiper-slide">
                                                                <img class="col-12"
                                                                    src="{{ url(Storage::url('app/upload/Hotel/' . $img['hotel_id'] . '/gallery/' . $img['file_path'])) }}"
                                                                    alt="{{ $hotelsDetails['hotel']['hotel_name'] }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="cardImage-slider__pagination js-pagination"></div>
                                                    <div class="cardImage-slider__nav -prev">
                                                        <button
                                                            class="button -blue-1 bg-white size-30 rounded-full shadow-2 js-prev">
                                                            <i class="icon-chevron-left text-10"></i>
                                                        </button>
                                                    </div>
                                                    <div class="cardImage-slider__nav -next">
                                                        <button
                                                            class="button -blue-1 bg-white size-30 rounded-full shadow-2 js-next">
                                                            <i class="icon-chevron-right text-10"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                @if (strlen($hotelsDetails['hotel']['hotel_image_location']) > 0)
                                                    <img class="rounded-4 col-12"
                                                        src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/' . $hotelsDetails['hotel']['hotel_image_location'])) }}"
                                                        alt="{{ $hotelsDetails['hotel']['hotel_name'] }}">
                                                @else
                                                    <img src="{{ asset('assets/front') }}/img/gallery/1/1.png"
                                                        alt="{{ $hotelsDetails['hotel']['hotel_name'] }}"
                                                        class="rounded-4 col-12">
                                                @endif
                                            @endif
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
                                        <span>{{ $value['hotel_name'] }}</span>
                                    </h4>
                                    <p class="text-light-1 lh-14 text-14 mt-5">{{ $value['hotel_address'] }}</p>
                                    <div class="d-flex items-center mt-20">
                                        <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">
                                            {{ $value['hotel_review'] }}
                                        </div>
                                        <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                        <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                                    </div>
                                    @if (isset($value['room']['price']))
                                        <div class="mt-5">
                                            <div class="fw-500">
                                                Starting from <span
                                                    class="text-blue-1">{{ isset($value['room']['price']) ? $value['room']['price'] : '' }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
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
