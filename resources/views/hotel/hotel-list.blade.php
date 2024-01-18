@extends('layouts.app')
@section('page_title', 'Home')
@section('content')
    <style>
        .cardImage__wishlist .button.active {
            background-color: var(--color-blue-1) !important;
            border-color: var(--color-blue-1);
            color: #fff !important;
        }
    </style>
    @php
   // dd($requestedArr);
        $search_from = date('d/m/Y', strtotime(date('Y-m-d')));
        $search_to = date('d/m/Y', strtotime(date('Y-m-d')));
        $selected_hotel_id = '';
    @endphp
    @if (isset($requestedArr) && isset($requestedArr['search_from']))
        @php
            $search_from = $requestedArr['search_from'] ? $requestedArr['search_from'] : date('d/m/Y', strtotime(date('Y-m-d')));
        @endphp
    @endif
    @if (isset($requestedArr) && isset($requestedArr['search_to']))
        @php
            $search_to = $requestedArr['search_to'] ? $requestedArr['search_to'] : date('d/m/Y', strtotime(date('Y-m-d')));
        @endphp
    @endif

    @if (isset($requestedArr) && isset($requestedArr['selected_hotel_id']) && $requestedArr['selected_hotel_id'] != null)
        @php
            $selected_hotel_id = $requestedArr['selected_hotel_id'];
        @endphp
    @endif

    <script>
        var check_in_startDate = "{!! $search_from !!}";
        var check_in_endDate = "{!! $search_to !!}";
        var extraParamHotel = [];
        var filterObj = {};
        filterObj.hotel_amenities = "";
        filterObj.room_amenities = "";
        filterObj.star = "";
        filterObj.price_range = "";
        filterObj.page = 1;
        filterObj.requested_city_id = "{!! $requestedArr['city_id'] ? $requestedArr['city_id'] : '' !!}";
        filterObj.requested_country_id = "{!! $requestedArr['country_id'] ? $requestedArr['country_id'] : '' !!}";
        filterObj.requested_search_from = "{!! $requestedArr['search_from'] ? $requestedArr['search_from'] : '' !!}";
        filterObj.requested_search_to = "{!! $requestedArr['search_to'] ? $requestedArr['search_to'] : '' !!}";
        filterObj.requested_location = "{!! $requestedArr['location'] ? $requestedArr['location'] : '' !!}";
        filterObj.selected_hotel_id = "{!! $selected_hotel_id !!}";
        filterObj.start_price_range = "";
        filterObj.end_price_range = "";
    </script>
    <div class="header-margin"></div>
    <section class="pt-40 pb-40 bg-dark-2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h1 class="text-30 fw-600 text-white">Find Your Dream Luxury Hotel</h1>
                    </div>
                    <form class="" id="SearchFrm" method="get" enctype="multipart/form-data"
                        action="{{ route('hotel-list') }}">
                        {{-- @csrf --}}
                        <div class="mainSearch -col-3-big bg-white px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 mt-30">
                            <div class="button-grid items-center">
                                <div class="pl-20 lg:py-20 lg:px-0 js-form-dd js-liverSearch">

                                    <div data-x-dd-click="searchMenu-loc">
                                        <h4 class="text-15 fw-500 ls-2 lh-16">Location</h4>
                                        <div class="text-15 text-light-1 ls-2 lh-16">
                                            <input autocomplete="off" type="search" placeholder="Where are you going?"
                                                class="js-search js-dd-focus" name="location" id="location"
                                                value="{{ isset($requestedArr['location']) ? $requestedArr['location'] : '' }}" />
                                            <input type="hidden" class="hidden_city_id" name="city_id"
                                                value="{{ isset($requestedArr['city_id']) ? $requestedArr['city_id'] : '' }}" />
                                            <input type="hidden" class="hidden_country_id" name="country_id"
                                                value="{{ isset($requestedArr['country_id']) ? $requestedArr['country_id'] : '' }}" />
                                        </div>
                                    </div>
                                    <div class="searchMenu-loc__field shadow-2 js-popup-window" data-x-dd="searchMenu-loc"
                                        data-x-dd-toggle="-is-active">
                                        <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                                            <div class="y-gap-5 js-results">
                                                @if (isset($requestedArr['location']) && strlen($requestedArr['location']) > 0)
                                                    <div>
                                                        <button type="button"
                                                            class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">
                                                            <div class="d-flex">
                                                                <div class="icon-location-2 text-light-1 text-20 pt-4">
                                                                </div>
                                                                <div class="ml-10">
                                                                    <div
                                                                        class="text-15 lh-12 fw-500 js-search-option-target">
                                                                        {{ isset($requestedArr['location']) ? $requestedArr['location'] : '' }}
                                                                    </div>
                                                                    <div class="text-14 lh-12 text-light-1 mt-5">
                                                                        {{ isset($country->name) ? $country->name : '' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="searchMenu-date px-30 lg:py-20 lg:px-0 js-form-dd js-calendar list-htl-date">
                                    <div data-x-dd-click="searchMenu-date">
                                        <h4 class="text-15 fw-500 ls-2 lh-16">Check in - Check out</h4>
                                        <div class="text-15 text-light-1 ls-2 lh-16">
                                            <input class="form-control daterange" placeholder="Check in - Check out"
                                                name="daterange" />
                                            <input type="hidden" id="hidden_from" name="search_from"
                                                value="{{ date('Y-m-d', strtotime(str_replace('/','-',$requestedArr['search_from']))) }}">
                                            <input type="hidden" id="hidden_to" name="search_to"
                                                value="{{ date('Y-m-d', strtotime(str_replace('/','-',$requestedArr['search_to']))) }}">
                                        </div>
                                    </div>
                                    <div style="display: none" class="searchMenu-date__field shadow-2"
                                        data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">
                                    </div>
                                </div>
                                <div class="searchMenu-guests px-30 lg:py-20 lg:px-0 js-form-dd js-form-counters">
                                    <div data-x-dd-click="searchMenu-guests">
                                        <h4 class="text-15 fw-500 ls-2 lh-16">Guest</h4>
                                        <div class="text-15 text-light-1 ls-2 lh-16" data-x-click="guest">
                                            <span
                                                class="js-count-adult">{{ getSearchCookies('searchGuestAdultCount') ? getSearchCookies('searchGuestAdultCount') : 1 }}</span>
                                            adults -
                                            <span
                                                class="js-count-child">{{ getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0 }}</span>
                                            childeren -
                                            <span
                                                class="js-count-room">{{ getSearchCookies('searchGuestRoomCount') ? getSearchCookies('searchGuestRoomCount') : 1 }}</span>
                                            room
                                        </div>
                                    </div>
                                    <div style="display:none;" class="searchMenu-guests__field shadow-2"
                                        data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
                                        <div class="bg-white px-30 py-30 rounded-4">
                                            <div class="row y-gap-10 justify-between items-center">
                                                <div class="col-auto">
                                                    <div class="text-15 fw-500">Adults</div>
                                                    <div class="text-14 lh-12 text-light-1 mt-5">(Above 12 Years)</div>
                                                </div>

                                                <div class="col-auto">
                                                    <div class="d-flex items-center js-counter"
                                                        data-value-change=".js-count-adult">
                                                        <button type="button"
                                                            class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                            <i class="icon-minus text-12"></i>
                                                        </button>

                                                        <div class="flex-center size-20 ml-15 mr-15">
                                                            <div class="text-15 js-count count-adults">
                                                                {{ $requestedArr['adult'] ? $requestedArr['adult'] : 1 }}
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
                                                    <div class="text-14 lh-12 text-light-1 mt-5">(Age 12 years & below)
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
                                                            <div class="text-15 js-count count-childs">
                                                                {{ $requestedArr['child'] ? $requestedArr['child'] : 0 }}
                                                            </div>
                                                        </div>

                                                        <button type="button"
                                                            class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">
                                                            <i class="icon-plus text-12"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row addChildList">

                                                    @if ($requestedArr['child'] == 1)
                                                        <div class="col-lg-6">
                                                            <label class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Age
                                                                of
                                                                child
                                                                1</label>
                                                            <select name="child_age[]" id="child_age">
                                                                @php
                                                                    $optionStr = '';
                                                                    for ($i = 0; $i <= 12; $i++) {
                                                                        if (isset($requestedArr['extra_data']['child_age_1']) && $requestedArr['extra_data']['child_age_1'] == $i) {
                                                                            echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                                                        }
                                                                    }
                                                                @endphp
                                                            </select>
                                                        </div>
                                                    @elseif ($requestedArr['child'] == 2)
                                                        <div class="col-lg-6">
                                                            <label class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Age
                                                                of
                                                                child
                                                                1</label>
                                                            <select name="child_age[]" id="child_age">
                                                                @php
                                                                    $optionStr = '';
                                                                    for ($i = 0; $i <= 12; $i++) {
                                                                        if (isset($requestedArr['extra_data']['child_age_1']) && $requestedArr['extra_data']['child_age_1'] == $i) {
                                                                            echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                                                        }
                                                                    }
                                                                @endphp
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Age
                                                                of
                                                                child
                                                                2</label>
                                                            <select name="child_age[]" id="child_age">
                                                                @php
                                                                    $optionStr = '';
                                                                    for ($i = 0; $i <= 12; $i++) {
                                                                        if (isset($requestedArr['extra_data']['child_age_2']) && $requestedArr['extra_data']['child_age_2'] == $i) {
                                                                            echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                                                        }
                                                                    }
                                                                @endphp
                                                            </select>
                                                        </div>
                                                    @elseif ($requestedArr['child'] > 2)
                                                        <div class="col-lg-6">
                                                            <label
                                                                class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Younger
                                                                Children</label>
                                                            <div class="text-14 lh-12 text-light-1 mt-5">Age : 0-6 yrs
                                                            </div>
                                                            <select name="child_age[]" id="child_age_younger"
                                                                class="childMore"
                                                                data-child="{{ $requestedArr['child'] }}">
                                                                @php
                                                                    $optionStr = '';
                                                                    for ($i = 0; $i <= $requestedArr['child']; $i++) {
                                                                        if (isset($requestedArr['extra_data']['child_younger']) && $requestedArr['extra_data']['child_younger'] == $i) {
                                                                            echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                                                        }
                                                                    }
                                                                @endphp
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label
                                                                class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Older
                                                                Children</label>
                                                            <div class="text-14 lh-12 text-light-1 mt-5">Age : 7-12 yrs
                                                            </div>
                                                            <select name="child_age[]" id="child_age_older"
                                                                class="childMore"
                                                                data-child="{{ $requestedArr['child'] }}">
                                                                @php
                                                                    $optionStr = '';
                                                                    for ($i = 0; $i <= $requestedArr['child']; $i++) {
                                                                        if (isset($requestedArr['extra_data']['child_older']) && $requestedArr['extra_data']['child_older'] == $i) {
                                                                            echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                                                        }
                                                                    }
                                                                @endphp
                                                            </select>
                                                        </div>
                                                    @endif

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
                                                            <div class="text-15 js-count count-rooms">
                                                                {{ $requestedArr['room'] ? $requestedArr['room'] : 1 }}
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
                                        class="mainSearch__submit button -dark-1 py-15 px-40 col-12 rounded-4 bg-blue-1 text-white">
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

    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row y-gap-30">
                <div class="col-xl-3 col-lg-4 lg:d-none">
                    <aside class="sidebar y-gap-40">
                        <div class="sidebar__item">
                            <h5 class="text-18 fw-500 mb-10">Star Rating</h5>
                            <div class="row x-gap-10 y-gap-10 pt-10">

                                <div class="new-check-box">
                                    <div class="boxes">
                                        <ul>
                                            <li><input type="checkbox" id="box-all" name="rating" checked
                                                    data-star="all"
                                                    class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100 starClick numrateAllchk">
                                                <label for="box-all"><span>All</span></label>
                                            </li>
                                            <li><input type="checkbox" id="box-1" name="rating" data-star="1"
                                                    class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100 starClick numratechk">
                                                <label for="box-1"><span class="px-5">1</span></label>
                                            </li>
                                            <li><input type="checkbox" id="box-2" name="rating" data-star="2"
                                                    class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100 starClick numratechk">
                                                <label for="box-2"><span class="px-5">2</span></label>
                                            </li>
                                            <li><input type="checkbox" id="box-3" name="rating" data-star="3"
                                                    class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100 starClick numratechk">
                                                <label for="box-3"><span class="px-5">3</span></label>
                                            </li>
                                            <li><input type="checkbox" id="box-4" name="rating" data-star="4"
                                                    class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100 starClick numratechk">
                                                <label for="box-4"><span class="px-5">4</span></label>
                                            </li>
                                            <li><input type="checkbox" id="box-5" name="rating" data-star="5"
                                                    class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100 starClick numratechk">
                                                <label for="box-5"><span class="px-5">5</span></label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__item pb-30">
                            <h5 class="text-18 fw-500 mb-10">Nightly Price</h5>
                            <div class="row x-gap-10 y-gap-30">
                                <div class="col-12">
                                    <div class="js-price-rangeSlider" id="js-price-rangeSlider">
                                        <div class="text-14 fw-500"></div>
                                        <div class="d-flex justify-between mb-20">
                                            <div class="text-15 text-dark-1">
                                                <span class="js-lower"></span>
                                                -
                                                <span class="js-upper"></span>
                                            </div>
                                        </div>
                                        <div class="px-5">
                                            <div class="js-slider"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__item">
                            <h5 class="text-18 fw-500 mb-10">Hotel Amenities</h5>
                            <div class="sidebar-checkbox">
                                @if ($amenitiesArr->count() > 0)
                                    @foreach ($amenitiesArr as $key => $value)
                                        @if ($value->type == 1)
                                            <div class="row y-gap-10 items-center justify-between hotel_amenities">
                                                <div class="col-auto">
                                                    <div class="d-flex items-center">
                                                        <div class="form-checkbox ">
                                                            <input type="checkbox" name="hotel_amenities[]"
                                                                value="{{ $value->id }}" class="hotel_amenity">
                                                            <div class="form-checkbox__mark">
                                                                <div class="form-checkbox__icon icon-check"></div>
                                                            </div>
                                                        </div>
                                                        <div class="text-15 ml-10">{{ $value->amenity_name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>


                    </aside>
                </div>

                <div class="col-xl-9 col-lg-8">
                    <div class="row y-gap-30 ajax-list-display1">
                        <div id="overlay">
                            <div class="cv-spinner">
                                <span class="spinner"></span>
                            </div>
                        </div>
                        <?php if(strlen($selected_hotel_id) > 0) { ?>
                            <div class="col-auto">
                                <div class="text-18">                                    
                                    {{ isset($requestedArr['location']) ? $requestedArr['location'] : '' }}
                                </div>
                                <div class="text-12">
                                    <span class="fw-500"><span class="">{{ dateFormat($requestedArr['startDate'],'M d, Y') }} - {{ dateFormat($requestedArr['endDate'],'M d, Y') }} ({{ $requestedArr['nights'] }} Nights)</span></span>
                                    <span class="fw-500"><span class="">{{ $requestedArr['room'] }} Rooms, {{ $requestedArr['adult'] }} Adults, {{ $requestedArr['child'] }} Children</span></span>                                    
                                </div>
                            </div>
                        <div class="row y-gap-30 ajax-list-display-selected">
                            <?php
                            echo $hotelListView;
                            ?>
                        </div>
                        <?php } ?>

                        <div class="row y-gap-10 items-center justify-between">
                            <?php if(strlen($selected_hotel_id) > 0) { ?>
                            <div class="col-auto">
                                <div class="text-18">
                                    <span class="fw-500"><span class="foundPropertyCount"></span>
                                        Other hotels </span> in
                                    {{ isset($requestedArr['location']) ? $requestedArr['location'] : '' }}
                                </div>
                                <div class="text-12">
                                    <span class="fw-500"><span class="">{{ dateFormat($requestedArr['startDate'],'M d, Y') }} - {{ dateFormat($requestedArr['endDate'],'M d, Y') }} ({{ $requestedArr['nights'] }} Nights)</span></span>
                                    <span class="fw-500"><span class="">{{ $requestedArr['room'] }} Rooms, {{ $requestedArr['adult'] }} Adults, {{ $requestedArr['child'] }} Children</span></span>                                    
                                </div>
                            </div>
                            {{-- <div class="col-auto">
                                <div class="row x-gap-20 y-gap-20">
                                    <div class="col-auto">
                                        <button
                                            class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1">
                                            <i class="icon-up-down text-14 mr-10"></i>
                                            Top picks for your search
                                        </button>
                                    </div>
                                    <div class="col-auto d-none lg:d-block">
                                        <button data-x-click="filterPopup"
                                            class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1">
                                            <i class="icon-up-down text-14 mr-10"></i>
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                            <?php } else { ?>
                            <div class="col-auto">
                                <div class="text-18">
                                    <span class="fw-500">
                                        <span class="foundPropertyCount"></span>
                                        properties</span> in
                                    {{ isset($requestedArr['location']) ? $requestedArr['location'] : '' }}
                                </div>
                                <div class="text-12">
                                    <span class="fw-500"><span class="">{{ dateFormat($requestedArr['startDate'],'M d, Y') }} - {{ dateFormat($requestedArr['endDate'],'M d, Y') }} ({{ $requestedArr['nights'] }} Nights)</span></span>
                                    <span class="fw-500"><span class="">{{ $requestedArr['room'] }} Rooms, {{ $requestedArr['adult'] }} Adults, {{ $requestedArr['child'] }} Children</span></span>                                    
                                </div>
                            </div>
                            {{-- <div class="col-auto">
                                <div class="row x-gap-20 y-gap-20">
                                    <div class="col-auto">
                                        <button
                                            class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1">
                                            <i class="icon-up-down text-14 mr-10"></i>
                                            Top picks for your search
                                        </button>
                                    </div>

                                    <div class="col-auto d-none lg:d-block">
                                        <button data-x-click="filterPopup"
                                            class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1">
                                            <i class="icon-up-down text-14 mr-10"></i>
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                            <?php } ?>
                        </div>
                        <div class="row y-gap-30 ajax-list-display">
                        </div>
                    </div>
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
    <script src="{{ asset('assets/front/js/search-form/Currencies.js') }}"></script> 

    <script src="{{ asset('assets/front/js/sweet-alert.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('.dropdown.orderby').click(function() {
                $('.dropdown-menu').slideToggle("fast");
            });
        });

        var moduleConfig = {
            searchLocationByName: "{!! route('city-hotel-list') !!}",
            ajaxURL: "{!! route('hotel-list-ajax') !!}",
            filterObjParamStartDate: filterObj.requested_search_from,
            filterObjParamEndDate: filterObj.requested_search_to,
            filterObjParamStartPrice: filterObj.start_price_range,
            filterObjParamEndPrice: filterObj.end_price_range,
            filterObjParamCityID: filterObj.requested_city_id,
            filterObjParamLocation: filterObj.requested_location,
            filterObjParamSelectedHotel: filterObj.selected_hotel_id,
            ajaxRoomURL: "{!! route('room-list-ajax') !!}",
            addToWishList: "{!! route('add-to-wishlist') !!}",
            addedToCartBooking: "{!! route('ajax-temp-store') !!}",
            removeToCartBooking: "{!! route('ajax-temp-remove') !!}",
        };


        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                filterObj.page = page;
                getAllHotelList(filterObj);
            });

            $(document).on('change', '.hotel_amenity', function(e) {
                filterObj.hotel_amenities = "";
                $(".hotel_amenities input.hotel_amenity:checked").each(function() {
                    filterObj.hotel_amenities += ', ' + $(this).val();
                });
                getAllHotelList(filterObj);
            });

            $(document).on('change', '.room_amenity', function() {
                filterObj.room_amenities = "";
                $(".room_amenities input.room_amenity:checked").each(function() {
                    filterObj.room_amenities += ', ' + $(this).val();
                });
                getAllHotelList(filterObj);

            });
            $(document).on('click', '.starClick', function() {

                filterObj.star = "";

                var starArr = [];
                if ($(this).attr('data-star') == 'all') {
                    $('.numratechk').prop('checked', false);

                    $(".new-check-box input:checkbox[name=rating]:checked").each(function() {
                        starArr.push($(this).attr('data-star'));
                        //filterObj.star += ', ' + $(this).attr('data-star');
                    });

                    if (starArr.length === 0) {
                        $(this).prop('checked', true);
                        //starArr.push('all');
                    }


                } else {
                    $(".new-check-box input:checkbox[name=rating]:checked").each(function() {
                        if ($(this).attr('data-star') != "all") {
                            $(this).prop('checked', true);
                            starArr.push($(this).attr('data-star'));
                            filterObj.star += ', ' + $(this).attr('data-star');
                        } else {
                            $('.numrateAllchk').prop('checked', false);
                        }
                    });
                }

                if (starArr.length === 0) {
                    $('.numrateAllchk').prop('checked', true);
                    // starArr.push('all');
                }


                getAllHotelList(filterObj);

            });

            var slider = document.querySelector('.js-slider');
            const snapValues = [
                slider.querySelector('.js-lower'),
                slider.querySelector('.js-upper')
            ]
            slider.noUiSlider.on('change', function(values, handle) {
                //snapValues[handle].innerHTML = values[handle];
                $.each(values, function(index, value) {
                    if (index == 0) {
                        filterObj.start_price_range = value;
                    }
                    if (index == 1) {
                        filterObj.end_price_range = value;
                    }
                });
                getAllHotelList(filterObj);
            })

            // slider.noUiSlider.on('update', function(values, handle) {
            // snapValues[handle].innerHTML = values[handle];          
            // })
        });

        document.addEventListener('DOMContentLoaded', function() {
            getAllHotelList(filterObj);
        }, false);

        function getAllHotelList(requested) {
            $.ajax({
                type: 'GET',
                url: moduleConfig.ajaxURL + '?page=' + requested.page,
                dataType: 'json',
                beforeSend: function() {
                    $("#overlay").show();
                    $('.ajax-list-display').hide();
                },
                complete: function() {
                    $('.ajax-list-display').show();
                    $('#overlay').hide();
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    hotel_amenities: requested.hotel_amenities,
                    price_range: requested.price_range,
                    requested_city_id: requested.requested_city_id,
                    requested_country_id: requested.requested_country_id,
                    requested_location: requested.requested_location,
                    requested_selected_hotel_id: requested.selected_hotel_id,
                    // page: requested.page,
                    requested_search_from: requested.requested_search_from,
                    requested_search_to: requested.requested_search_to,
                    room_amenities: requested.room_amenities,
                    star: requested.star,
                    start_price_range: requested.start_price_range,
                    end_price_range: requested.end_price_range,
                },
                success: function(data) {
                    if (data.status == 200) {
                        $('.foundPropertyCount').html('');
                        $('.foundPropertyCount').html(data.count);
                        $('.ajax-list-display').html('');
                        $('.ajax-list-display').html(data.data);

                        GLightbox({
                            selector: '.js-gallery',
                            touchNavigation: true,
                            loop: false,
                            autoplayVideos: true,
                        });

                        jQuery('html, body').animate({
                            scrollTop: jQuery(".topScroll").offset().top
                        }, 777);
                    }


                }
            });
        }
    </script>
    <script>
        function changeImage(image) {
            var newSrc = image.src;
            document.getElementById('expandedImg').src = newSrc;
        }
    </script>
    <script>
        function toggleTextAndIcon(element) {
            var text = element.textContent.trim();
            if (text === 'More prices & boards') {
                element.innerHTML = 'Hide board types' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">' +
                    '<path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>' +
                    '</svg>';
            } else {
                element.innerHTML = 'More prices & boards ' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">' +
                    '<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>' +
                    '</svg>';
            }
        }
    </script>
    <script>
        $(document).ready(function() {
                // Use event delegation to ensure the code runs even if .list-htl-date is added later
                $(document).on('click', '.list-htl-date', function() {
                    $('.daterangepicker.ltr.show-calendar.opensleft').appendTo(this);
                });
            });

    </script>


@endsection
