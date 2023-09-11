@extends('layouts.app')
@section('page_title', 'Offers')
@section('content')
    <section class="layout-pt-lg layout-pb-lg">
        <div class="container">
            <div class="row justify-center text-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">Offers</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">Lorem ipsum is placeholder text commonly used in site.
                        </p>
                    </div>                    
                </div>
            </div>

            <div class="row y-gap-30 pt-60 layout-pb-sm">

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <img src="{{ asset('assets/front') }}/img/pages/help/icons/1.svg" alt="icon">
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Booking your activity</div>
                            <p class="mt-5">Lorem ipsum is placeholder text commonly used in site.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <img src="{{ asset('assets/front') }}/img/pages/help/icons/2.svg" alt="icon">
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Payment &amp; receipts</div>
                            <p class="mt-5">Lorem ipsum is placeholder text commonly used in site.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <img src="{{ asset('assets/front') }}/img/pages/help/icons/3.svg" alt="icon">
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Booking changes &amp; refunds</div>
                            <p class="mt-5">Lorem ipsum is placeholder text commonly used in site.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <img src="{{ asset('assets/front') }}/img/pages/help/icons/4.svg" alt="icon">
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Promo codes &amp; credits</div>
                            <p class="mt-5">Lorem ipsum is placeholder text commonly used in site.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <img src="{{ asset('assets/front') }}/img/pages/help/icons/5.svg" alt="icon">
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">On the participation day</div>
                            <p class="mt-5">Lorem ipsum is placeholder text commonly used in site.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="bg-blue-1-05 rounded-4 px-50 py-40">
                        <div class="size-70 bg-white rounded-full flex-center">
                            <img src="{{ asset('assets/front') }}/img/pages/help/icons/6.svg" alt="icon">
                        </div>

                        <div class="mt-24">
                            <div class="text-18 fw-500">Value Packs</div>
                            <p class="mt-5">Lorem ipsum is placeholder text commonly used in site.</p>
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
