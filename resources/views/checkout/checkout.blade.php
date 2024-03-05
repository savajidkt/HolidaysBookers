@extends('layouts.app')
@section('page_title', 'Checkout')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/js/intlTelInput/css/intlTelInput.css') }}">
    <style>
        .hide {
            display: none;
        }

        .form-control {
            border: 1px solid var(--color-border) !important;
            border-radius: 4px;
        }

        .total-review .review-list li {
            margin-bottom: 13px;
            display: flex;
            justify-content: space-between
        }

        .iti {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .iti--separate-dial-code .iti__selected-flag {
            background-color: transparent !important;
        }

        .iti--allow-dropdown .iti__flag-container:hover .iti__selected-flag:hover {
            background-color: transparent !important;
        }

        .razorpay-payment-button {
            height: 60px !important;
            color: var(--color-white);
            background-color: var(--color-blue-1) !important;
            padding-left: 24px !important;
            padding-right: 24px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
            text-align: center;
            line-height: 1;
            font-weight: 500;
            font-size: 15px;
            line-height: 1.2;
            border-radius: 4px;
            border: 1px solid transparent;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .total-review .review-list li {
            display: block;
        }

        ul.inline-block li {
            display: inline-block;
        }
    </style>
    @php
        $Taxes_and_fees = 0;
        $Taxes_and_fees_amt = 0;
        $serviceSection = '';

        $serviceSectionAMT = 0;
        $serviceSection_footer = '';
    @endphp



    <section class="cart-page-block" style="background-image: url('{{ asset('/assets/img/slider.jpg') }}');">
        <div class="container">
            <div class="cart-banner">
                <div class="cart-banner-bg">
                    <h1>Checkout</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-40 layout-pb-md">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8">

                    @if (isset($user->id))
                        {{-- <h2 class="fw-500 md:mt-24">Let us know who you are</h2> --}}
                        @if (\Session::has('error'))
                            <div class="col-12">
                                <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                    <div class="text-error-2 lh-1 fw-500">{!! \Session::get('error') !!}</div>
                                </div>
                            </div>
                        @endif

                        <form class="needs-validation1" id="CheckoutFrm" method="POST" enctype="multipart/form-data"
                            action="{{ route('checkout.store') }}">
                            @csrf
                            @php
                                $amountFinalSubmit = 0;
                            @endphp
                            @if (is_array($requiredParamArr) && count($requiredParamArr) > 0)
                                @foreach ($requiredParamArr as $bo_key => $bo_value)
                                    @if ($bo_key == 'hotel')
                                        @foreach ($bo_value as $key => $value)
                                            @php
                                                $amountFinalSubmit = $amountFinalSubmit + $value['finalAmount'];
                                            @endphp
                                        @endforeach
                                    @endif
                                @endforeach
                                @php
                                    $Taxes_and_fees_amt = ($amountFinalSubmit * $Taxes_and_fees) / 100;
                                @endphp
                            @endif

                            <input type="hidden" name="Taxes_and_fees" value="{{ $Taxes_and_fees }}">
                            <input type="hidden" name="Taxes_and_fees_amt" value="{{ $Taxes_and_fees_amt }}">
                            <input type="hidden" name="button_name" class="button_name_cls" value="order">

                            <div class="row x-gap-20 y-gap-20 pt-20">
                                <h2 class="fw-500 md:mt-24">Remarks and cancellation costs</h2>
                                <div class="">
                                    @if (count($requiredParamArr) > 0)
                                        @foreach ($requiredParamArr as $bo_key => $bo_value)
                                            @if ($bo_key == 'hotel')
                                                <div
                                                    class="px-30 py-30 sm:px-20 sm:py-20 mb-30 myDelete cart-detales-block">
                                                    @foreach ($bo_value as $key => $value)
                                                        @php
                                                            $offlineRoom = getRoomDetailsByRoomID($value['room_id']);
                                                            $hotelsDetails = $hotelListingRepository->hotelDetailsArr(
                                                                $value['hotel_id'],
                                                            );
                                                        @endphp
                                                        @php
                                                            $age = [];

                                                        @endphp

                                                        @if (isset($value['room_child_age']))
                                                            @foreach ($value['room_child_age'] as $ckey => $child)
                                                                @php
                                                                    $age[] = $child->age;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                        @php
                                                            $room_title_with_child = '';
                                                            $room_adult_with_child = '';
                                                            if ($value['adult']) {
                                                                $room_title_with_child = $value['adult'] . ' adults';
                                                                $room_adult_with_child = $value['adult'] . ' Adults';
                                                            }
                                                            if ($value['child']) {
                                                                $room_title_with_child .=
                                                                    ', ' .
                                                                    $value['child'] .
                                                                    ' children - ' .
                                                                    implode(',', $age) .
                                                                    ' years old';
                                                                $room_adult_with_child .=
                                                                    ', ' .
                                                                    $value['child'] .
                                                                    ' Child - ' .
                                                                    implode(',', $age) .
                                                                    ' years';
                                                            }

                                                        @endphp
                                                        @if (count($hotelsDetails) > 0 && count($hotelsDetails['hotel']) > 0)
                                                            @php
                                                                $hotelsRoomDetails = $hotelsDetails['roomDetails'];
                                                                $hotelsDetails = $hotelsDetails['hotel'];
                                                                $serviceSection .=
                                                                    '<li class="text-14 border-bottom-light mt-5 ">' .
                                                                    $hotelsDetails['hotel_name'] .
                                                                    '<br>' .
                                                                    $offlineRoom->roomtype->room_type .
                                                                    '<span class="pull-right">' .
                                                                    getNumberWithCommaGlobalCurrency(
                                                                        $value['finalAmount'],
                                                                    ) .
                                                                    '</span></li>';
                                                                $serviceSection_footer .=
                                                                    '<li class="text-14 border-bottom-light mt-5 ">' .
                                                                    $hotelsDetails['hotel_name'] .
                                                                    '<span class="pull-right">' .
                                                                    getNumberWithCommaGlobalCurrency(
                                                                        $value['finalAmount'],
                                                                    ) .
                                                                    '</span></li>';
                                                                $serviceSectionAMT =
                                                                    $serviceSectionAMT + $value['finalAmount'];

                                                                $night = dateDiffInDays(
                                                                    str_replace('/', '-', $value['search_from']),
                                                                    str_replace('/', '-', $value['search_to']),
                                                                );
                                                            @endphp
                                                            <div class="row ">
                                                                <div class="">
                                                                    <div class="roomGrid">
                                                                        <div class="">
                                                                            <div class="y-gap-30">
                                                                                <div class="row">
                                                                                    <div class="text-18 fw-500 mb-10">
                                                                                        <i class="fa fa-bed"></i>
                                                                                        {{ $hotelsDetails['hotel_name'] }}

                                                                                    </div>
                                                                                    <div class="y-gap-8">
                                                                                        <div
                                                                                            class="text-15 d-flex items-center">
                                                                                            <div class=" x-gap-5 pb-10">
                                                                                                <i
                                                                                                    class="icon-location-pin text-12 mr-10"></i>
                                                                                                {{ $hotelsDetails['hotel_address'] }}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="text-15 d-flex items-center">
                                                                                            <div class=" x-gap-5 pb-10">

                                                                                                <p
                                                                                                    class="text-14 fw-500 mb-10">
                                                                                                    1 x
                                                                                                    {{ $offlineRoom->roomtype->room_type }}<br>
                                                                                                    From
                                                                                                    {{ dateFormat(str_replace('/', '-', $value['search_from']), 'd M, Y') }}
                                                                                                    To
                                                                                                    {{ dateFormat(str_replace('/', '-', $value['search_to']), 'd M, Y') }}
                                                                                                    {{ $night ? '(' . $night . ' nights) ' : '' }}
                                                                                                    <br>
                                                                                                    {{ $room_title_with_child }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row pt-10">
                                                                                            <div
                                                                                                class="col-6 border-right-px">
                                                                                                <div
                                                                                                    class="text-15 fw-500 mb-10">
                                                                                                    Cancellation fees
                                                                                                </div>
                                                                                                <div class="y-gap-8">
                                                                                                    <?php if($offlineRoom->price[0]->cancelation_policy != "refundeble"){ ?>
                                                                                                    <div
                                                                                                        class="items-center">
                                                                                                        <div
                                                                                                            class="text-13 pull-left">
                                                                                                            Non
                                                                                                            refundable</div>
                                                                                                    </div>
                                                                                                    <?php } else { ?>
                                                                                                    <?php echo CancellationFeesCalculated($offlineRoom->price[0], $value['search_from']); ?>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <div
                                                                                                    class="text-15 fw-500 mb-10">
                                                                                                    Remarks
                                                                                                </div>
                                                                                                <div class="text-12">Car
                                                                                                    park YES (with
                                                                                                    additional debit notes).
                                                                                                    Key Collection 00:00 -
                                                                                                    23:00. Check-in hour
                                                                                                    14:00 - 00:00. DBT-DX:
                                                                                                    Children share the bed
                                                                                                    with parents 1.</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-12">Date and time are
                                                                                    calculated based on local time in the
                                                                                    destination. In case of no-show,
                                                                                    different fees will apply. Please refer
                                                                                    to our T&C.</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="border-top-light mt-30 mb-20"></div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                                <h2 class="fw-500 md:mt-24">Travellers information</h2>
                                <div class="main-checkout-redio-option">
                                    <div class="col-12">
                                        <div class="main-tag-input-data">
                                            <div class="text-info-checkout">Lead traveller contact details </div>
                                            <div class="sub-tag-input-data">
                                                <div class="tag-input-data">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlInput1">
                                                            Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control lead_addvalidation"
                                                            name="lead_name" placeholder="E.g: Maria">
                                                    </div>
                                                </div>
                                                <div class="tag-input-data">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlInput1">
                                                            Surname <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control lead_addvalidation"
                                                            name="lead_surname" placeholder="E.g: López">
                                                    </div>
                                                </div>
                                                <div class="tag-input-data">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlInput1">
                                                            Nationality </label>
                                                        <div class="select js-select js-liveSearch" data-select-value="">
                                                            <input type="hidden" name="lead_nationality_text" class="lead_nationality_text">
                                                            <input type="hidden" name="lead_nationality_id" class="lead_nationality_id">
                                                            <button type="button" class="select__button js-button">
                                                                <span class="js-button-title">Select</span>
                                                                <i class="select__icon" data-feather="chevron-down"></i>
                                                            </button>
                                                            @if ($nationality)
                                                                <div class="select__dropdown js-dropdown">
                                                                    <input type="text" placeholder="Search"
                                                                        class="select__search js-search">
                                                                    <div class="select__options js-options">
                                                                        @foreach ($nationality as $value)
                                                                        <div class="select__options__button"
                                                                        data-value="{{ strtolower($value->nationality) }}" data-id="{{ strtolower($value->id) }}">{{ $value->nationality }}</div>
                                                                        @endforeach                                                                                                                                           
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top-light mt-30 mb-20"></div>
                                        @if (count($requiredParamArr) > 0)
                                            @foreach ($requiredParamArr as $bo_key => $bo_value)
                                                @if ($bo_key == 'hotel')
                                                    @php

                                                        $roomNo = 0;
                                                    @endphp
                                                    @foreach ($bo_value as $key => $value)
                                                        @php

                                                            $offlineRoom = getRoomDetailsByRoomID($value['room_id']);
                                                            $hotelsDetails = $hotelListingRepository->hotelDetailsArr(
                                                                $value['hotel_id'],
                                                            );
                                                        @endphp
                                                        @php
                                                            $age = [];
                                                        @endphp

                                                        @if (isset($value['room_child_age']))
                                                            @foreach ($value['room_child_age'] as $ckey => $child)
                                                                @php
                                                                    $age[] = $child->age;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                        @php
                                                            $totalPassanger = $value['adult'] + $value['child'];
                                                            $room_title_with_child = '';
                                                            $room_adult_with_child = '';
                                                            if ($value['adult']) {
                                                                $room_title_with_child = $value['adult'] . ' adults';
                                                                $room_adult_with_child = $value['adult'] . ' Adults';
                                                            }
                                                            if ($value['child']) {
                                                                $room_title_with_child .=
                                                                    ', ' .
                                                                    $value['child'] .
                                                                    ' children - ' .
                                                                    implode(',', $age) .
                                                                    ' years old';
                                                                $room_adult_with_child .=
                                                                    ', ' .
                                                                    $value['child'] .
                                                                    ' Child - ' .
                                                                    implode(',', $age) .
                                                                    ' years';
                                                            }

                                                        @endphp

                                                        @if (count($hotelsDetails) > 0 && count($hotelsDetails['hotel']) > 0)
                                                            @php
                                                                $roomNo++;
                                                                $hotelsDetails = $hotelsDetails['hotel'];
                                                                $night = dateDiffInDays(
                                                                    str_replace('/', '-', $value['search_from']),
                                                                    str_replace('/', '-', $value['search_to']),
                                                                );
                                                            @endphp

                                                            <input type="hidden" class="form-control"
                                                                name="hotel[{{ $key }}][room_no_{{ $roomNo }}][hotel_id]"
                                                                value="{{ $value['hotel_id'] }}">
                                                            <input type="hidden" class="form-control"
                                                                name="hotel[{{ $key }}][room_no_{{ $roomNo }}][room_id]"
                                                                value="{{ $value['room_id'] }}">

                                                            <input type="hidden" class="form-control"
                                                                name="hotel[{{ $key }}][room_no_{{ $roomNo }}][adults]"
                                                                value="{{ $value['adult'] }}">
                                                            <input type="hidden" class="form-control"
                                                                name="hotel[{{ $key }}][room_no_{{ $roomNo }}][childs]"
                                                                value="{{ $value['child'] }}">

                                                            @if (isset($value['room_child_age']))
                                                                @foreach ($value['room_child_age'] as $ckey => $child)
                                                                    @php
                                                                        $age[] = $child->age;
                                                                    @endphp
                                                                    <input type="hidden" class="form-control"
                                                                        name="hotel[{{ $key }}][room_no_{{ $roomNo }}][room_child_age][age][]"
                                                                        value="{{ $child->age }}">
                                                                    <input type="hidden" class="form-control"
                                                                        name="hotel[{{ $key }}][room_no_{{ $roomNo }}][room_child_age][cwd][]"
                                                                        value="{{ $child->cwb }}">
                                                                @endforeach
                                                            @endif

                                                            <div class="row ">
                                                                <div class="">
                                                                    <div class="roomGrid">
                                                                        <div class="">
                                                                            <div class="y-gap-30">
                                                                                <div class="row">
                                                                                    <div class="text-18 fw-500 mb-10">
                                                                                        <i class="fa fa-bed"></i>
                                                                                        {{ $hotelsDetails['hotel_name'] }}

                                                                                    </div>
                                                                                    <div class="y-gap-8">
                                                                                        <div
                                                                                            class="text-15 d-flex items-center">
                                                                                            <div class=" x-gap-5 pb-10">
                                                                                                <i
                                                                                                    class="icon-location-pin text-12 mr-10"></i>
                                                                                                {{ $hotelsDetails['hotel_address'] }}
                                                                                                <p>
                                                                                                    From
                                                                                                    {{ dateFormat(str_replace('/', '-', $value['search_from']), 'd M, Y') }}
                                                                                                    To
                                                                                                    {{ dateFormat(str_replace('/', '-', $value['search_to']), 'd M, Y') }}
                                                                                                    {{ $night ? '(' . $night . ' nights) ' : '' }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row pt-10">
                                                                                            <div
                                                                                                class="col-12 border-right-px">
                                                                                                <div
                                                                                                    class="text-15 fw-500 mb-10">
                                                                                                    {{ strtoupper($offlineRoom->roomtype->room_type) }}
                                                                                                    {{ $room_title_with_child }}
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <div
                                                                                                        class="form-switch d-flex items-center">
                                                                                                        <div
                                                                                                            class="switch">
                                                                                                            <input
                                                                                                                type="checkbox"
                                                                                                                value="{{ $roomNo }}"
                                                                                                                name="hotel[{{ $key }}][room_no_{{ $roomNo }}][all_travellers][]"
                                                                                                                class="all_travellers">
                                                                                                            <span
                                                                                                                class="switch__slider"></span>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="text-13 lh-1 text-dark-1 ml-10">
                                                                                                            Include all
                                                                                                            travellers name
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-md-12 main-tag-input-data hide current_room_{{ $roomNo }}">
                                                                                                    @if ($totalPassanger > 0)
                                                                                                        @for ($i = 1; $i <= $totalPassanger; $i++)
                                                                                                            <div
                                                                                                                class="sub-tag-input-data">
                                                                                                                <div
                                                                                                                    class="tag-input-data">
                                                                                                                    <div
                                                                                                                        class="form-group">
                                                                                                                        <label
                                                                                                                            for="exampleFormControlInput1">
                                                                                                                            Name
                                                                                                                            (Optional)
                                                                                                                        </label>
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            class="form-control"
                                                                                                                            name="hotel[{{ $key }}][room_no_{{ $roomNo }}][name][]"
                                                                                                                            placeholder="E.g: Maria">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="tag-input-data">
                                                                                                                    <div
                                                                                                                        class="form-group">
                                                                                                                        <label
                                                                                                                            for="exampleFormControlInput1">
                                                                                                                            Surname
                                                                                                                            (Optional)</label>
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            class="form-control "
                                                                                                                            name="hotel[{{ $key }}][room_no_{{ $roomNo }}][surname][]"
                                                                                                                            placeholder="E.g: López">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="tag-input-data">
                                                                                                                    <div class="form-group">
                                                                                                                        <label for="exampleFormControlInput1">
                                                                                                                            Nationality </label>
                                                                                                                        <div class="select js-select js-liveSearch" data-select-value="">                                                                                                                            
                                                                                                                            <input type="hidden" name="hotel[{{ $key }}][room_no_{{ $roomNo }}][nationality_text][]" class="nationality_text_{{ $key.'_'.$roomNo.'_'.$i }}" value="">
                                                                                                                            <input type="hidden" name="hotel[{{ $key }}][room_no_{{ $roomNo }}][nationality_id][]" class="nationality_id_{{ $key.'_'.$roomNo.'_'.$i }}" value="">
                                                                                                                            <button type="button" class="select__button js-button">
                                                                                                                                <span class="js-button-title">Select</span>
                                                                                                                                <i class="select__icon" data-feather="chevron-down"></i>
                                                                                                                            </button>
                                                                                                                            @if ($nationality)
                                                                                                                                <div class="select__dropdown js-dropdown">
                                                                                                                                    <input type="text" name="lead_nationality" placeholder="Search"
                                                                                                                                        class="select__search js-search">
                                                                                                                                    <div class="select__options js-options">
                                                                                                                                        @foreach ($nationality as $value)
                                                                                                                                        <div class="select__options__button"
                                                                                                                                        data-na-hotel={{ $key }} data-na-room={{ $roomNo }} data-na-i={{ $i }} data-value="{{ strtolower($value->nationality) }}" data-id="{{ strtolower($value->id) }}">{{ $value->nationality }}</div>
                                                                                                                                        @endforeach                                                                                                                                           
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            @endif
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        @endfor
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-12">
                                                                                    <div class="fw-500 mb-10">Request for
                                                                                        the stay(Optional)</div>
                                                                                    <div class="fw-500 mb-10">For reference
                                                                                        only, Holidays Bookers can not
                                                                                        guarantee them</div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="col-md-4">
                                                                                            <div
                                                                                                class="d-flex items-center">
                                                                                                <div
                                                                                                    class="form-checkbox ">
                                                                                                    <input type="checkbox"
                                                                                                        name="hotel[{{ $key }}][room_no_{{ $roomNo }}][request_stay][]"
                                                                                                        value="1">
                                                                                                    <div
                                                                                                        class="form-checkbox__mark">
                                                                                                        <div
                                                                                                            class="form-checkbox__icon icon-check">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="text-14 lh-12 ml-10">
                                                                                                    static</div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div
                                                                                                class="d-flex items-center">
                                                                                                <div
                                                                                                    class="form-checkbox ">
                                                                                                    <input type="checkbox"
                                                                                                        name="hotel[{{ $key }}][room_no_{{ $roomNo }}][request_stay][]"
                                                                                                        value="2">
                                                                                                    <div
                                                                                                        class="form-checkbox__mark">
                                                                                                        <div
                                                                                                            class="form-checkbox__icon icon-check">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="text-14 lh-12 ml-10">
                                                                                                    static</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-lg-12 mt-15">
                                                                                        <div class="fw-500 mb-10">Comments
                                                                                            ( Optional )
                                                                                        </div>
                                                                                        <div class="form-input ">
                                                                                            <textarea rows="4" name="hotel[{{ $key }}][room_no_{{ $roomNo }}][request_comment][]"></textarea>
                                                                                            <label
                                                                                                class="lh-1 text-16 text-light-1">Write
                                                                                                your comments here</label>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="border-top-light mt-30 mb-20"></div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <h2 class="fw-500 md:mt-24">Agency references</h2>
                                <div class="main-checkout-redio-option">
                                    <div class="sub-tag-input-data">
                                        <div class="tag-input-data">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">
                                                    Agency Reference <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="agency_reference"
                                                    placeholder="Write here">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="fw-500 md:mt-24">Confirmation</h2>
                                <div class="main-checkout-redio-option">
                                    <div class="rounded-4 px-30 py-30 sm:px-20 sm:py-20 mb-30">
                                        <div class="row y-gap-20">
                                            <div class="col-12">
                                                <div class="">
                                                    <ul class=" y-gap-4 pt-5">
                                                        <li class="text-14 border-bottom-light mt-5 mb-5 fw-500">Services
                                                            <span class="pull-right fw-500">
                                                                Total net price
                                                            </span>
                                                        </li>
                                                        @php
                                                            echo $serviceSection_footer;
                                                        @endphp
                                                        <li class="text-14 border-bottom-light mt-5 mb-5 fw-500">Total<span
                                                                class="pull-right fw-500">{{ getNumberWithCommaGlobalCurrency($serviceSectionAMT) }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row y-gap-20">
                                            <div class="col-12">
                                                <div class="d-flex pull-right">
                                                    <div class="text-15 lh-15 text-light-1 fw-500 ml-10"> Total net price
                                                        to pay to Holidays
                                                        Bookers: <span
                                                            class="text-20">{{ getNumberWithCommaGlobalCurrency($serviceSectionAMT) }}<span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 pt-20">
                                    <div class="row y-gap-20 items-center justify-between">
                                        <div class="col-auto">
                                            <div class="text-14 text-light-1">
                                                <div class="d-flex items-center agree">
                                                    <div class="form-checkbox ">
                                                        <input type="checkbox" id="cbx" name="agree">
                                                        <div class="form-checkbox__mark cbx">
                                                            <div class="form-checkbox__icon icon-check"></div>
                                                        </div>
                                                        <div class="class="lh-12" style="color: #333;  font-size: 17px;">
                                                            By proceeding with this booking, I
                                                            agree to
                                                            GoTrip Terms of Use and Privacy Policy. <span
                                                                class="text-danger">*</span></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto ">

                                            @if (availableBalance($user->agents->id) > getFinalAmountChackOut())
                                                <div class="col-12 mb-2 text-14 text-light-1">
                                                    <div class="form-radio d-flex items-center ">
                                                        <div class="radio">
                                                            <input type="radio" name="payment_method" value="2">
                                                            <div class="radio__mark">
                                                                <div class="radio__icon"></div>
                                                            </div>
                                                        </div>
                                                        <div class="text-14 lh-1 ml-10">Pay using wallet (Balance :
                                                            {{ getNumberWithCommaGlobalCurrency(availableBalance($user->agents->id)) }})
                                                            <span class="text-danger">*</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-12 mb-2 text-14 text-light-1 payment_methodcls">
                                                <div class="form-radio d-flex items-center ">
                                                    <div class="radio">
                                                        <input type="radio" name="payment_method" value="3">
                                                        <div class="radio__mark">
                                                            <div class="radio__icon"></div>
                                                        </div>
                                                    </div>
                                                    <div class="text-14 lh-1 ml-10">Pay On Online payment <span
                                                            class="text-danger">*</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="y-gap-4 pt-5 text-right inline-block">
                                                {{-- <li class="text-14">
                                                    <button type="button" class="button header-login-btn saveDraft"
                                                        name="Draft">
                                                        Save as Draft <i
                                                            class="fa fa-floppy-o fa-2x text-blue-1 px-10"></i>
                                                    </button>
                                                </li> --}}
                                                <li class="text-14">
                                                    <button type="button" class="button header-login-btn saveQuote"
                                                        name="Quote">
                                                        Save as Quote <i
                                                            class="fa fa-bookmark-o fa-2x text-blue-1 px-10 text-white"></i>
                                                    </button>
                                                </li>
                                                <li class="text-14">
                                                    <button type="button" class="button header-login-btn saveOrder"
                                                        name="Order">
                                                        Pay Now <div class="icon-arrow-top-right ml-15"></div>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                    <div class="w-full h-1 bg-border mt-40 mb-40"></div>
                </div>

                <div class="col-xl-5 col-lg-4">
                    <div class="ml-80 lg:ml-40 md:ml-0">
                        @php
                            $amountFinal = 0;
                        @endphp
                        <div class="px-30 py-30 border-light rounded-4 mt-30">
                            <div class="text-20 fw-500 mb-20">Cart</div>
                            <div class="review-section total-review">
                                <ul class="y-gap-4 pt-5">
                                    @if (is_array($requiredParamArr) && count($requiredParamArr) > 0)
                                        @foreach ($requiredParamArr as $bo_key => $bo_value)
                                            @if ($bo_key == 'hotel')
                                                @foreach ($bo_value as $key => $value)
                                                    @php
                                                        $age = [];
                                                        $hotelsDetails = $hotelListingRepository->hotelDetailsArr(
                                                            $value['hotel_id'],
                                                        );
                                                        $offlineRoom = getRoomDetailsByRoomID($value['room_id']);
                                                    @endphp
                                                    @if (isset($value['room_child_age']))
                                                        @foreach ($value['room_child_age'] as $ckey => $child)
                                                            @php
                                                                $age[] = $child->age;
                                                            @endphp
                                                        @endforeach
                                                    @endif
                                                    @php
                                                        $room_title_with_child = '';
                                                        $room_adult_with_child = '';
                                                        if ($value['adult']) {
                                                            $room_title_with_child =
                                                                'for ' . $value['adult'] . ' adults';
                                                            $room_adult_with_child = $value['adult'] . ' Adults';
                                                        }
                                                        if ($value['child']) {
                                                            $room_title_with_child .=
                                                                ', ' .
                                                                $value['child'] .
                                                                ' children - ' .
                                                                implode(',', $age) .
                                                                ' years old';
                                                            $room_adult_with_child .=
                                                                ', ' .
                                                                $value['child'] .
                                                                ' Child - ' .
                                                                implode(',', $age) .
                                                                ' years';
                                                        }

                                                    @endphp

                                                    <li class="text-14">
                                                        <i class="fa fa-bed"></i>
                                                        {{ $hotelsDetails['hotel']['hotel_name'] }} <br>
                                                        {{ $offlineRoom->roomtype->room_type }}
                                                        <span class="pull-right">
                                                            {{ getNumberWithCommaGlobalCurrency($value['finalAmount']) }}
                                                            <a href="javascript:void(0);"
                                                                data-hotel-id="{{ $value['hotel_id'] }}"
                                                                data-hotel-room-id="{{ $value['room_id'] }}"
                                                                data-cart-key="{{ $value['unique_id'] }}"
                                                                class="removeHotel"><i
                                                                    class="fa fa-times text-danger"></i></a>
                                                        </span>
                                                    </li>
                                                    <li class="text-14">
                                                        <i class="fa fa-user"></i> {{ $room_adult_with_child }}
                                                    </li>
                                                    <li class="text-14">
                                                        <div class="border-top-light mt-30 mb-20"></div>
                                                    </li>

                                                    @php
                                                        $amountFinal = $amountFinal + $value['finalAmount'];
                                                    @endphp
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="border-top-light mt-30 mb-20"></div>

                            <div class="row y-gap-5 justify-between pt-5">
                                <div class="col-auto">
                                    <div class="text-15"></div>
                                </div>
                                <div class="col-auto">
                                    <div class="text-15">
                                        <a href="javascript:void(0);" class="removeCart"> <i
                                                class="fa fa-times fa-2x text-danger"></i> Empty cart</a>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row y-gap-5 justify-between pt-5">
                                <div class="col-auto">
                                    <div class="text-15">Taxes and fees ({{ $Taxes_and_fees }}%)</div>
                                </div>
                                <div class="col-auto">

                                    <div class="text-15">{{ getNumberWithCommaGlobalCurrency($Taxes_and_fees_amt) }}
                                    </div>
                                </div>
                            </div> --}}
                            <div class="px-20 py-20 bg-blue-2 rounded-4 mt-20">
                                <div class="row y-gap-5 justify-between">
                                    <div class="col-auto">
                                        <div class="text-18 lh-13 fw-500">Total</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-18 lh-13 fw-500">
                                            {{ getNumberWithCommaGlobalCurrency($amountFinal + $Taxes_and_fees_amt) }}
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

    <div class="modal fade saveQuotePopup gotrip-saveQuotePopup-modal" id="saveQuotePopup" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content relative">
                <div class="modal-header border-dashed">
                    <h4 class="modal-title">Save as Quote</h4>
                    <span class="c-pointer close" aria-label="Close" data-dismiss="modal">
                        <i class="icon-close">
                            {{-- <img src="{{ asset('assets/front') }}/ico_close.svg" alt="close"> --}}
                        </i>
                    </span>
                </div>
                <div class="modal-body relative">
                    <div class="bravo-theme-gotrip-login-form y-gap-20">
                        <div class="col-auto ">
                            <div class="col-12">
                                <div class="form-input">
                                    <input type="text" name="quote_name" autocomplete="off"
                                        class="has-value quote_name">
                                    <label class="lh-1 text-14 text-light-1">Quote Name</label>
                                </div>
                                <span id="quote_name-error" class="help-block help-block-error hide">This field is
                                    required.</span>
                            </div>
                            <div class="col-12 ">
                                <button type="button"
                                    class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5 quoteBtnClick"
                                    style="width:100%;">
                                    <span class="icons">Submit</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('page-script')

        <script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/front/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('assets/front/js/Check-out.js') }}"></script>
        <script src="{{ asset('assets/front/js/search-form/Currencies.js') }}"></script>
        <script src="{{ asset('assets/front/js/intlTelInput/js/intlTelInput-jquery.min.js') }}"></script>
        <script type="text/javascript">
            $(function() {
                $('.all_travellers').change(function() {
                    console.log($(this).val());
                    if ($(this).is(':checked')) {

                        $('.current_room_' + $(this).val()).removeClass('hide');
                    } else {
                        $('.current_room_' + $(this).val()).addClass('hide');
                    }
                })
            })

            var moduleConfig = {
                checkoutLogin: "{!! route('post-login') !!}",
                removeHotel: "{!! route('remove-cart-hotel') !!}",
                removeCart: "{!! route('remove-cart') !!}",
            };
        </script>
        <script>
            $(document).ready(function() {
                $('.checkout-redio-option').on('click', function() {
                    const activeDiv = $(this).find('.active-redio-details');
                    const nextDiv = activeDiv.next().length ? activeDiv.next() : $(this).children().first();

                    activeDiv.removeClass('active-redio-details');
                    nextDiv.addClass('active-redio-details');
                });
            });
        </script>
    @endsection
