@extends('layouts.app')
@section('page_title', 'Home')
@section('content')

<style>
  .hide{ display: none; }
</style>

{{-- <section class="pt-40">
    <div class="container">
      <div class="row x-gap-40 y-gap-30 items-center">
        <div class="col-auto">
          <div class="d-flex items-center">
            <div class="size-40 rounded-full flex-center bg-blue-1">
              <i class="icon-check text-16 text-white"></i>
            </div>
            <div class="text-18 fw-500 ml-10">Your selection</div>
          </div>
        </div>

        <div class="col">
          <div class="w-full h-1 bg-border"></div>
        </div>

        <div class="col-auto">
          <div class="d-flex items-center">
            <div class="size-40 rounded-full flex-center bg-blue-1-05 text-blue-1 fw-500">2</div>
            <div class="text-18 fw-500 ml-10">Your details</div>
          </div>
        </div>

        <div class="col">
          <div class="w-full h-1 bg-border"></div>
        </div>

        <div class="col-auto">
          <div class="d-flex items-center">
            <div class="size-40 rounded-full flex-center bg-blue-1-05 text-blue-1 fw-500">3</div>
            <div class="text-18 fw-500 ml-10">Final step</div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}

  <section class="pt-40 layout-pb-md">
    <div class="container">
      <div class="row">
        <div class="col-xl-7 col-lg-8">
          <div class="py-15 px-20 rounded-4 text-15 bg-blue-1-05">
            Sign in to book with your saved details or
            <a href="#" class="text-blue-1 fw-500">register</a>
            to manage your bookings on the go!
          </div>

          <h2 class="text-22 fw-500 mt-40 md:mt-24">Guest Details</h2>

          <form class="needs-validation1" id="CheckoutFrm" method="POST"
                                        enctype="multipart/form-data" action="{{ route('checkout.store') }}">
                                         @csrf
          <div class="row x-gap-20 y-gap-20 pt-20">            
            <div class="col-md-6">
              <div class="form-input firstname">
                <input type="hidden" name="bookingKey" value="{{ $bookingKey }}">
                <input type="text" name="firstname" required>
                <label class="lh-1 text-16 text-light-1">First Name</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-input lastname">
                <input type="text" name="lastname" required>
                <label class="lh-1 text-16 text-light-1">Last Name</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-input email">
                <input type="text" name="email" required>
                <label class="lh-1 text-16 text-light-1">Email</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-input phone">
                <input type="text" name="phone" required>
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
                  <input type="text" name="registration_number" required>
                  <label class="lh-1 text-16 text-light-1">Registration Number</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-input registered_company_name">
                  <input type="text" name="registered_company_name" required>
                  <label class="lh-1 text-16 text-light-1">Registered Company name</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-input registered_company_address">
                  <input type="text" name="registered_company_address" required>
                  <label class="lh-1 text-16 text-light-1">Registered Company address</label>
                </div>
              </div>
            </div>
            </div>
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
                      <div class="text-14 lh-12 ml-10">By proceeding with this booking, I agree to GoTrip Terms of Use and Privacy Policy.</div>
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
                          <div class="text-12 fw-600 text-white">{{ $hotelsDetails['hotel']['hotel_review'] }}</div>
                        </div>

                        <div class="text-14 fw-500 ml-10">Exceptional</div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <div class="text-14">{{ $hotelsDetails['hotel']['hotel_review'] }} reviews</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="border-top-light mt-30 mb-20"></div>

              <div class="row y-gap-20 justify-between">
                <div class="col-auto">
                  <div class="text-15">Check-in</div>
                  <div class="fw-500">{{ date('d M, Y', strtotime($requiredParamArr['search_from'])) }}</div>
                  {{-- <div class="text-15 text-light-1">15:00 – 23:00</div> --}}
                </div>

                <div class="col-auto md:d-none">
                  <div class="h-full w-1 bg-border"></div>
                </div>

                <div class="col-auto text-right md:text-left">
                  <div class="text-15">Check-out</div>
                  <div class="fw-500">{{ date('d M, Y', strtotime($requiredParamArr['search_to'])) }}</div>
                  {{-- <div class="text-15 text-light-1">01:00 – 11:00</div> --}}
                </div>
              </div>

              <div class="border-top-light mt-30 mb-20"></div>

              <div class="">
                <div class="text-15">Total length of stay:</div>
                <div class="fw-500">{{ dateDiffInDays($requiredParamArr['search_from'], $requiredParamArr['search_to']) }} nights</div>
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
                  <div class="text-15">{{ ($requiredParamArr['room']) ? $requiredParamArr['room'].' room':''  }} {{ ($requiredParamArr['adult']) ? $requiredParamArr['adult'].' adult':''  }} {{ ($requiredParamArr['child']) ? $requiredParamArr['child'].' child':''  }}</div>
                </div>
              </div>
            </div>

            <div class="px-30 py-30 border-light rounded-4 mt-30">
              <div class="text-20 fw-500 mb-20">Your price summary</div>

              <div class="row y-gap-5 justify-between">
                <div class="col-auto">
                  <div class="text-15">Superior Twin</div>
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
                  <div class="text-15">US$674.47</div>
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

              <div class="px-20 py-20 bg-blue-2 rounded-4 mt-20">
                <div class="row y-gap-5 justify-between">
                  <div class="col-auto">
                    <div class="text-18 lh-13 fw-500">Price</div>
                  </div>
                  <div class="col-auto">
                    <div class="text-18 lh-13 fw-500">US$4,046.81</div>
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
@endsection
@section('page-script')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/Check-out.js') }}"></script>
    @endsection