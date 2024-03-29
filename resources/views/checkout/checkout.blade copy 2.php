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
    @endphp
    
    
    <section class="cart-page-block"  style="background-image: url('{{ asset('/assets/img/slider.jpg') }}');">
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

                                <input type="hidden" name="popup_margin_type" class="popup_margin_type_cls" value="">
                                <input type="hidden" name="margin_amt" class="margin_amt_cls" value="">
                                <input type="hidden" name="quote_email" class="quote_email_cls" value="">
                                <input type="hidden" name="quote_name" class="quote_name_cls" value="">
                                {{-- <div class="checkout-detales-block">
                                <div class="col-md-12">
                                    <div class="form-input firstname">
                                        <input type="hidden" name="bookingKey" value="{{ $bookingKey }}">
                                        <span class="fa fa-user"></span>
                                        <input type="text" name="firstname" required onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                            value="{{ $user->first_name ? $user->first_name : '' }}" placeholder="First Name*" style="font-family: 'FontAwesome', Arial;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-input lastname">
                                        <span class="fa fa-user"></span>
                                        <input type="text" name="lastname" required onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                            value="{{ $user->last_name ? $user->last_name : '' }}" placeholder="Last Name*" style="font-family: 'FontAwesome', Arial;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-input email">
                                        <span class="fa fa-envelope"></span>
                                        <input type="text" name="email" required
                                            value="{{ $user->email ? $user->email : '' }}" placeholder="Email*" style="font-family: 'FontAwesome', Arial;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-input phone">
                                        <span class="fa fa-phone"></span>
                                        <input type="text" name="phone" required oninput="this.value = this.value.replace(/[^0-9]+/g, '').replace(/(\..*)\./g, '$1');"
                                            value="{{ isset($user->usermeta->phone_number) ? $user->usermeta->phone_number : '' }}" placeholder="Phone Number*" style="font-family: 'FontAwesome', Arial;">
                                    </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-12">
                                        <div class="d-flex items-center checkbox-check">
                                        <div class="form-checkbox ">
                                                <input type="checkbox" id="cbx" name="gst_enable">
                                                <div class="form-checkbox__mark cbx">
                                                <div class="form-checkbox__icon icon-check"></div>
                                            </div>
                                                <div for="cbx">Enter GST Details</div>
                                        </div>
                                          
                                    </div>
                                </div> --}}
                                {{-- <div class="enablegst hide">
                                   <div class="row input-tag-enablegst-block">
                                            <div class="input-tag-enablegst">
                                            <div class="form-input registration_number">
                                                    <span class="fa fa-id-card"></span>
                                                    <input type="text" name="registration_number" required value="" oninput="this.value = this.value.replace(/[^0-9a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');" placeholder="Registration Number*">
                                            </div>
                                        </div>
                                            <div class="input-tag-enablegst">
                                            <div class="form-input registered_company_name">
                                                    <span class="fa fa-building"></span>
                                                    <input type="text" name="registered_company_name" required value="" oninput="this.value = this.value.replace(/[^0-9a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');" placeholder="Registered Company name*">
                                            </div>
                                        </div>
                                            <div class="input-tag-enablegst">
                                            <div class="form-input registered_company_address">
                                                    <span class="fa fa-map-marker"></span>
                                                    <input type="text" name="registered_company_address" required value="" oninput="this.value = this.value.replace(/[^0-9a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');" placeholder="Registered Company address*">
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <h2 class="fw-500 md:mt-24">Passenger Details</h2>
                                @if (is_array($requiredParamArr) && $requiredParamArr > 0)
                                    @php
                                        $roomNo = 0;
                                    @endphp
                                    <div class="main-checkout-redio-option">
                                        <div class="checkout-redio-option">
                                              <div class="active-redio-details">
                                                <div class="">
                                                  <div class="form-checkbox">
                                                    <input class="form-check-input passengersEvent" type="radio" name="passengers" value="lead" checked>
                                                        <div class="form-checkbox__mark">
                                                            <div class="form-checkbox__icon icon-check"></div>
                                                        </div>
                                                    <div class="passengers">Enter the lead passenger data only</div>
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                              <div class="">
                                                <div class="">
                                                  <div class="form-checkbox">
                                                    <input class="form-check-input passengersEvent" type="radio" name="passengers" value="all">
                                                        <div class="form-checkbox__mark">
                                                            <div class="form-checkbox__icon icon-check"></div>
                                                        </div>
                                                    <div class="passengers">Enter the data for all passengers</div>
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row all_passengers hide">
                                            <div class="col-12">

                                                @foreach ($requiredParamArr as $bo_key => $bo_value)
                                                
                                                    @if ($bo_key == 'hotel')
                                                        @foreach ($bo_value as $key => $value)
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
                                                            $room_title_with_child='';
                                                            $room_adult_with_child='';
                                                             if($value['adult']){
                                                                 $room_title_with_child ='for '.$value['adult'].' adults';
                                                                 $room_adult_with_child = $value['adult'].' Adults';
                                                             }
                                                             if($value['child']){
                                                                 $room_title_with_child .=', '.$value['child'].' children - '.implode(',',$age).' years old';
                                                                 $room_adult_with_child .=', '.$value['child'].' Child - '.implode(',',$age).' years';
                                                             }
                         
                                                        @endphp

                                                        
                                                            @php

                                                                $roomNo++;
                                                                $hotelsDetails = $hotelListingRepository->hotelDetailsArr($value['hotel_id']);
                                                                $offlineRoom = getRoomDetailsByRoomID($value['room_id']);
                                                                $hotelNameStr = $hotelsDetails['hotel']['hotel_name'] ? $hotelsDetails['hotel']['hotel_name'] : '';
                                                                $hotelRoomTypeStr = $offlineRoom->roomtype->room_type ? ', ' . $offlineRoom->roomtype->room_type : '';
                                                                $hotelAdultTypeStr = $value['adult'] > 0 ? ', ' . $value['adult'] . ' Adults' : '';
                                                                $hotelChildTypeStr = $value['child'] > 0 ? ', ' . $value['child'] . ' Children' : '';
                                                                $hotelTitleName = $hotelNameStr . '<span class="text-15 fw-300">' . $hotelRoomTypeStr . '' . $room_adult_with_child .'</span>';

                                                            @endphp

                                                            

                                                            <div class="text-20 fw-500 mb-20 mt-10">@php
                                                                echo $hotelTitleName;
                                                            @endphp
                                                            </div>

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


                                                            



                                                            @if ($value['adult'] > 0)
                                                                @for ($i = 1; $i <= $value['adult']; $i++)
                                                                    <div class="row x-gap-20 y-gap-20 pt-5">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="exampleFormControlSelect1">Title-
                                                                                    Adult</label>
                                                                                <select class="form-control addvalidation"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][adult][title][]">
                                                                                    <option value="Mr">Mr.</option>
                                                                                    <option value="Ms">Ms.</option>
                                                                                    <option value="Mrs">Mrs.</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">First
                                                                                    Name- Adult <span class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    class="form-control addvalidation" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][adult][firstname][]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">Last
                                                                                    Name- Adult <span class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    class="form-control addvalidation" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][adult][lastname][]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">ID
                                                                                    Proof
                                                                                    Type- Adult</label>
                                                                                <select class="form-control addvalidation"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][adult][id_proof][]">
                                                                                    <option value="Aadhaar">Aadhaar
                                                                                    </option>
                                                                                    <option value="Passport">Passport
                                                                                    </option>
                                                                                    <option value="Driving Licence">Driving
                                                                                        Licence
                                                                                    </option>
                                                                                    <option value="Voters ID Card">Voters
                                                                                        ID
                                                                                        Card
                                                                                    </option>
                                                                                    <option value="PAN card">PAN card
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">ID
                                                                                    Proof
                                                                                    No- Adult <span class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    class="form-control addvalidation" oninput="this.value = this.value.replace(/[^0-9a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][adult][id_proof_no][]">
                                                                            </div>
                                                                        </div>
                                                                        @if ($i == 1)
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="exampleFormControlInput1">Phone
                                                                                        Number- Adult</label>


                                                                                    <input type="text"
                                                                                        class="form-control phonenumber"
                                                                                        placeholder="Phone Number" oninput="this.value = this.value.replace(/[^0-9]+/g, '').replace(/(\..*)\./g, '$1');"
                                                                                        name="hotel[{{ $key }}][room_no_{{ $roomNo }}][adult][phonenumber][]">

                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="mt-10 border-top-light"></div>
                                                                @endfor
                                                            @endif

                                                            @if ($value['child'] > 0)
                                                                @php
                                                                    $j = 0;
                                                                @endphp
                                                                @for ($i = 1; $i <= $value['child']; $i++)
                                                                @php
                                                                $cwb = "";
                                                                $cwb_age = "";
                                                                if( isset($value['room_child_age'][$j]) ){
                                                                    $cwb_age = $value['room_child_age'][$j]->age;
                                                                    $cwb = $value['room_child_age'][$j]->cwb;
                                                                    //echo "<pre>";
                                                                       // print_r($value['room_child_age'][$j]);
                                                                }   
                                                                $j++;                                                            
                                                                @endphp
                                                                    <div class="row x-gap-20 y-gap-20 pt-5">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="exampleFormControlSelect1">Title -
                                                                                    Child </label>
                                                                                <select class="form-control addvalidation"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][child][title][]">
                                                                                    <option value="Mr">Mr.</option>
                                                                                    <option value="Ms">Ms.</option>
                                                                                    <option value="Mrs">Mrs.</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">First
                                                                                    Name -
                                                                                    Child</label>
                                                                                <input type="text"
                                                                                    class="form-control addvalidation"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][child][firstname][]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">Last
                                                                                    Name
                                                                                    -
                                                                                    Child</label>
                                                                                <input type="text"
                                                                                    class="form-control addvalidation"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][child][lastname][]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">ID
                                                                                    Proof
                                                                                    Type
                                                                                    - Child</label>
                                                                                <select class="form-control addvalidation"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][child][id_proof][]">
                                                                                    <option value="Aadhaar">Aadhaar
                                                                                    </option>
                                                                                    <option value="Passport">Passport
                                                                                    </option>
                                                                                    <option value="Driving Licence">Driving
                                                                                        Licence
                                                                                    </option>
                                                                                    <option value="Voters ID Card">Voters
                                                                                        ID
                                                                                        Card
                                                                                    </option>
                                                                                    <option value="PAN card">PAN card
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">ID
                                                                                    Proof
                                                                                    No -
                                                                                    Child</label>
                                                                                <input type="text"
                                                                                    class="form-control addvalidation"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][child][id_proof_no][]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">Age</label>
                                                                                <input type="text"
                                                                                    class="form-control addvalidation"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][child][age][]" value="{{ $cwb_age }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleFormControlInput1">CWB</label>
                                                                                <input type="text"
                                                                                    class="form-control addvalidation"
                                                                                    name="hotel[{{ $key }}][room_no_{{ $roomNo }}][child][cwb][]" value="{{ $cwb }}">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="mt-10 border-top-light"></div>
                                                                @endfor
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row lead_passengers">
                                            <div class="col-12">
                                                <div class="main-tag-input-data">
                                                    <div class="text-info-checkout">Lead passenger</div>
                                                    <div class="sub-tag-input-data">
                                                        
                                                    
                                                  <div class="tag-input-data">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Title - Adult</label>
                                                            <select class="form-control lead_addvalidation" name="lead_title" id="exampleFormControlSelect1">
                                                                <option value="Mr">Mr.</option>
                                                                <option value="Ms">Ms.</option>
                                                                <option value="Mrs">Mrs.</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="tag-input-data">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlInput1">First
                                                                Name- Adult <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control lead_addvalidation"
                                                                name="lead_firstname" onkeydown="return /[a-zA-Z ]/.test(event.key)">
                                                        </div>
                                                    </div>
                                                    <div class="tag-input-data">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlInput1">Last
                                                                Name- Adult <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control lead_addvalidation"
                                                                name="lead_lastname" onkeydown="return /[a-zA-Z ]/.test(event.key)">
                                                        </div>
                                                    </div>
                                                    <div class="tag-input-data">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlInput1">ID Proof
                                                                Type- Adult</label>
                                                            <select class="form-control lead_addvalidation"
                                                                name="lead_id_proof">
                                                                <option value="Aadhaar">Aadhaar</option>
                                                                <option value="Passport">Passport</option>
                                                                <option value="Driving Licence">Driving Licence
                                                                </option>
                                                                <option value="Voters ID Card">Voters ID Card
                                                                </option>
                                                                <option value="PAN card">PAN card</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="tag-input-data">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlInput1">ID Proof
                                                                No- Adult <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control lead_addvalidation"
                                                                name="lead_id_proof_no" oninput="this.value = this.value.replace(/[^0-9a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');">
                                                        </div>
                                                    </div>

                                                    <div class="tag-input-data">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlInput1">Phone
                                                                Number- Adult <span class="text-danger">*</span></label>
                                                            <input type="text" id="" oninput="this.value = this.value.replace(/[^0-9]+/g, '').replace(/(\..*)\./g, '$1');"
                                                                class="form-control phonenumber lead_addvalidation"
                                                                placeholder="Phone Number" name="lead_phonenumber">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="tag-input-data">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Agency Reference</label>
                                                <input type="text" class="form-control"
                                                    name="agency_reference">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                
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
                                                <div class="class="lh-12" style="color: #333;  font-size: 17px;">By proceeding with this booking, I
                                                        agree to
                                                        GoTrip Terms of Use and Privacy Policy. <span class="text-danger">*</span></div>
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
                                                            {{ getNumberWithCommaGlobalCurrency(availableBalance($user->agents->id)) }}) <span class="text-danger">*</span>
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
                                                    <div class="text-14 lh-1 ml-10">Pay On Online payment <span class="text-danger">*</span></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <ul class="y-gap-4 pt-5 text-right inline-block">
                                                <li class="text-14">
                                                    <button type="button"
                                                        class="button header-login-btn saveDraft"
                                                        name="Draft">
                                                        Save as Draft <i
                                                            class="fa fa-floppy-o fa-2x text-blue-1 px-10"></i>
                                                    </button>
                                                </li>
                                                <li class="text-14">
                                                    <button type="button"
                                                        class="button header-login-btn saveQuote"
                                                        name="Quote">
                                                        Save as Quote <i
                                                            class="fa fa-bookmark-o fa-2x text-blue-1 px-10 text-white"></i>
                                                    </button>
                                                </li>
                                                <li class="text-14">
                                                    <button type="button"
                                                        class="button header-login-btn saveOrder"
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
                            <div class="text-20 fw-500 mb-20">Your price summary</div>
                            <div class="review-section total-review">
                                <ul class="review-list">
                                    @if (is_array($requiredParamArr) && count($requiredParamArr) > 0)
                                        @foreach ($requiredParamArr as $bo_key => $bo_value)
                                            @if ($bo_key == 'hotel')
                                                @foreach ($bo_value as $key => $value)
                                                    @php
                                                        $age = [];
                                                        $hotelsDetails = $hotelListingRepository->hotelDetailsArr($value['hotel_id']);
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
                                                            $room_title_with_child = 'for ' . $value['adult'] . ' adults';
                                                            $room_adult_with_child = $value['adult'] . ' Adults';
                                                        }
                                                        if ($value['child']) {
                                                            $room_title_with_child .= ', ' . $value['child'] . ' children - ' . implode(',', $age) . ' years old';
                                                            $room_adult_with_child .= ', ' . $value['child'] . ' Child - ' . implode(',', $age) . ' years';
                                                        }

                                                    @endphp
                                                    <ul class="y-gap-4 pt-5">
                                                        <li class="text-14">
                                                            <i class="fa fa-bed"></i> {{ $hotelsDetails['hotel']['hotel_name'] }} <br> {{ $offlineRoom->roomtype->room_type }} 
                                                            <span class="pull-right"> {{ getNumberWithCommaGlobalCurrency($value['finalAmount']) }}</span>
                                                        </li>
                                                        <li class="text-14">
                                                            <i class="fa fa-user"></i> {{ $room_adult_with_child }}
                                                        </li>
                                                        <li class="text-14">
                                                            <div class="border-top-light mt-30 mb-20"></div>
                                                        </li>                               
                                                    </ul>
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
                                    <div class="text-15">Taxes and fees ({{ $Taxes_and_fees }}%)</div>
                                </div>
                                <div class="col-auto">

                                    <div class="text-15">{{ getNumberWithCommaGlobalCurrency($Taxes_and_fees_amt) }}</div>
                                </div>
                            </div>
                            <div class="px-20 py-20 bg-blue-2 rounded-4 mt-20">
                                <div class="row y-gap-5 justify-between">
                                    <div class="col-auto">
                                        <div class="text-18 lh-13 fw-500">Price</div>
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


                            {{-- <label class="text-16 lh-1 fw-500 text-dark-1 mb-10">Margin Type</label>
                            <div class="col-12 mb-2 text-14 text-light-1">
                                <div class="form-radio d-flex items-center ">
                                    <div class="radio">
                                        <input type="radio" name="popup_margin_type" value="1"
                                            class="popup_margin_type" checked>
                                        <div class="radio__mark">
                                            <div class="radio__icon"></div>
                                        </div>
                                    </div>
                                    <div class="text-14 lh-1 ml-10">Percentage Margin
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2 text-14 text-light-1">
                                <div class="form-radio d-flex items-center ">
                                    <div class="radio">
                                        <input type="radio" name="popup_margin_type" value="2"
                                            class="popup_margin_type">
                                        <div class="radio__mark">
                                            <div class="radio__icon"></div>
                                        </div>
                                    </div>
                                    <div class="text-14 lh-1 ml-10">Fix Margin</div>
                                </div>
                            </div>
                            <span id="popup_margin_type-error" class="help-block help-block-error hide">This field is
                                required.</span>
                            <div class="col-12">
                                <div class="form-input">
                                    <input type="number" name="margin_amt" autocomplete="off"
                                        class="has-value margin_amt">
                                    <label class="lh-1 text-14 text-light-1">Margin</label>
                                </div>
                                <span id="margin_amt-error" class="help-block help-block-error hide">This field is
                                    required.</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-input">
                                <input type="text" name="quote_email" autocomplete="off"
                                    class="has-value quote_email">
                                <label class="lh-1 text-14 text-light-1">Email</label>
                            </div>
                            <span id="quote_email-error" class="help-block help-block-error hide">This field is
                                required.</span>
                        </div> --}}

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
        <script src="{{ asset('assets/front/js/Check-out.js') }}"></script>
        <script src="{{ asset('assets/front/js/search-form/Currencies.js') }}"></script>
        <script src="{{ asset('assets/front/js/intlTelInput/js/intlTelInput-jquery.min.js') }}"></script>
        <script type="text/javascript">
            $(".phonenumber").intlTelInput({
                initialCountry: "in",
                separateDialCode: true,
            });
            // .on('countrychange', function (e, countryData) {
            //     alert($(".phonenumber").intlTelInput("getSelectedCountryData").dialCode);
            //     //alert($("#lead_phonenumber").intlTelInput("getNumber"));
            //     console.log($("#lead_phonenumber").intlTelInput("getNumber"));
            // });

            var moduleConfig = {
                checkoutLogin: "{!! route('post-login') !!}",
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
