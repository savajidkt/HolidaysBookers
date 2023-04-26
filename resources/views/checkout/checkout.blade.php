@extends('layouts.app')
@section('page_title', 'Home')
@section('content')
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

          <div class="row x-gap-20 y-gap-20 pt-20">
            <div class="col-12">

              <div class="form-input ">
                <input type="text" required>
                <label class="lh-1 text-16 text-light-1">Full Name</label>
              </div>

            </div>
            <div class="col-md-6">

              <div class="form-input ">
                <input type="text" required>
                <label class="lh-1 text-16 text-light-1">Email</label>
              </div>

            </div>
            <div class="col-md-6">

              <div class="form-input ">
                <input type="text" required>
                <label class="lh-1 text-16 text-light-1">Phone Number</label>
              </div>

            </div>
            <div class="col-12">

              <div class="form-input ">
                <input type="text" required>
                <label class="lh-1 text-16 text-light-1">Address line 1</label>
              </div>

            </div>
            <div class="col-12">

              <div class="form-input ">
                <input type="text" required>
                <label class="lh-1 text-16 text-light-1">Address line 2</label>
              </div>

            </div>
            <div class="col-md-6">

              <div class="form-input ">
                <input type="text" required>
                <label class="lh-1 text-16 text-light-1">State/Province/Region</label>
              </div>

            </div>
            <div class="col-md-6">

              <div class="form-input ">
                <input type="text" required>
                <label class="lh-1 text-16 text-light-1">ZIP code/Postal code</label>
              </div>

            </div>

            <div class="col-12">

              <div class="form-input ">
                <textarea required rows="6"></textarea>
                <label class="lh-1 text-16 text-light-1">Special Requests</label>
              </div>

            </div>

            <div class="col-12">
              <div class="row y-gap-20 items-center justify-between">
                <div class="col-auto">
                  <div class="text-14 text-light-1">
                    By proceeding with this booking, I agree to GoTrip Terms of Use and Privacy Policy.
                  </div>
                </div>

                <div class="col-auto">

                  <a href="#" class="button h-60 px-24 -dark-1 bg-blue-1 text-white">
                    Next: Final details <div class="icon-arrow-top-right ml-15"></div>
                  </a>

                </div>
              </div>
            </div>
          </div>

         

          


          

          <div class="w-full h-1 bg-border mt-40 mb-40"></div>

          

         


        </div>

        <div class="col-xl-5 col-lg-4">
          <div class="ml-80 lg:ml-40 md:ml-0">
            <div class="px-30 py-30 border-light rounded-4">
              <div class="text-20 fw-500 mb-30">Your booking details</div>

              <div class="row x-gap-15 y-gap-20">
                <div class="col-auto">
                  <img src="img/backgrounds/1.png" alt="image" class="size-140 rounded-4 object-cover">
                </div>

                <div class="col">
                  <div class="d-flex x-gap-5 pb-10">

                    <i class="icon-star text-yellow-1 text-10"></i>

                    <i class="icon-star text-yellow-1 text-10"></i>

                    <i class="icon-star text-yellow-1 text-10"></i>

                    <i class="icon-star text-yellow-1 text-10"></i>

                    <i class="icon-star text-yellow-1 text-10"></i>

                  </div>

                  <div class="lh-17 fw-500">Great Northern Hotel, a Tribute Portfolio Hotel, London</div>
                  <div class="text-14 lh-15 mt-5">Westminster Borough, London</div>

                  <div class="row x-gap-10 y-gap-10 items-center pt-10">
                    <div class="col-auto">
                      <div class="d-flex items-center">
                        <div class="size-30 flex-center bg-blue-1 rounded-4">
                          <div class="text-12 fw-600 text-white">4.8</div>
                        </div>

                        <div class="text-14 fw-500 ml-10">Exceptional</div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <div class="text-14">3,014 reviews</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="border-top-light mt-30 mb-20"></div>

              <div class="row y-gap-20 justify-between">
                <div class="col-auto">
                  <div class="text-15">Check-in</div>
                  <div class="fw-500">Thu 21 Apr 2022</div>
                  <div class="text-15 text-light-1">15:00 – 23:00</div>
                </div>

                <div class="col-auto md:d-none">
                  <div class="h-full w-1 bg-border"></div>
                </div>

                <div class="col-auto text-right md:text-left">
                  <div class="text-15">Check-out</div>
                  <div class="fw-500">Sat 30 Apr 2022</div>
                  <div class="text-15 text-light-1">01:00 – 11:00</div>
                </div>
              </div>

              <div class="border-top-light mt-30 mb-20"></div>

              <div class="">
                <div class="text-15">Total length of stay:</div>
                <div class="fw-500">9 nights</div>
                <a href="#" class="text-15 text-blue-1 underline">Travelling on different dates?</a>
              </div>

              <div class="border-top-light mt-30 mb-20"></div>

              <div class="row y-gap-20 justify-between items-center">
                <div class="col-auto">
                  <div class="text-15">You selected:</div>
                  <div class="fw-500">Superior Double Studio</div>
                  <a href="#" class="text-15 text-blue-1 underline">Change your selection</a>
                </div>

                <div class="col-auto">
                  <div class="text-15">1 room, 4 adult</div>
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
              <div class="text-20 fw-500 mb-20">Your payment schedule</div>

              <div class="row y-gap-5 justify-between">
                <div class="col-auto">
                  <div class="text-15">Before you stay you'll pay</div>
                </div>
                <div class="col-auto">
                  <div class="text-15">US$4,047</div>
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
