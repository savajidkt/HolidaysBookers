@extends('layouts.app')
@section('page_title', 'About Us')
@section('content')
    <section class="section-bg layout-pt-lg layout-pb-lg">
        <div class="section-bg__item col-12">
            <img src="{{ asset('assets/front') }}/img/pages/about/1.png" alt="image">
        </div>

        <div class="container">
            <div class="row justify-center text-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <h1 class="text-40 md:text-25 fw-600 text-white">Looking for joy?</h1>
                    <div class="text-white mt-15">Your trusted trip companion</div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-lg layout-pb-md">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Why Choose Us</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">These popular destinations have a lot to offer</p>
                    </div>
                </div>
            </div>

            <div class="row y-gap-40 justify-between pt-50">

                <div data-anim-child="slide-up delay-2" class="col-lg-3 col-sm-6">

                    <div class="featureIcon -type-1 ">
                        <div class="d-flex justify-center">
                            <img src="#" data-src="{{ asset('assets/front') }}/img/featureIcons/1/1.svg"
                                alt="image" class="js-lazy">
                        </div>

                        <div class="text-center mt-30">
                            <h4 class="text-18 fw-500">Best Price Guarantee</h4>
                            <p class="text-15 mt-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>

                </div>

                <div data-anim-child="slide-up delay-3" class="col-lg-3 col-sm-6">

                    <div class="featureIcon -type-1 ">
                        <div class="d-flex justify-center">
                            <img src="#" data-src="{{ asset('assets/front') }}/img/featureIcons/1/2.svg"
                                alt="image" class="js-lazy">
                        </div>

                        <div class="text-center mt-30">
                            <h4 class="text-18 fw-500">Easy & Quick Booking</h4>
                            <p class="text-15 mt-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>

                </div>

                <div data-anim-child="slide-up delay-4" class="col-lg-3 col-sm-6">

                    <div class="featureIcon -type-1 ">
                        <div class="d-flex justify-center">
                            <img src="#" data-src="{{ asset('assets/front') }}/img/featureIcons/1/3.svg"
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

    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row y-gap-30 justify-between items-center">
                <div class="col-lg-5">
                    <h2 class="text-30 fw-600">About Holidays Bookers</h2>
                    <p class="mt-5">Welcome To Holidays Bookers DMC India Pvt Ltd Company</p>

                    <p class="text-dark-1 mt-60 lg:mt-40 md:mt-20">
                        Holidays Bookers DMC as a fastest growing Destination Management Company. Holidays Bookers founded
                        in 2014 and since then has been expanding its business throughout the tourism sector as a B2b
                        Destination Management Company. In such a short span of time, it has managed more than 5000+ active
                        travel agent accounts in 6 countries from the world with own presence offering extensive allotments
                        of Hotel’s rooms within the entire Singapore, Malaysia, Indonesia, Thailand, Nepal and India as well
                        as all kinds of land services such as Transfers, Tours and excursions to satisfy everyone's needs.
                        <br><br>
                        We are one the growing hotel consolidator in India with prepurchase deals of ITC Hotels, Welcome
                        Hotels, Justa Hotels, Mayfair and many more. We are Expert in Holiday packages for FIT, GIT, MICE
                        and can customize the itineraries as per agent requirement. Our young and energetic multilingual
                        staff is eager to serve our clients assuring the highest level of customer service. All our FIT
                        services can be easily booked in short notice also. We have a dedicated team of Group Specialists
                        able to customize any itinerary and request your Incentive and/or Leisure groups might have.
                        <br><br>
                        Holidays Bookers latest addition is our new Customer Service department. Our chosen Team will
                        satisfy the needs and concern of agents and associates by full filling their requirements and to
                        give them a personal touch.
                    </p>
                </div>

                <div class="col-lg-6">
                    <img src="{{ asset('assets/front') }}/img/pages/about/2.png" alt="image" class="rounded-4">
                </div>
            </div>
        </div>
    </section>

    <section class="section-bg layout-pt-lg layout-pb-lg">
        <div class="section-bg__item -mx-20 bg-light-2"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="row x-gap-100 justfiy-between">
                        <div class="col-md-4">
                            <div class="y-gap-15">
                                <div class="text-20 fw-500 mb-30">Vision of Company</div>
                                <div class="d-flex items-center">
                                    <div class="d-flex justify-center items-center border-light rounded-full size-20 mr-10">
                                        <i class="icon-check text-6"></i>
                                    </div>
                                    <p class="text-15 text-dark-1">To be the most trusted and innovative Destination
                                        Management Company in the world.To promote and facilitate sustainable growth of our
                                        all business associates.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="y-gap-15">
                                <div class="text-20 fw-500 mb-30">Mission of Company</div>
                                <div class="d-flex items-center">
                                    <div class="d-flex justify-center items-center border-light rounded-full size-20 mr-10">
                                        <i class="icon-check text-6"></i>
                                    </div>
                                    <p class="text-15 text-dark-1">To ensure satisfaction and profit for our Business
                                        associates.</p>
                                </div>

                                <div class="d-flex items-center">
                                    <div class="d-flex justify-center items-center border-light rounded-full size-20 mr-10">
                                        <i class="icon-check text-6"></i>
                                    </div>
                                    <p class="text-15 text-dark-1">To develop consistent and long-term relationships with
                                        our agents and Vendors.</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="y-gap-15">
                                <div class="text-20 fw-500 mb-30">Strategies of Company</div>
                                <div class="d-flex items-center">
                                    <div class="d-flex justify-center items-center border-light rounded-full size-20 mr-10">
                                        <i class="icon-check text-6"></i>
                                    </div>
                                    <p class="text-15 text-dark-1">Market penetration and promotion of new products and
                                        services.</p>
                                </div>

                                <div class="d-flex items-center">
                                    <div class="d-flex justify-center items-center border-light rounded-full size-20 mr-10">
                                        <i class="icon-check text-6"></i>
                                    </div>
                                    <p class="text-15 text-dark-1">Professionalism and open communication with all our
                                        agents and associates.</p>
                                </div>
                                <div class="d-flex items-center">
                                    <div class="d-flex justify-center items-center border-light rounded-full size-20 mr-10">
                                        <i class="icon-check text-6"></i>
                                    </div>
                                    <p class="text-15 text-dark-1">Adaptation to the latest information technology systems,
                                        work procedures and environmental issues</p>
                                </div>
                                <div class="d-flex items-center">
                                    <div
                                        class="d-flex justify-center items-center border-light rounded-full size-20 mr-10">
                                        <i class="icon-check text-6"></i>
                                    </div>
                                    <p class="text-15 text-dark-1">Implementation of effective training and development
                                        methods.</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="row pt-60 lg:pt-40">
                    <div class="col-12">
                      <div class="text-20 fw-500 mb-30">Core Values</div>
                      <ul class="list-disc y-gap-15">
                        <li>Team Holidays Bookers DMC India Pvt Ltd is having only one Mission to Provide Best Services to our Clients and make their Holiday Memorable...</li>
                        <li>Leadership Skills</li>
                        <li>Organizational Skills</li>
                        <li>Excellent Written and Verbal Communication</li>
                        <li>Intelligence</li>
                        <li>Active Listening Skills</li>
                        <li>Honesty, Ambition and a Strong Work Ethic</li>
                      </ul>
                    </div>
                  </div> --}}

            </div>




        </div>
    </section>

    <section class="layout-pt-md">
        <div class="container">
            <div class="row justify-center text-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Our Office</h2>
                    </div>


                </div>
            </div>

            <div class="row y-gap-30 pt-60 lg:pt-40">

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <i class="icon-location-2 text-light-1 text-20 pt-4"></i>
                        </div>
                        <div class="mt-24">
                            <div class="text-18 fw-500">Delhi</div>
                            <p class="mt-5">39A Ground Floor, Sarvodya School, Aya Nagar, New Delhi 110047</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <i class="icon-location-2 text-light-1 text-20 pt-4"></i>
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Gurugram</div>
                            <p class="mt-5">775, sector 21E, Gurugram Haryana 122016</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <i class="icon-location-2 text-light-1 text-20 pt-4"></i>
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Kolkata</div>
                            <p class="mt-5">Girikunj Apartment Block -JB P.O & P.S - New Alipore Kolkata -700053</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <i class="icon-location-2 text-light-1 text-20 pt-4"></i>
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Indonesia</div>
                            <p class="mt-5">Jalan Nangka Selatan Gang perkutut, Denpasar, Bali, Indonesia</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <i class="icon-location-2 text-light-1 text-20 pt-4"></i>
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Nepal</div>
                            <p class="mt-5">New Road, Kathmandu, Nepal</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <i class="icon-location-2 text-light-1 text-20 pt-4"></i>
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Singapore</div>
                            <p class="mt-5">35 Selegie road,# 9-22 Parklane Shopping mall, Singapore 188307</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <i class="icon-location-2 text-light-1 text-20 pt-4"></i>
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Malaysia</div>
                            <p class="mt-5">Perscott Hotel Sentral No 10, Jalan Tun, Sambanthan 50470, Brickfields, Kuala Lampur</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <i class="icon-location-2 text-light-1 text-20 pt-4"></i>
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Albania</div>
                            <p class="mt-5">Tirane, tirane, TIRANE Rruga “NdreMjeda”, Pall ,1020 Kati I</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>




    <section class="layout-pt-lg layout-pb-lg">
        <div class="container">
            <div class="row y-gap-20 justify-between items-end">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Our Team</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">Lorem ipsum dolor sit amet</p>
                    </div>
                </div>

                <div class="col-auto">

                    <div class="d-flex x-gap-15 items-center justify-center">
                        <div class="col-auto">
                            <button class="d-flex items-center text-24 arrow-left-hover js-team-prev">
                                <i class="icon icon-arrow-left"></i>
                            </button>
                        </div>

                        <div class="col-auto">
                            <div class="pagination -dots text-border js-team-pag"></div>
                        </div>

                        <div class="col-auto">
                            <button class="d-flex items-center text-24 arrow-right-hover js-team-next">
                                <i class="icon icon-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="overflow-hidden pt-40 js-section-slider" data-gap="30"
                data-slider-cols="xl-5 lg-4 md-2 sm-2 base-1" data-nav-prev="js-team-prev" data-pagination="js-team-pag"
                data-nav-next="js-team-next">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="">
                            <img src="{{ asset('assets/front') }}/img/team/1.png" alt="image"
                                class="rounded-4 col-12">

                            <div class="mt-10">
                                <div class="text-18 lh-15 fw-500">Cody Fisher</div>
                                <div class="text-14 lh-15">Medical Assistant</div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="">
                            <img src="{{ asset('assets/front') }}/img/team/2.png" alt="image"
                                class="rounded-4 col-12">

                            <div class="mt-10">
                                <div class="text-18 lh-15 fw-500">Dianne Russell</div>
                                <div class="text-14 lh-15">Web Designer</div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="">
                            <img src="{{ asset('assets/front') }}/img/team/3.png" alt="image"
                                class="rounded-4 col-12">

                            <div class="mt-10">
                                <div class="text-18 lh-15 fw-500">Jerome Bell</div>
                                <div class="text-14 lh-15">Marketing Coordinator</div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="">
                            <img src="{{ asset('assets/front') }}/img/team/4.png" alt="image"
                                class="rounded-4 col-12">

                            <div class="mt-10">
                                <div class="text-18 lh-15 fw-500">Theresa Webb</div>
                                <div class="text-14 lh-15">Nursing Assistant</div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="">
                            <img src="{{ asset('assets/front') }}/img/team/5.png" alt="image"
                                class="rounded-4 col-12">

                            <div class="mt-10">
                                <div class="text-18 lh-15 fw-500">Cameron Williamson</div>
                                <div class="text-14 lh-15">Dog Trainer</div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="">
                            <img src="{{ asset('assets/front') }}/img/team/6.png" alt="image"
                                class="rounded-4 col-12">

                            <div class="mt-10">
                                <div class="text-18 lh-15 fw-500">Courtney Henry</div>
                                <div class="text-14 lh-15">Medical Assistant</div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="">
                            <img src="{{ asset('assets/front') }}/img/team/7.png" alt="image"
                                class="rounded-4 col-12">

                            <div class="mt-10">
                                <div class="text-18 lh-15 fw-500">Theresa Williamson</div>
                                <div class="text-14 lh-15">Web Designer</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="section-bg layout-pt-lg layout-pb-lg">
        <div class="section-bg__item -mx-20 bg-light-2"></div>

        <div class="container">
            <div class="row justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Overheard from travelers</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">These popular destinations have a lot to offer</p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden pt-80 js-section-slider" data-gap="30"
                data-slider-cols="xl-3 lg-3 md-2 sm-1 base-1">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonials -type-1 bg-white rounded-4 pt-40 pb-30 px-40">
                            <h4 class="text-16 fw-500 text-blue-1 mb-20">Hotel Equatorial Melaka</h4>
                            <p class="testimonials__text lh-18 fw-500 text-dark-1">&quot;Our family was traveling via
                                bullet train between cities in Japan with our luggage - the location for this hotel made
                                that so easy. Agoda price was fantastic.&quot;</p>

                            <div class="pt-20 mt-28 border-top-light">
                                <div class="row x-gap-20 y-gap-20 items-center">
                                    <div class="col-auto">
                                        <img class="size-60" src="{{ asset('assets/front') }}/img/avatars/1.png"
                                            alt="image">
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 fw-500 lh-14">Courtney Henry</div>
                                        <div class="text-14 lh-14 text-light-1 mt-5">Web Designer</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonials -type-1 bg-white rounded-4 pt-40 pb-30 px-40">
                            <h4 class="text-16 fw-500 text-blue-1 mb-20">Hotel Equatorial Melaka</h4>
                            <p class="testimonials__text lh-18 fw-500 text-dark-1">&quot;Our family was traveling via
                                bullet train between cities in Japan with our luggage - the location for this hotel made
                                that so easy. Agoda price was fantastic.&quot;</p>

                            <div class="pt-20 mt-28 border-top-light">
                                <div class="row x-gap-20 y-gap-20 items-center">
                                    <div class="col-auto">
                                        <img class="size-60" src="{{ asset('assets/front') }}/img/avatars/1.png"
                                            alt="image">
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 fw-500 lh-14">Courtney Henry</div>
                                        <div class="text-14 lh-14 text-light-1 mt-5">Web Designer</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonials -type-1 bg-white rounded-4 pt-40 pb-30 px-40">
                            <h4 class="text-16 fw-500 text-blue-1 mb-20">Hotel Equatorial Melaka</h4>
                            <p class="testimonials__text lh-18 fw-500 text-dark-1">&quot;Our family was traveling via
                                bullet train between cities in Japan with our luggage - the location for this hotel made
                                that so easy. Agoda price was fantastic.&quot;</p>

                            <div class="pt-20 mt-28 border-top-light">
                                <div class="row x-gap-20 y-gap-20 items-center">
                                    <div class="col-auto">
                                        <img class="size-60" src="{{ asset('assets/front') }}/img/avatars/1.png"
                                            alt="image">
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 fw-500 lh-14">Courtney Henry</div>
                                        <div class="text-14 lh-14 text-light-1 mt-5">Web Designer</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonials -type-1 bg-white rounded-4 pt-40 pb-30 px-40">
                            <h4 class="text-16 fw-500 text-blue-1 mb-20">Hotel Equatorial Melaka</h4>
                            <p class="testimonials__text lh-18 fw-500 text-dark-1">&quot;Our family was traveling via
                                bullet train between cities in Japan with our luggage - the location for this hotel made
                                that so easy. Agoda price was fantastic.&quot;</p>

                            <div class="pt-20 mt-28 border-top-light">
                                <div class="row x-gap-20 y-gap-20 items-center">
                                    <div class="col-auto">
                                        <img class="size-60" src="{{ asset('assets/front') }}/img/avatars/1.png"
                                            alt="image">
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 fw-500 lh-14">Courtney Henry</div>
                                        <div class="text-14 lh-14 text-light-1 mt-5">Web Designer</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonials -type-1 bg-white rounded-4 pt-40 pb-30 px-40">
                            <h4 class="text-16 fw-500 text-blue-1 mb-20">Hotel Equatorial Melaka</h4>
                            <p class="testimonials__text lh-18 fw-500 text-dark-1">&quot;Our family was traveling via
                                bullet train between cities in Japan with our luggage - the location for this hotel made
                                that so easy. Agoda price was fantastic.&quot;</p>

                            <div class="pt-20 mt-28 border-top-light">
                                <div class="row x-gap-20 y-gap-20 items-center">
                                    <div class="col-auto">
                                        <img class="size-60" src="{{ asset('assets/front') }}/img/avatars/1.png"
                                            alt="image">
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 fw-500 lh-14">Courtney Henry</div>
                                        <div class="text-14 lh-14 text-light-1 mt-5">Web Designer</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row y-gap-30 items-center pt-40 sm:pt-20">
                <div class="col-xl-4">
                    <div class="row y-gap-30 text-dark-1">
                        <div class="col-sm-5 col-6">
                            <div class="text-30 lh-15 fw-600">13m+</div>
                            <div class="lh-15">Happy People</div>
                        </div>

                        <div class="col-sm-5 col-6">
                            <div class="text-30 lh-15 fw-600">4.88</div>
                            <div class="lh-15">Overall rating</div>

                            <div class="d-flex x-gap-5 items-center pt-10">

                                <div class="icon-star text-dark-1 text-10"></div>

                                <div class="icon-star text-dark-1 text-10"></div>

                                <div class="icon-star text-dark-1 text-10"></div>

                                <div class="icon-star text-dark-1 text-10"></div>

                                <div class="icon-star text-dark-1 text-10"></div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="row y-gap-30 justify-between items-center">

                        <div class="col-md-auto col-sm-6">
                            <div class="d-flex justify-center">
                                <img src="{{ asset('assets/front') }}/img/clients/1.svg" alt="image">
                            </div>
                        </div>

                        <div class="col-md-auto col-sm-6">
                            <div class="d-flex justify-center">
                                <img src="{{ asset('assets/front') }}/img/clients/2.svg" alt="image">
                            </div>
                        </div>

                        <div class="col-md-auto col-sm-6">
                            <div class="d-flex justify-center">
                                <img src="{{ asset('assets/front') }}/img/clients/3.svg" alt="image">
                            </div>
                        </div>

                        <div class="col-md-auto col-sm-6">
                            <div class="d-flex justify-center">
                                <img src="{{ asset('assets/front') }}/img/clients/4.svg" alt="image">
                            </div>
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
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/search-form/Search.js') }}"></script>
@endsection
