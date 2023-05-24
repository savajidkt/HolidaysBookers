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
    </style>

    <section class="pt-40 layout-pb-md">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8">

                    @if (isset(auth()->user()->id))
                        <h2 class="text-22 fw-500 mt-40 md:mt-24">{{ $requiredParamArr->user->first_name }}</h2>
                        <form class="needs-validation1" id="CheckoutFrm" method="POST" enctype="multipart/form-data"
                            action="{{ route('checkout.update', $requiredParamArr) }}">
                            @method('PUT')
                            @csrf
                            <div class="row x-gap-20 y-gap-20 pt-20">
                                <div class="col-md-6">
                                    <div class="form-input firstname">
                                        <input type="hidden" name="bookingKey" value="{{ $bookingKey }}">
                                        <input type="text" name="firstname" required
                                            value="{{ $requiredParamArr->user->first_name ? $requiredParamArr->user->first_name : '' }}">
                                        <label class="lh-1 text-16 text-light-1">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input lastname">
                                        <input type="text" name="lastname" required
                                            value="{{ $requiredParamArr->user->last_name ? $requiredParamArr->user->last_name : '' }}">
                                        <label class="lh-1 text-16 text-light-1">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input email">
                                        <input type="text" name="email" required
                                            value="{{ $requiredParamArr->user->email ? $requiredParamArr->user->email : '' }}">
                                        <label class="lh-1 text-16 text-light-1">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input phone">
                                        <input type="text" name="phone" required
                                            value="{{ isset($requiredParamArr->user->usermeta->phone_number) ? $requiredParamArr->user->usermeta->phone_number : '' }}">
                                        <label class="lh-1 text-16 text-light-1">Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex items-center">
                                        <div class="form-checkbox ">
                                            <input type="checkbox" name="gst_enable"
                                                {{ $requiredParamArr->gst_enable ? 'checked' : '' }}>
                                            <div class="form-checkbox__mark">
                                                <div class="form-checkbox__icon icon-check"></div>
                                            </div>
                                        </div>
                                        <div class="text-14 lh-12 ml-10">Enter GST Details</div>
                                    </div>
                                </div>
                                <div class="enablegst {{ $requiredParamArr->gst_enable ? '' : 'hide' }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-input registration_number">
                                                <input type="text" name="registration_number" required
                                                    value="{{ $requiredParamArr->registration_number ? $requiredParamArr->registration_number : '' }}">
                                                <label class="lh-1 text-16 text-light-1">Registration Number</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-input registered_company_name">
                                                <input type="text" name="registered_company_name" required
                                                    value="{{ $requiredParamArr->registered_company_name ? $requiredParamArr->registered_company_name : '' }}">
                                                <label class="lh-1 text-16 text-light-1">Registered Company name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-input registered_company_address">
                                                <input type="text" name="registered_company_address" required
                                                    value="{{ $requiredParamArr->registered_company_address ? $requiredParamArr->registered_company_address : '' }}">
                                                <label class="lh-1 text-16 text-light-1">Registered Company address</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h2 class="text-22 fw-500 mt-40 md:mt-24">Passenger Details</h2>
                                @if ($requiredParamArr['adult'] > 0)
                                    @for ($i = 1; $i <= $requiredParamArr['adult']; $i++)
                                        <div class="row x-gap-20 y-gap-20 pt-20">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Title</label>
                                                    <select class="form-control" name="adult[title][]">
                                                        <option value="Mr">Mr.</option>
                                                        <option value="Ms">Ms.</option>
                                                        <option value="Mrs">Mrs.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">First Name</label>
                                                    <input type="text" class="form-control" name="adult[firstname][]">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Last Name</label>
                                                    <input type="text" class="form-control" name="adult[lastname][]">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">ID Proof Type</label>
                                                    <select class="form-control" name="adult[id_proof][]">
                                                        <option value="Aadhaar">Aadhaar</option>
                                                        <option value="Passport">Passport</option>
                                                        <option value="Driving Licence">Driving Licence</option>
                                                        <option value="Voters ID Card">Voters ID Card</option>
                                                        <option value="PAN card">PAN card</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">ID Proof No</label>
                                                    <input type="text" class="form-control"
                                                        name="adult[id_proof_no][]">
                                                </div>
                                            </div>
                                            @if ($i == 1)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlInput1">Phone Number</label>
                                                        <input type="text" class="form-control"
                                                            name="adult[phonenumber][]">
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="py-20 border-top-light"></div>
                                        </div>
                                    @endfor
                                @endif
                                @if ($requiredParamArr['child'] > 0)
                                    @for ($i = 1; $i <= $requiredParamArr['child']; $i++)
                                        <div class="row x-gap-20 y-gap-20 pt-20">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Title</label>
                                                    <select class="form-control" name="child[title][]">
                                                        <option value="Mr">Mr.</option>
                                                        <option value="Ms">Ms.</option>
                                                        <option value="Mrs">Mrs.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">First Name</label>
                                                    <input type="text" class="form-control" name="child[firstname][]">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Last Name</label>
                                                    <input type="text" class="form-control" name="child[lastname][]">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">ID Proof Type</label>
                                                    <select class="form-control" name="child[id_proof][]">
                                                        <option value="Aadhaar">Aadhaar</option>
                                                        <option value="Passport">Passport</option>
                                                        <option value="Driving Licence">Driving Licence</option>
                                                        <option value="Voters ID Card">Voters ID Card</option>
                                                        <option value="PAN card">PAN card</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">ID Proof No</label>
                                                    <input type="text" class="form-control"
                                                        name="child[id_proof_no][]">
                                                </div>
                                            </div>
                                            <div class="py-20 border-top-light"></div>
                                        </div>
                                    @endfor
                                @endif

                                <div class="col-12">
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
                                        <div class="col-auto">

                                            <div class="col-12 mb-2 text-14 text-light-1">
                                                <div class="form-radio d-flex items-center ">
                                                    <div class="radio">
                                                        <input type="radio" name="payment_method" value="1">
                                                        <div class="radio__mark">
                                                            <div class="radio__icon"></div>
                                                        </div>
                                                    </div>
                                                    <div class="text-14 lh-1 ml-10">Pay On time limit</div>
                                                </div>
                                            </div>
                                            @php
                                                $userData = auth()->user();
                                            @endphp
                                            @if ($userData->user_type == 1)
                                                <div class="col-12 mb-2 text-14 text-light-1">
                                                    <div class="form-radio d-flex items-center ">
                                                        <div class="radio">
                                                            <input type="radio" name="payment_method" value="2">
                                                            <div class="radio__mark">
                                                                <div class="radio__icon"></div>
                                                            </div>
                                                        </div>
                                                        <div class="text-14 lh-1 ml-10">Pay using wallet (Balance :
                                                            {{ availableBalance($userData->agents->id, 'INR') }})
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
                    @else
                        <div class="py-15 px-20 rounded-4 text-15 bg-blue-1-05">
                            Sign in to book with your saved details or
                            <a data-x-click="login" href="javascript:void(0);" class="text-blue-1 fw-500">Login</a>
                            to manage your bookings on the go!
                        </div>
                        <h2 class="text-22 fw-500 mt-40 md:mt-24">Guest Details</h2>
                        <form class="needs-validation1" id="" method="POST" enctype="multipart/form-data"
                            action="{{ route('post-registration') }}">
                            @csrf
                            <div class="row x-gap-20 y-gap-20 pt-20">
                                <div class="col-md-6">
                                    <input type="hidden" name="bookingKey" value="{{ $bookingKey }}">
                                    <div class="form-input ">
                                        <input id="first_name" type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            name="first_name" value="{{ old('first_name') }}">
                                        <label class="lh-1 text-14 text-light-1">First Name</label>
                                    </div>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input id="last_name" type="text"
                                            class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                            value="{{ old('last_name') }}">
                                        <label class="lh-1 text-14 text-light-1">Last Name</label>
                                    </div>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="form-input ">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}">
                                        <label class="lh-1 text-14 text-light-1">Email</label>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input ">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password">
                                        <label class="lh-1 text-14 text-light-1">Password</label>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">

                                    <div class="form-input ">
                                        <input type="password" name="password_confirmation" id="password-confirm">
                                        <label class="lh-1 text-14 text-light-1">{{ __('Confirm Password') }}</label>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <input type="hidden" name="type" value="2">

                                <div class="col-12">
                                    <div class="row y-gap-20 items-center justify-between">
                                        <div class="col-auto">
                                            <button type="submit" class="button h-60 px-24 -dark-1 bg-blue-1 text-white">
                                                Submit <div class="icon-arrow-top-right ml-15"></div>
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
                                    <div class="fw-500">{{ date('d M, Y', strtotime($requiredParamArr['search_from'])) }}
                                    </div>
                                    {{-- <div class="text-15 text-light-1">15:00 – 23:00</div> --}}
                                </div>

                                <div class="col-auto md:d-none">
                                    <div class="h-full w-1 bg-border"></div>
                                </div>

                                <div class="col-auto text-right md:text-left">
                                    <div class="text-15">Check-out</div>
                                    <div class="fw-500">{{ date('d M, Y', strtotime($requiredParamArr['search_to'])) }}
                                    </div>
                                    {{-- <div class="text-15 text-light-1">01:00 – 11:00</div> --}}
                                </div>
                            </div>

                            <div class="border-top-light mt-30 mb-20"></div>

                            <div class="">
                                <div class="text-15">Total length of stay:</div>
                                <div class="fw-500">
                                    {{ dateDiffInDays($requiredParamArr['search_from'], $requiredParamArr['search_to']) }}
                                    nights</div>
                                {{-- <a href="#" class="text-15 text-blue-1 underline">Travelling on different dates?</a> --}}
                            </div>

                            <div class="border-top-light mt-30 mb-20"></div>

                            <div class="row y-gap-20 justify-between items-center">
                                <div class="col-auto">
                                    <div class="text-15">You selected:</div>
                                    <div class="fw-500">{{ $offlineRoom->roomtype->room_type }}</div>
                                    {{-- <a href="#" class="text-15 text-blue-1 underline">Change your selection</a> --}}
                                </div>

                                <div class="col-auto">
                                    <div class="text-15">
                                        {{ $requiredParamArr['room'] ? $requiredParamArr['room'] . ' room' : '' }}
                                        {{ $requiredParamArr['adult'] ? $requiredParamArr['adult'] . ' adult' : '' }}
                                        {{ $requiredParamArr['child'] ? $requiredParamArr['child'] . ' child' : '' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="px-30 py-30 border-light rounded-4 mt-30">
                            <div class="text-20 fw-500 mb-20">Your price summary</div>

                            <div class="row y-gap-5 justify-between">
                                <div class="col-auto">
                                    <div class="text-15">{{ $offlineRoom->roomtype->room_type }}</div>
                                </div>
                                <div class="col-auto">
                                    <div class="text-15">US$3,372.34</div>
                                </div>
                            </div>

                            <div class="row y-gap-5 justify-between pt-5">
                                <div class="col-auto">
                                    <div class="text-15">Taxes and fees</div>
                                </div>
                                <div class="col-auto">
                                    <div class="text-15">{{ $requiredParamArr['tax'] ? $requiredParamArr['tax'] : 0 }}
                                    </div>
                                </div>
                            </div>

                            <div class="row y-gap-5 justify-between pt-5">
                                <div class="col-auto">
                                    <div class="text-15">Booking fees</div>
                                </div>
                                <div class="col-auto">
                                    <div class="text-15">FREE</div>
                                </div>
                            </div>

                            @if (strlen($requiredParamArr['coupon_code']) > 0)
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
                            @endif
                            <div class="px-20 py-20 bg-blue-2 rounded-4 mt-20">
                                <div class="row y-gap-5 justify-between">
                                    <div class="col-auto">
                                        <div class="text-18 lh-13 fw-500">Price</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-18 lh-13 fw-500">
                                            {{ $requiredParamArr['total_amount'] ? $requiredParamArr['total_amount'] : 0 }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-30 py-30 border-light rounded-4 mt-30">
                            <div class="text-20 fw-500 mb-15">Do you have a promo code?</div>
                            <div class="form-input ">
                                <input type="text" required>
                                <label class="lh-1 text-16 text-light-1">Enter promo code</label>
                            </div>
                            <button class="button -outline-blue-1 text-blue-1 px-30 py-15 mt-20">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="langMenu is-hidden js-langMenu loginModal" data-x="login" data-x-toggle="is-hidden">
        <div class="langMenu__bg" data-x-click="login"></div>
        <div class="langMenu__content bg-white rounded-4">
            <div class="d-flex items-center justify-between px-30 py-20 sm:px-15 border-bottom-light">
                <div class="text-20 fw-500 lh-15">login</div>
                <button class="pointer" data-x-click="login">
                    <i class="icon-close"></i>
                </button>
            </div>
            <div class=" px-30 py-5 sm:px-15 sm:py-15">
                <form id="loginFrm" class="y-gap-20" method="POST" action="">
                    <input type="hidden" name="redirect" class="redirect" value="{{ $bookingKey }}">
                    @csrf
                    <div class="col-12">
                    </div>
                    <div class="col-12">
                        <div class="form-input email-error">
                            <input type="text" name="email" autocomplete="off" class="has-value emailInput">
                            <label class="lh-1 text-14 text-light-1">Email</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-input password-error">
                            <input type="password" name="password" autocomplete="off" class="has-value passwordInput">
                            <label class="lh-1 text-14 text-light-1">Password</label>
                        </div>
                    </div>
    
    
                    <div class="col-12 display-message">
                        <button type="submit"  class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5 SelectSignin">
                            <span class="icons">Sign In</span> 
                            <div class="icon-arrow-top-right ml-15"></div>
                            <div class="fa fa-spinner fa-spin ml-15" style="display: none;"></div>                                
                        </button>
                    </div>
                    <div class="col-12">
                        <div class="text-center px-30">By creating an account, you agree to our Terms of Service and
                            Privacy Statement.</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection
@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/Check-out.js') }}"></script>
    <script type="text/javascript">
        var moduleConfig = {            
            checkoutLogin: "{!! route('post-login') !!}",
        };
    </script>
@endsection
