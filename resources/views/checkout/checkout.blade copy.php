@extends('layouts.app')
@section('page_title', 'Home')
@section('content')

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
    </style>

    <section class="pt-40 layout-pb-md">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8">

                    @if (isset($user->id))
                        <h2 class="text-22 fw-500 mt-40 md:mt-24">Let us know who you are</h2>
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
                            <div class="row x-gap-20 y-gap-20 pt-20">
                                <div class="col-md-6">
                                    <div class="form-input firstname">
                                        <input type="hidden" name="bookingKey" value="{{ $bookingKey }}">
                                        <input type="text" name="firstname" required
                                            value="{{ $user->first_name ? $user->first_name : '' }}">
                                        <label class="lh-1 text-16 text-light-1">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input lastname">
                                        <input type="text" name="lastname" required
                                            value="{{ $user->last_name ? $user->last_name : '' }}">
                                        <label class="lh-1 text-16 text-light-1">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input email">
                                        <input type="text" name="email" required
                                            value="{{ $user->email ? $user->email : '' }}">
                                        <label class="lh-1 text-16 text-light-1">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input phone">
                                        <input type="text" name="phone" required
                                            value="{{ isset($user->usermeta->phone_number) ? $user->usermeta->phone_number : '' }}">
                                        <label class="lh-1 text-16 text-light-1">Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex items-center">
                                        <div class="form-checkbox ">
                                            <input type="checkbox" name="gst_enable">
                                            <div class="form-checkbox__mark">
                                                <div class="form-checkbox__icon icon-check"></div>
                                            </div>
                                        </div>
                                        <div class="text-14 lh-12 ml-10">Enter GST Details</div>
                                    </div>
                                </div>
                                <div class="enablegst hide">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-input registration_number">
                                                <input type="text" name="registration_number" required value="">
                                                <label class="lh-1 text-16 text-light-1">Registration Number</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-input registered_company_name">
                                                <input type="text" name="registered_company_name" required
                                                    value="">
                                                <label class="lh-1 text-16 text-light-1">Registered Company name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-input registered_company_address">
                                                <input type="text" name="registered_company_address" required
                                                    value="">
                                                <label class="lh-1 text-16 text-light-1">Registered Company address</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h2 class="text-22 fw-500 mt-40 md:mt-24">Passenger Details</h2>
                                {{-- {{ dd(getSearchCookies('searchGuestArr')) }} --}}
                                @if (is_array(getSearchCookies('searchGuestArr')) && getSearchCookies('searchGuestArr') > 0)
                                    @php
                                        $roomNo = 0;
                                    @endphp
                                    @foreach (getSearchCookies('searchGuestArr') as $key => $value)
                                        @php
                                            $roomNo++;
                                        @endphp
                                        <div class="border-type-1 rounded-8 px-20 py-20 mt-20">
                                            <div class="row y-gap-20 justify-between">
                                                <div class="col-auto">
                                                    <div class="fw-500">Room {{ $key + 1 }}
                                                    </div>
                                                </div>
                                                <div class="col-auto text-right md:text-left">
                                                    <div class="fw-500">Adult</div>
                                                </div>
                                            </div>
                                            <div class="py-5 border-top-light"></div>
                                            @if ($value->adult > 0)
                                                @for ($i = 1; $i <= $value->adult; $i++)
                                                    <div class="row x-gap-20 y-gap-20 pt-5">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1">Title</label>
                                                                <select class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[adult][title][]">
                                                                    <option value="Mr">Mr.</option>
                                                                    <option value="Ms">Ms.</option>
                                                                    <option value="Mrs">Mrs.</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">First Name</label>
                                                                <input type="text" class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[adult][firstname][]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">Last Name</label>
                                                                <input type="text" class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[adult][lastname][]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">ID Proof Type</label>
                                                                <select class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[adult][id_proof][]">
                                                                    <option value="Aadhaar">Aadhaar</option>
                                                                    <option value="Passport">Passport</option>
                                                                    <option value="Driving Licence">Driving Licence
                                                                    </option>
                                                                    <option value="Voters ID Card">Voters ID Card</option>
                                                                    <option value="PAN card">PAN card</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">ID Proof No</label>
                                                                <input type="text" class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[adult][id_proof_no][]">
                                                            </div>
                                                        </div>
                                                        @if ($i == 1)
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlInput1">Phone
                                                                        Number</label>
                                                                    <input type="text"
                                                                        class="form-control addvalidation"
                                                                        name="room_no_{{ $roomNo }}[adult][phonenumber][]">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endfor
                                            @endif
                                            @if ($value->child > 0)
                                                <div class="row y-gap-20 justify-between">
                                                    <div class="col-auto">
                                                        <div class="fw-500">Room {{ $key + 1 }}
                                                        </div>
                                                    </div>
                                                    <div class="col-auto text-right md:text-left">
                                                        <div class="fw-500">Child</div>
                                                    </div>
                                                </div>
                                                <div class="py-5 border-top-light"></div>
                                                @php
                                                    $k = 0;
                                                @endphp
                                                @for ($i = 1; $i <= $value->child; $i++)
                                                    <div class="row x-gap-20 y-gap-20 pt-5">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1">Title</label>
                                                                <select class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[child][title][]">
                                                                    <option value="Mr">Mr.</option>
                                                                    <option value="Ms">Ms.</option>
                                                                    <option value="Mrs">Mrs.</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">First Name</label>
                                                                <input type="text" class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[child][firstname][]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">Last Name</label>
                                                                <input type="text" class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[child][lastname][]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">ID Proof Type</label>
                                                                <select class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[child][id_proof][]">
                                                                    <option value="Aadhaar">Aadhaar</option>
                                                                    <option value="Passport">Passport</option>
                                                                    <option value="Driving Licence">Driving Licence
                                                                    </option>
                                                                    <option value="Voters ID Card">Voters ID Card</option>
                                                                    <option value="PAN card">PAN card</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">ID Proof No</label>
                                                                <input type="text" class="form-control addvalidation"
                                                                    name="room_no_{{ $roomNo }}[child][id_proof_no][]">
                                                            </div>
                                                        </div>

                                                        @if (is_array($value->childAge) && count($value->childAge) > 0)
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlInput1">Age</label>
                                                                    <select
                                                                        name="room_no_{{ $roomNo }}[child][age][]"
                                                                        id="age" class="form-control">
                                                                        @for ($j = 2; $j <= 11; $j++)
                                                                            <option value="{{ $j }}"
                                                                                {{ $value->childAge[$k]->age == $j ? 'selected' : '' }}>
                                                                                {{ $j }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <label for="exampleFormControlInput1"></label>
                                                                <div class="d-flex items-center">
                                                                    <div class="form-checkbox">
                                                                        <input type="checkbox"
                                                                            name="room_no_{{ $roomNo }}[child][cwb][]"
                                                                            {{ $value->childAge[$k]->cwb == 'yes' ? 'checked' : '' }}
                                                                            value="{{ $value->childAge[$k]->cwb }}">
                                                                        <div class="form-checkbox__mark">
                                                                            <div class="form-checkbox__icon icon-check">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-14 lh-12 ml-10">CWB</div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="py-20 border-top-light"></div>
                                                    </div>
                                                    @php
                                                        $k++;
                                                    @endphp
                                                @endfor
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                                <div class="col-12 pt-20">
                                    <div class="row y-gap-20 items-center justify-between">
                                        <div class="col-auto">
                                            <div class="text-14 text-light-1">
                                                <div class="d-flex items-center agree">
                                                    <div class="form-checkbox ">
                                                        <input type="checkbox" name="agree">
                                                        <div class="form-checkbox__mark">
                                                            <div class="form-checkbox__icon icon-check"></div>
                                                        </div>
                                                    </div>
                                                    <div class="text-14 lh-12 ml-10">By proceeding with this booking, I
                                                        agree to
                                                        GoTrip Terms of Use and Privacy Policy.</div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-auto col-12">

                                            {{-- <div class="col-12 mb-2 text-14 text-light-1">
                                                <div class="form-radio d-flex items-center ">
                                                    <div class="radio">
                                                        <input type="radio" name="payment_method" value="1">
                                                        <div class="radio__mark">
                                                            <div class="radio__icon"></div>
                                                        </div>
                                                    </div>
                                                    <div class="text-14 lh-1 ml-10">Pay On time limit</div>
                                                </div>
                                            </div> --}}

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
                                                            {{ availableBalance($user->agents->id, 'INR') }})
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
                                                    <div class="text-14 lh-1 ml-10">Pay On Online payment</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <button type="submit" class="button h-60 px-24 -dark-1 bg-blue-1 text-white">
                                                Pay Now <div class="icon-arrow-top-right ml-15"></div>
                                            </button>

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
                        <div class="px-30 py-30 border-light rounded-4">
                            <div class="text-20 fw-500 mb-30">Review your Booking</div>
                            <div class="row x-gap-15 y-gap-20">
                                <div class="col-auto">
                                    @if (strlen($hotelsDetails['hotel']['hotel_image_location']) > 0)
                                        <img class="size-140 rounded-4 object-cover"
                                            src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/' . $hotelsDetails['hotel']['hotel_image_location'])) }}"
                                            alt="{{ $hotelsDetails['hotel']['hotel_name'] }}">
                                    @endif
                                </div>
                                <div class="col">
                                    @if ($hotelsDetails['hotel']['category'] > 0)
                                        <div class="d-flex x-gap-5 pb-10">
                                            @for ($i = 1; $i <= $hotelsDetails['hotel']['category']; $i++)
                                                <i class="icon-star text-10 text-yellow-1"></i>
                                            @endfor
                                        </div>
                                    @endif
                                    <div class="lh-17 fw-500">{{ $hotelsDetails['hotel']['hotel_name'] }}</div>
                                    <div class="text-14 lh-15 mt-5">{{ $hotelsDetails['hotel']['hotel_address'] }}</div>
                                    <div class="row x-gap-10 y-gap-10 items-center pt-10">
                                        <div class="col-auto">
                                            <div class="d-flex items-center">
                                                <div class="size-30 flex-center bg-blue-1 rounded-4">
                                                    <div class="text-12 fw-600 text-white">
                                                        {{ $hotelsDetails['hotel']['hotel_review'] }}</div>
                                                </div>
                                                <div class="text-14 fw-500 ml-10">Exceptional</div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-14">{{ $hotelsDetails['hotel']['hotel_review'] }} reviews
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-top-light mt-30 mb-20"></div>
                            <div class="row y-gap-20 justify-between">
                                <div class="col-auto">
                                    <div class="text-15">Check-in</div>
                                    <div class="fw-500">{{ date('d M, Y', strtotime(getSearchCookies('search_from'))) }}
                                    </div>
                                </div>
                                <div class="col-auto md:d-none">
                                    <div class="h-full w-1 bg-border"></div>
                                </div>
                                <div class="col-auto text-right md:text-left">
                                    <div class="text-15">Check-out</div>
                                    <div class="fw-500">{{ date('d M, Y', strtotime(getSearchCookies('search_to'))) }}
                                    </div>
                                </div>
                            </div>

                            <div class="border-top-light mt-30 mb-20"></div>
                            <div class="">
                                <div class="text-15">Total length of stay:</div>
                                <div class="fw-500">
                                    {{ dateDiffInDays(getSearchCookies('search_from'), getSearchCookies('search_to')) }}
                                    nights</div>
                            </div>
                            <div class="border-top-light mt-30 mb-20"></div>
                            <div class="row y-gap-20 justify-between items-center">
                                <div class="col-auto">
                                    <div class="text-15">You selected:</div>
                                    {{-- <div class="fw-500">{{ $offlineRoom->roomtype->room_type }}</div> --}}
                                </div>
                                <div class="col-auto">
                                    <div class="text-15">
                                        {{-- Room {{ getSearchCookies('searchGuestRoomCount') }}, --}}
                                        Adult {{ getSearchCookies('searchGuestAdultCount') }},
                                        Child {{ getSearchCookies('searchGuestChildCount') }}</div>
                                </div>
                            </div>
                        </div>
                        @php
                            $amountFinal = 0;
                        @endphp
                        <div class="px-30 py-30 border-light rounded-4 mt-30">
                            <div class="text-20 fw-500 mb-20">Your price summary</div>
                            <div class="review-section total-review">
                                <ul class="review-list">
                                    @if (is_array($requiredParamArr) && count($requiredParamArr) > 0)
                                        @foreach ($requiredParamArr as $key => $value)
                                            @php
                                                $offlineRoom = getRoomDetailsByRoomID($value['room_id']);
                                            @endphp
                                            <li class="flex-wrap">
                                                <div class="label"> {{ $offlineRoom->roomtype->room_type }} * 1</div>
                                                <div class="val">
                                                    {{ numberFormat($value['finalAmount'], globalCurrency()) }}
                                                    @php
                                                        $amountFinal = $amountFinal + $value['finalAmount'];
                                                    @endphp
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="border-top-light mt-30 mb-20"></div>


                            <div class="row y-gap-5 justify-between pt-5">
                                <div class="col-auto">
                                    <div class="text-15">Taxes and fees (0%)</div>
                                </div>
                                <div class="col-auto">
                                    <div class="text-15">{{ numberFormat(0, globalCurrency()) }}</div>
                                </div>
                            </div>

                            {{-- @if (strlen($requiredParamArr['coupon_code']) > 0)
                                <div class="row y-gap-5 justify-between pt-5">
                                    <div class="col-auto">
                                        <div class="text-15">Coupon Code</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15">
                                            {{ $requiredParamArr['coupon_code'] ? $requiredParamArr['coupon_code'] : 0 }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row y-gap-5 justify-between pt-5">
                                    <div class="col-auto">
                                        <div class="text-15">Coupon Amount</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15">
                                            {{ $requiredParamArr['coupon_amount'] ? $requiredParamArr['coupon_amount'] : 0 }}
                                        </div>
                                    </div>
                                </div>
                            @endif --}}
                            <div class="px-20 py-20 bg-blue-2 rounded-4 mt-20">
                                <div class="row y-gap-5 justify-between">
                                    <div class="col-auto">
                                        <div class="text-18 lh-13 fw-500">Price</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-18 lh-13 fw-500">
                                            {{ numberFormat($amountFinal, globalCurrency()) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="px-30 py-30 border-light rounded-4 mt-30">
                            <div class="text-20 fw-500 mb-15">Do you have a promo code?</div>
                            <div class="form-input ">
                                <input type="text" required>
                                <label class="lh-1 text-16 text-light-1">Enter promo code</label>
                            </div>
                            <button class="button -outline-blue-1 text-blue-1 px-30 py-15 mt-20">Apply</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
@section('page-script')
    <script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/Check-out.js') }}"></script>
    <script type="text/javascript">
        var moduleConfig = {
            checkoutLogin: "{!! route('post-login') !!}",
        };
    </script>
@endsection
