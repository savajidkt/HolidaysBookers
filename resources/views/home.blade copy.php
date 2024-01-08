@extends('layouts.app')
@section('page_title', 'Home')
@section('content')

    <script>
        var check_in_startDate = "{!! date('m-d-Y') !!}";
        var check_in_endDate = "{!! date('m-d-Y') !!}";
    </script>

    <section data-anim-wrap class="masthead -type-3 relative z-5">
        <div data-anim-child="fade delay-1" class="masthead__bg bg-dark-3">
            <img src="{{ asset('assets/front') }}/img/masthead/3/bg.png" alt="image">
        </div>
        <div class="container">
            <div class="row justify-center">
                <div class="col-xl-10">
                    <div class="text-center">
                        <h1 data-anim-child="slide-up delay-4" class="text-60 lg:text-40 md:text-30 text-white">Discover Your
                            World</h1>
                        <p data-anim-child="slide-up delay-5" class="text-white mt-5">Discover amzaing places at exclusive
                            deals</p>
                    </div>
                    <div data-anim-child="slide-up delay-6" class="masthead__tabs">
                        <div class="tabs -bookmark js-tabs">
                            <div class="tabs__controls d-flex items-center js-tabs-controls">
                                <div class="">
                                    <button
                                        class="tabs__button px-30 py-20 rounded-4 fw-600 text-white js-tabs-button is-tab-el-active"
                                        data-tab-target=".-tab-item-1">
                                        <i class="icon-bed text-20 mr-10"></i>
                                        Hotel
                                    </button>
                                </div>
                                <div class="">
                                    <button class="tabs__button px-30 py-20 rounded-4 fw-600 text-white js-tabs-button "
                                        data-tab-target=".-tab-item-2">
                                        <i class="icon-ski text-20 mr-10"></i>
                                        Sightseeing
                                    </button>
                                </div>

                                <div class="">
                                    <button class="tabs__button px-30 py-20 rounded-4 fw-600 text-white js-tabs-button "
                                        data-tab-target=".-tab-item-3">
                                        <i class="icon-car text-20 mr-10"></i>
                                        Transfer
                                    </button>
                                </div>
                            </div>
                            <div class="tabs__content js-tabs-content">
                                <div class="tabs__pane -tab-item-1 is-tab-el-active">
                                    <form class="needs-validation1" id="SearchFrm" method="get"
                                        enctype="multipart/form-data" action="{{ route('hotel-list') }}">
                                        {{-- @csrf --}}
                                        <div
                                            class="mainSearch bg-white pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 shadow-1">
                                            <div class="button-grid items-center">
                                                <div
                                                    class="searchMenu-loc px-30 lg:py-20 lg:px-0 js-form-dd js-liverSearch">
                                                    <div data-x-dd-click="searchMenu-loc">
                                                        <h4 class="text-15 fw-500 ls-2 lh-16">Location</h4>
                                                        <div class="text-15 text-light-1 ls-2 lh-16">
                                                            <input autocomplete="off" type="search"
                                                                placeholder="Where are you going?"
                                                                class="js-search js-dd-focus" name="location"
                                                                id="location" />
                                                            <input type="hidden" class="hidden_city_id" name="city_id" />
                                                            <input type="hidden" class="hidden_country_id"
                                                                name="country_id" />
                                                        </div>
                                                        <span id="basic-addon-location-error"
                                                            class="help-block help-block-error"></span>
                                                    </div>
                                                    <div class="searchMenu-loc__field shadow-2 js-popup-window"
                                                        data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
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
                                                            <input type="hidden" id="hidden_from" name="search_from"
                                                                value="">
                                                            <input type="hidden" id="hidden_to" name="search_to"
                                                                value="">
                                                        </div>
                                                        <span id="basic-addon-date-error"
                                                            class="help-block help-block-error"></span>
                                                    </div>
                                                    <div style="display: none" class="searchMenu-date__field shadow-2"
                                                        data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">
                                                    </div>
                                                </div>
                                                <div
                                                    class="searchMenu-guests px-30 lg:py-20 lg:px-0 js-form-dd js-form-counters">
                                                    <div data-x-dd-click="searchMenu-guests">
                                                        <h4 class="text-15 fw-500 ls-2 lh-16">Guest</h4>
                                                        <div class="text-15 text-light-1 ls-2 lh-16">
                                                            <span class="js-count-adult">1</span> adults
                                                            -
                                                            <span class="js-count-child">0</span> childeren
                                                            -
                                                            <span class="js-count-room">1</span> room
                                                        </div>
                                                        <span id="basic-addon-guest-error"
                                                            class="help-block help-block-error"></span>
                                                    </div>
                                                    <div class="searchMenu-guests__field shadow-2"
                                                        data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
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
                                                                <div class="row addChildList">

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
                                <div class="tabs__pane -tab-item-2">

                                    <form class="needs-validation1" id="SearchFrmSightseeing" method="get"
                                        enctype="multipart/form-data" action="{{ route('hotel-list') }}">
                                        {{-- @csrf --}}

                                        <div
                                            class="mainSearch bg-white pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 shadow-1">
                                            <div class="button-grid items-center">
                                                <div
                                                    class="searchMenu-loc px-30 lg:py-20 lg:px-0 js-form-dd js-liverSearch">
                                                    <div data-x-dd-click="searchMenu-loc">
                                                        <h4 class="text-15 fw-500 ls-2 lh-16">Location</h4>
                                                        <div class="text-15 text-light-1 ls-2 lh-16">
                                                            <input autocomplete="off" type="search"
                                                                placeholder="Where are you going?"
                                                                class="js-search js-dd-focus" name="location"
                                                                id="location" />
                                                            <input type="hidden" class="hidden_city_id"
                                                                name="city_id" />
                                                            <input type="hidden" class="hidden_country_id"
                                                                name="country_id" />
                                                        </div>
                                                        <span id="basic-addon-location-error"
                                                            class="help-block help-block-error"></span>
                                                    </div>
                                                    <div class="searchMenu-loc__field shadow-2 js-popup-window"
                                                        data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
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
                                                            <input type="hidden" id="hidden_from" name="search_from"
                                                                value="">
                                                            <input type="hidden" id="hidden_to" name="search_to"
                                                                value="">
                                                        </div>
                                                        <span id="basic-addon-date-error"
                                                            class="help-block help-block-error"></span>
                                                    </div>
                                                    <div style="display: none" class="searchMenu-date__field shadow-2"
                                                        data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">                                                       
                                                    </div>
                                                </div>
                                                <div
                                                    class="searchMenu-guests px-30 lg:py-20 lg:px-0 js-form-dd js-form-counters">
                                                    <div data-x-dd-click="searchMenu-guests">
                                                        <h4 class="text-15 fw-500 ls-2 lh-16">Guest</h4>
                                                        <div class="text-15 text-light-1 ls-2 lh-16">
                                                            <span class="js-count-adult">1</span> adults
                                                            -
                                                            <span class="js-count-child">0</span> childeren
                                                            -
                                                            <span class="js-count-room">1</span> room
                                                        </div>
                                                        <span id="basic-addon-guest-error"
                                                            class="help-block help-block-error"></span>
                                                    </div>
                                                    <div class="searchMenu-guests__field shadow-2"
                                                        data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
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
                                <div class="tabs__pane -tab-item-3">

                                    {{-- <form class="needs-validation1" id="SearchFrmTransfer" method="get"
                                        enctype="multipart/form-data" action="{{ route('hotel-list') }}">                                        --}}

                                    <div
                                        class="mainSearch -col-4 -w-1070 bg-white shadow-1 rounded-4 pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 mt-15">
                                        <div class="button-grid items-center transfer-cls">
                                            <div class="searchMenu-loc px-24 lg:py-20 lg:px-0 js-form-dd js-liverSearch">

                                                <div data-x-dd-click="searchMenu-loc">
                                                    <h4 class="text-15 fw-500 ls-2 lh-16">From</h4>
                                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                                        <input autocomplete="off" type="search"
                                                            placeholder="City or Airport" class="js-search js-dd-focus" />
                                                    </div>
                                                </div>
                                                <div class="searchMenu-loc__field shadow-2 js-popup-window"
                                                    data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
                                                    <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                                                        <div class="y-gap-5 js-results">
                                                            <div>
                                                                <button
                                                                    class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">
                                                                    <div class="d-flex">
                                                                        <div
                                                                            class="icon-location-2 text-light-1 text-20 pt-4">
                                                                        </div>
                                                                        <div class="ml-10">
                                                                            <div
                                                                                class="text-15 lh-12 fw-500 js-search-option-target">
                                                                                London</div>
                                                                            <div class="text-14 lh-12 text-light-1 mt-5">
                                                                                Greater London, United Kingdom</div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="searchMenu-loc px-24 lg:py-20 lg:px-0 js-form-dd js-liverSearch">
                                                <div data-x-dd-click="searchMenu-loc">
                                                    <h4 class="text-15 fw-500 ls-2 lh-16">To</h4>
                                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                                        <input autocomplete="off" type="search"
                                                            placeholder="City or Airport" class="js-search js-dd-focus" />
                                                    </div>
                                                </div>
                                                <div class="searchMenu-loc__field shadow-2 js-popup-window"
                                                    data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
                                                    <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                                                        <div class="y-gap-5 js-results">
                                                            <div>
                                                                <button
                                                                    class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">
                                                                    <div class="d-flex">
                                                                        <div
                                                                            class="icon-location-2 text-light-1 text-20 pt-4">
                                                                        </div>
                                                                        <div class="ml-10">
                                                                            <div
                                                                                class="text-15 lh-12 fw-500 js-search-option-target">
                                                                                London</div>
                                                                            <div class="text-14 lh-12 text-light-1 mt-5">
                                                                                Greater London, United Kingdom</div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="searchMenu-date px-24 lg:py-20 lg:px-0">
                                                <div class="form-switch d-flex items-center mt-20">
                                                    <div class="switch">
                                                        <input type="checkbox" checked class="round-trip">
                                                        <span class="switch__slider"></span>
                                                    </div>

                                                </div>
                                                <span class="js-first-date">Round trip</span>
                                            </div>
                                            <div class="searchMenu-date px-24 lg:py-20 lg:px-0 js-form-dd js-calendar">
                                                <div data-x-dd-click="searchMenu-date">
                                                    <h4 class="text-15 fw-500 ls-2 lh-16">Departure date</h4>
                                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                                        <input class="form-control" placeholder="Departure date"
                                                            name="daterange_transfer_departure" />
                                                        <input type="hidden" id="daterange_transfer_departure_from"
                                                            name="daterange_transfer_departure_from" value="">
                                                    </div>
                                                </div>
                                                <div style="display: none" class="searchMenu-date__field shadow-2"
                                                    data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">
                                                </div>
                                            </div>
                                            <div class="searchMenu-date px-24 lg:py-20 lg:px-0 js-form-dd js-calendar transfer_return_round">
                                                <div data-x-dd-click="searchMenu-date">
                                                    <h4 class="text-15 fw-500 ls-2 lh-16">Return date</h4>
                                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                                        <input class="form-control" placeholder="Return date"
                                                            name="daterange_transfer_return" />
                                                        <input type="hidden" id="daterange_transfer_return"
                                                            name="daterange_transfer_return" value="">
                                                    </div>
                                                </div>
                                                <div style="display: none" class="searchMenu-date__field shadow-2"
                                                    data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">
                                                </div>
                                            </div>
                                            <div
                                                class="searchMenu-guests px-24 lg:py-20 lg:px-0 js-form-dd js-form-counters">

                                                <div data-x-dd-click="searchMenu-guests">
                                                    <h4 class="text-15 fw-500 ls-2 lh-16">Transfers</h4>

                                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                                        <span class="js-count-adult">2</span> adults
                                                        -
                                                        <span class="js-count-child">0</span> childeren

                                                    </div>
                                                </div>


                                                <div class="searchMenu-guests__field shadow-2"
                                                    data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
                                                    <div class="bg-white px-30 py-30 rounded-4">
                                                        <div class="row y-gap-10 justify-between items-center">
                                                            <div class="col-auto">
                                                                <div class="text-15 fw-500">Adults</div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="d-flex items-center js-counter"
                                                                    data-value-change=".js-count-adult">
                                                                    <button
                                                                        class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                                        <i class="icon-minus text-12"></i>
                                                                    </button>

                                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                                        <div class="text-15 js-count">2</div>
                                                                    </div>

                                                                    <button
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
                                                                    2</div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="d-flex items-center js-counter"
                                                                    data-value-change=".js-count-child">
                                                                    <button
                                                                        class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">
                                                                        <i class="icon-minus text-12"></i>
                                                                    </button>

                                                                    <div class="flex-center size-20 ml-15 mr-15">
                                                                        <div class="text-15 js-count">0</div>
                                                                    </div>

                                                                    <button
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

                                    {{-- </form> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <section class="layout-pt-lg layout-pb-md">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Featured Services</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">These popular destinations have a lot to offer</p>
                    </div>
                </div>
            </div>

            <div class="row y-gap-20 pt-40">
                <div data-anim-child="slide-left delay-3" class="col-lg-4 col-sm-6">

                    <div class="ctaCard -type-1 rounded-4 ">
                        <div class="ctaCard__image ratio ratio-41:45">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ asset('assets/front') }}/img/backgrounds/1.png" alt="image">
                        </div>
                        <div class="ctaCard__content py-50 px-50 lg:py-30 lg:px-30">
                            <h4 class="text-30 lg:text-24 text-white">Hotel</h4>
                            <div class="text-15 fw-500 text-white mb-10">250,000+ Hotel and Apartments Rooms Worldwide
                            </div>
                        </div>
                    </div>

                </div>

                <div data-anim-child="slide-left delay-4" class="col-lg-4 col-sm-6">

                    <div class="ctaCard -type-1 rounded-4 ">
                        <div class="ctaCard__image ratio ratio-41:45">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ asset('assets/front') }}/img/backgrounds/3.png" alt="image">
                        </div>

                        <div class="ctaCard__content py-50 px-50 lg:py-30 lg:px-30">
                            <h4 class="text-30 lg:text-24 text-white">Sightseeing</h4>
                            <div class="text-15 fw-500 text-white mb-10">45,000+Sightseeing items and over 5000 Tours in
                                500 cities</div>
                        </div>
                    </div>

                </div>

                <div data-anim-child="slide-left delay-5" class="col-lg-4 col-sm-6">

                    <div class="ctaCard -type-1 rounded-4 ">
                        <div class="ctaCard__image ratio ratio-41:45">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ asset('assets/front') }}/img/backgrounds/2.png" alt="image">
                        </div>

                        <div class="ctaCard__content py-50 px-50 lg:py-30 lg:px-30">
                            <h4 class="text-30 lg:text-24 text-white">Transfer</h4>
                            <div class="text-15 fw-500 text-white mb-10">5,000+ Transfer Options in Over 900 Airport and
                                City Locations</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-md">
        <div class="container">
            <div class="row justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Why Choose Us</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">These popular destinations have a lot to offer</p>
                    </div>
                </div>
            </div>

            <div class="row y-gap-40 justify-between pt-50">

                <div class="col-lg-3 col-sm-6">

                    <div class="featureIcon -type-1 ">
                        <div class="d-flex justify-center">
                            <img src="#" data-src="{{ asset('assets/front') }}/img/featureIcons/3/1.svg"
                                alt="image" class="js-lazy">
                        </div>

                        <div class="text-center mt-30">
                            <h4 class="text-18 fw-500">Best Price Guarantee</h4>
                            <p class="text-15 mt-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-3 col-sm-6">

                    <div class="featureIcon -type-1 ">
                        <div class="d-flex justify-center">
                            <img src="#" data-src="{{ asset('assets/front') }}/img/featureIcons/3/2.svg"
                                alt="image" class="js-lazy">
                        </div>

                        <div class="text-center mt-30">
                            <h4 class="text-18 fw-500">Easy & Quick Booking</h4>
                            <p class="text-15 mt-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-3 col-sm-6">

                    <div class="featureIcon -type-1 ">
                        <div class="d-flex justify-center">
                            <img src="#" data-src="{{ asset('assets/front') }}/img/featureIcons/3/3.svg"
                                alt="image" class="js-lazy">
                        </div>

                        <div class="text-center mt-30">
                            <h4 class="text-18 fw-500">Customer Care 24/7</h4>
                            <p class="text-15 mt-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-md">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Top Destinations</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">These popular destinations have a lot to offer</p>
                    </div>
                </div>
            </div>

            <div class="row y-gap-40 justify-between pt-40 sm:pt-20">

                <div data-anim-child="slide-up delay-3" class="col-xl-3 col-md-4 col-sm-6">

                    <a href="#" class="citiesCard -type-3 d-block rounded-4 ">
                        <div class="citiesCard__image ratio ratio-1:1">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ asset('assets/front') }}/img/destinations/2/1.png" alt="image">
                        </div>

                        <div class="citiesCard__content px-30 py-30">
                            <h4 class="text-26 fw-600 text-white">Los Angeles</h4>
                            <div class="text-15 text-white">1,714 properties</div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-4" class="col-xl-6 col-md-4 col-sm-6">

                    <a href="#" class="citiesCard -type-3 d-block rounded-4 h-full">
                        <div class="citiesCard__image ">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ asset('assets/front') }}/img/destinations/2/2.png" alt="image">
                        </div>

                        <div class="citiesCard__content px-30 py-30">
                            <h4 class="text-26 fw-600 text-white">London</h4>
                            <div class="text-15 text-white">1,714 properties</div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-5" class="col-xl-3 col-md-4 col-sm-6">

                    <a href="#" class="citiesCard -type-3 d-block rounded-4 ">
                        <div class="citiesCard__image ratio ratio-1:1">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ asset('assets/front') }}/img/destinations/2/3.png" alt="image">
                        </div>

                        <div class="citiesCard__content px-30 py-30">
                            <h4 class="text-26 fw-600 text-white">Reykjavik</h4>
                            <div class="text-15 text-white">1,714 properties</div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-6" class="col-xl-6 col-md-4 col-sm-6">

                    <a href="#" class="citiesCard -type-3 d-block rounded-4 h-full">
                        <div class="citiesCard__image ">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ asset('assets/front') }}/img/destinations/2/4.png" alt="image">
                        </div>

                        <div class="citiesCard__content px-30 py-30">
                            <h4 class="text-26 fw-600 text-white">Paris</h4>
                            <div class="text-15 text-white">1,714 properties</div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-7" class="col-xl-3 col-md-4 col-sm-6">

                    <a href="#" class="citiesCard -type-3 d-block rounded-4 ">
                        <div class="citiesCard__image ratio ratio-1:1">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ asset('assets/front') }}/img/destinations/2/5.png" alt="image">
                        </div>

                        <div class="citiesCard__content px-30 py-30">
                            <h4 class="text-26 fw-600 text-white">Amsterdam</h4>
                            <div class="text-15 text-white">1,714 properties</div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-8" class="col-xl-3 col-md-4 col-sm-6">

                    <a href="#" class="citiesCard -type-3 d-block rounded-4 ">
                        <div class="citiesCard__image ratio ratio-1:1">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ asset('assets/front') }}/img/destinations/2/6.png" alt="image">
                        </div>

                        <div class="citiesCard__content px-30 py-30">
                            <h4 class="text-26 fw-600 text-white">Istanbul</h4>
                            <div class="text-15 text-white">1,714 properties</div>
                        </div>
                    </a>

                </div>

            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-md">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-between items-end">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Recommended Hotels</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">Interdum et malesuada fames ac ante ipsum</p>
                    </div>
                </div>

                <div class="col-auto">

                    <a href="#" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                        More <div class="icon-arrow-top-right ml-15"></div>
                    </a>

                </div>
            </div>

            <div class="row y-gap-30 pt-40 sm:pt-20">

                <div data-anim-child="slide-up delay-3" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="hotelsCard -type-1 ">
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

                <div data-anim-child="slide-up delay-4" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="hotelsCard -type-1 ">
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

                <div data-anim-child="slide-up delay-5" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="hotelsCard -type-1 ">
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

                <div data-anim-child="slide-up delay-6" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="hotelsCard -type-1 ">
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

    <section class="layout-pt-md layout-pb-md">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row y-gap-20 justify-between items-end">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Most Popular Tours</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">Interdum et malesuada fames ac ante ipsum</p>
                    </div>
                </div>

                <div class="col-auto">

                    <a href="#" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                        More <div class="icon-arrow-top-right ml-15"></div>
                    </a>

                </div>
            </div>

            <div class="row y-gap-30 pt-40 sm:pt-20">

                <div data-anim-child="slide-up delay-1" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="tourCard -type-1 rounded-4 ">
                        <div class="tourCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/tours/1.png"
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
                                        LIKELY TO SELL OUT*
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="tourCard__content mt-10">
                            <div class="d-flex items-center lh-14 mb-5">
                                <div class="text-14 text-light-1">16+ hours</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">Full-day Tours</div>
                            </div>

                            <h4 class="tourCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>Stonehenge, Windsor Castle and Bath with Pub Lunch in Lacock</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5">Westminster Borough, London</p>

                            <div class="row justify-between items-center pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="d-flex items-center x-gap-5">

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                        </div>

                                        <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="text-14 text-light-1">
                                        From
                                        <span class="text-16 fw-500 text-dark-1">US$72</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-2" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="tourCard -type-1 rounded-4 ">
                        <div class="tourCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">


                                    <div class="cardImage-slider rounded-4 overflow-hidden js-cardImage-slider">
                                        <div class="swiper-wrapper">

                                            <div class="swiper-slide">
                                                <img class="col-12" src="{{ asset('assets/front') }}/img/tours/2.png"
                                                    alt="image">
                                            </div>

                                            <div class="swiper-slide">
                                                <img class="col-12" src="{{ asset('assets/front') }}/img/tours/1.png"
                                                    alt="image">
                                            </div>

                                            <div class="swiper-slide">
                                                <img class="col-12" src="{{ asset('assets/front') }}/img/tours/3.png"
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

                        <div class="tourCard__content mt-10">
                            <div class="d-flex items-center lh-14 mb-5">
                                <div class="text-14 text-light-1">9+ hours</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">Attractions &amp; Museums</div>
                            </div>

                            <h4 class="tourCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>Westminster Walking Tour & Westminster Abbey Entry</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5">Ciutat Vella, Barcelona</p>

                            <div class="row justify-between items-center pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="d-flex items-center x-gap-5">

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                        </div>

                                        <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="text-14 text-light-1">
                                        From
                                        <span class="text-16 fw-500 text-dark-1">US$72</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-3" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="tourCard -type-1 rounded-4 ">
                        <div class="tourCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/tours/3.png"
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

                        <div class="tourCard__content mt-10">
                            <div class="d-flex items-center lh-14 mb-5">
                                <div class="text-14 text-light-1">40–55 minutes</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">Private and Luxury</div>
                            </div>

                            <h4 class="tourCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>High-Speed Thames River RIB Cruise in London</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5">Manhattan, New York</p>

                            <div class="row justify-between items-center pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="d-flex items-center x-gap-5">

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                        </div>

                                        <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="text-14 text-light-1">
                                        From
                                        <span class="text-16 fw-500 text-dark-1">US$72</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-4" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="tourCard -type-1 rounded-4 ">
                        <div class="tourCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/tours/4.png"
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

                        <div class="tourCard__content mt-10">
                            <div class="d-flex items-center lh-14 mb-5">
                                <div class="text-14 text-light-1">94+ days</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">Bus Tours</div>
                            </div>

                            <h4 class="tourCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>Edinburgh Darkside Walking Tour: Mysteries, Murder and Legends</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5">Vaticano Prati, Rome</p>

                            <div class="row justify-between items-center pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="d-flex items-center x-gap-5">

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                            <div class="icon-star text-yellow-1 text-10"></div>

                                        </div>

                                        <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="text-14 text-light-1">
                                        From
                                        <span class="text-16 fw-500 text-dark-1">US$72</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-md">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row y-gap-20 justify-between items-end">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Trending Activity</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">Interdum et malesuada fames ac ante ipsum</p>
                    </div>
                </div>

                <div class="col-auto">

                    <a href="#" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                        More <div class="icon-arrow-top-right ml-15"></div>
                    </a>

                </div>
            </div>

            <div class="row y-gap-30 pt-40 sm:pt-20">

                <div data-anim-child="slide-up delay-1" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="activityCard -type-1 rounded-4 ">
                        <div class="activityCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12"
                                        src="{{ asset('assets/front') }}/img/activities/1.png" alt="image">


                                </div>

                                <div class="cardImage__wishlist">
                                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>


                                <div class="cardImage__leftBadge">
                                    <div
                                        class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-dark-1 text-white">
                                        LIKELY TO SELL OUT*
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="activityCard__content mt-10">
                            <div class="text-14 lh-14 text-light-1 mb-5">6+ hours</div>

                            <h4 class="activityCard__title lh-16 fw-500 text-dark-1 text-18">
                                <span>Golden Circle, Kerid Volcanic Crater, and Blue Lagoon Day Trip</span>
                            </h4>

                            <p class="text-light-1 text-14 lh-14 mt-5">Westminster Borough, London</p>

                            <div class="row justify-between items-center pt-10">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="icon-star text-yellow-1 text-10 mr-5"></div>

                                        <div class="text-14 text-light-1">
                                            <span class="text-15 text-dark-1 fw-500">4.82</span>
                                            94 reviews
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="text-14 text-light-1">
                                        From <span class="text-16 fw-500 text-dark-1">US$72</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-2" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="activityCard -type-1 rounded-4 ">
                        <div class="activityCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">


                                    <div class="cardImage-slider rounded-4 overflow-hidden js-cardImage-slider">
                                        <div class="swiper-wrapper">

                                            <div class="swiper-slide">
                                                <img class="col-12"
                                                    src="{{ asset('assets/front') }}/img/activities/2.png"
                                                    alt="image">
                                            </div>

                                            <div class="swiper-slide">
                                                <img class="col-12"
                                                    src="{{ asset('assets/front') }}/img/activities/3.png"
                                                    alt="image">
                                            </div>

                                            <div class="swiper-slide">
                                                <img class="col-12"
                                                    src="{{ asset('assets/front') }}/img/activities/4.png"
                                                    alt="image">
                                            </div>

                                            <div class="swiper-slide">
                                                <img class="col-12"
                                                    src="{{ asset('assets/front') }}/img/activities/1.png"
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

                        <div class="activityCard__content mt-10">
                            <div class="text-14 lh-14 text-light-1 mb-5">6+ hours</div>

                            <h4 class="activityCard__title lh-16 fw-500 text-dark-1 text-18">
                                <span>Edinburgh Sky to Sea Bike Tour by Manual or E-Bike</span>
                            </h4>

                            <p class="text-light-1 text-14 lh-14 mt-5">Ciutat Vella, Barcelona</p>

                            <div class="row justify-between items-center pt-10">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="icon-star text-yellow-1 text-10 mr-5"></div>

                                        <div class="text-14 text-light-1">
                                            <span class="text-15 text-dark-1 fw-500">4.82</span>
                                            94 reviews
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="text-14 text-light-1">
                                        From <span class="text-16 fw-500 text-dark-1">US$72</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-3" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="activityCard -type-1 rounded-4 ">
                        <div class="activityCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12"
                                        src="{{ asset('assets/front') }}/img/activities/3.png" alt="image">


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

                        <div class="activityCard__content mt-10">
                            <div class="text-14 lh-14 text-light-1 mb-5">6+ hours</div>

                            <h4 class="activityCard__title lh-16 fw-500 text-dark-1 text-18">
                                <span>Natural Crystal Blue Ice Cave Tour of Vatnajökull Glacier</span>
                            </h4>

                            <p class="text-light-1 text-14 lh-14 mt-5">Manhattan, New York</p>

                            <div class="row justify-between items-center pt-10">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="icon-star text-yellow-1 text-10 mr-5"></div>

                                        <div class="text-14 text-light-1">
                                            <span class="text-15 text-dark-1 fw-500">4.82</span>
                                            94 reviews
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="text-14 text-light-1">
                                        From <span class="text-16 fw-500 text-dark-1">US$72</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-4" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="activityCard -type-1 rounded-4 ">
                        <div class="activityCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12"
                                        src="{{ asset('assets/front') }}/img/activities/4.png" alt="image">


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

                        <div class="activityCard__content mt-10">
                            <div class="text-14 lh-14 text-light-1 mb-5">6+ hours</div>

                            <h4 class="activityCard__title lh-16 fw-500 text-dark-1 text-18">
                                <span>South Coast Full Day Tour by Minibus from Reykjavik</span>
                            </h4>

                            <p class="text-light-1 text-14 lh-14 mt-5">Vaticano Prati, Rome</p>

                            <div class="row justify-between items-center pt-10">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="icon-star text-yellow-1 text-10 mr-5"></div>

                                        <div class="text-14 text-light-1">
                                            <span class="text-15 text-dark-1 fw-500">4.82</span>
                                            94 reviews
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="text-14 text-light-1">
                                        From <span class="text-16 fw-500 text-dark-1">US$72</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-md">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row y-gap-20 justify-between items-end">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Featured Holiday Rentals</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">Interdum et malesuada fames ac ante ipsum</p>
                    </div>
                </div>

                <div class="col-auto">

                    <a href="#" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                        More <div class="icon-arrow-top-right ml-15"></div>
                    </a>

                </div>
            </div>

            <div class="row y-gap-30 pt-40 sm:pt-20">

                <div data-anim-child="slide-up delay-1" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="rentalCard -type-1 rounded-4 ">
                        <div class="rentalCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/rentals/1.png"
                                        alt="image">


                                </div>

                                <div class="cardImage__wishlist">
                                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>


                            </div>

                        </div>

                        <div class="rentalCard__content mt-10">
                            <div class="text-14 text-light-1 lh-14 mb-5">Westminster Borough, London</div>

                            <h4 class="rentalCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>Luxury New Apartment With Private Garden</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5"></p>

                            <div class="d-flex items-center mt-5">
                                <div class="text-14 text-light-1">2 guests</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">1 bedroom</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">1 bed</div>
                            </div>

                            <div class="d-flex items-center mt-20">
                                <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">4.8</div>
                                <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                            </div>

                            <div class="mt-5">
                                <div class="text-light-1">
                                    <span class="fw-500 text-dark-1">US$72</span> / per night
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-2" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="rentalCard -type-1 rounded-4 ">
                        <div class="rentalCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">


                                    <div class="cardImage-slider rounded-4 overflow-hidden js-cardImage-slider">
                                        <div class="swiper-wrapper">

                                            <div class="swiper-slide">
                                                <img class="col-12" src="{{ asset('assets/front') }}/img/rentals/2.png"
                                                    alt="image">
                                            </div>

                                            <div class="swiper-slide">
                                                <img class="col-12" src="{{ asset('assets/front') }}/img/rentals/3.png"
                                                    alt="image">
                                            </div>

                                            <div class="swiper-slide">
                                                <img class="col-12" src="{{ asset('assets/front') }}/img/rentals/1.png"
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

                        <div class="rentalCard__content mt-10">
                            <div class="text-14 text-light-1 lh-14 mb-5">Ciutat Vella, Barcelona</div>

                            <h4 class="rentalCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>Premium One Bedroom Luxury Living in the Heart of Mayfair</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5"></p>

                            <div class="d-flex items-center mt-5">
                                <div class="text-14 text-light-1">2 guests</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">1 bedroom</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">1 bed</div>
                            </div>

                            <div class="d-flex items-center mt-20">
                                <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">4.8</div>
                                <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                            </div>

                            <div class="mt-5">
                                <div class="text-light-1">
                                    <span class="fw-500 text-dark-1">US$72</span> / per night
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-3" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="rentalCard -type-1 rounded-4 ">
                        <div class="rentalCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/rentals/3.png"
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

                        <div class="rentalCard__content mt-10">
                            <div class="text-14 text-light-1 lh-14 mb-5">Manhattan, New York</div>

                            <h4 class="rentalCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>Style, Charm & Comfort in Camberwell</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5"></p>

                            <div class="d-flex items-center mt-5">
                                <div class="text-14 text-light-1">2 guests</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">1 bedroom</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">1 bed</div>
                            </div>

                            <div class="d-flex items-center mt-20">
                                <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">4.8</div>
                                <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                            </div>

                            <div class="mt-5">
                                <div class="text-light-1">
                                    <span class="fw-500 text-dark-1">US$72</span> / per night
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div data-anim-child="slide-up delay-4" class="col-xl-3 col-lg-3 col-sm-6">

                    <a href="{{ route('home') }}" class="rentalCard -type-1 rounded-4 ">
                        <div class="rentalCard__image">

                            <div class="cardImage ratio ratio-1:1">
                                <div class="cardImage__content">

                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/rentals/4.png"
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

                        <div class="rentalCard__content mt-10">
                            <div class="text-14 text-light-1 lh-14 mb-5">Vaticano Prati, Rome</div>

                            <h4 class="rentalCard__title text-dark-1 text-18 lh-16 fw-500">
                                <span>Marylebone - Oxford Street 1 bed apt with WiFi</span>
                            </h4>

                            <p class="text-light-1 lh-14 text-14 mt-5"></p>

                            <div class="d-flex items-center mt-5">
                                <div class="text-14 text-light-1">2 guests</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">1 bedroom</div>
                                <div class="size-3 bg-light-1 rounded-full ml-10 mr-10"></div>
                                <div class="text-14 text-light-1">1 bed</div>
                            </div>

                            <div class="d-flex items-center mt-20">
                                <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">4.8</div>
                                <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>
                                <div class="text-14 text-light-1 ml-10">3,014 reviews</div>
                            </div>

                            <div class="mt-5">
                                <div class="text-light-1">
                                    <span class="fw-500 text-dark-1">US$72</span> / per night
                                </div>
                            </div>
                        </div>
                    </a>

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
    <script type="text/javascript">
        var moduleConfig = {
            searchLocationByName: "{!! route('city-hotel-list') !!}",
        };
    </script>
@endsection
