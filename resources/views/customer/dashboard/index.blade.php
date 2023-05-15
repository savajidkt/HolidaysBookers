@extends('customer.layouts.app')
@section('page_title', 'Home')
@section('content')
    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">

                <h1 class="text-30 lh-14 fw-600">Dashboard Customer</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>

            </div>

            <div class="col-auto">

            </div>
        </div>
        <div class="row y-gap-30">
            <div class="col-xl-3 col-md-6">
                <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                    <div class="row y-gap-20 justify-between items-center">
                        <div class="col-auto">
                            <div class="fw-500 lh-14">Pending</div>
                            <div class="text-26 lh-16 fw-600 mt-5">$12,800</div>
                            <div class="text-15 lh-14 text-light-1 mt-5">Total pending</div>
                        </div>

                        <div class="col-auto">
                            <img src="{{ asset('assets/front') }}/img/dashboard/icons/1.svg" alt="icon">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                    <div class="row y-gap-20 justify-between items-center">
                        <div class="col-auto">
                            <div class="fw-500 lh-14">Earnings</div>
                            <div class="text-26 lh-16 fw-600 mt-5">$14,200</div>
                            <div class="text-15 lh-14 text-light-1 mt-5">Total earnings</div>
                        </div>

                        <div class="col-auto">
                            <img src="{{ asset('assets/front') }}/img/dashboard/icons/2.svg" alt="icon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                    <div class="row y-gap-20 justify-between items-center">
                        <div class="col-auto">
                            <div class="fw-500 lh-14">Bookings</div>
                            <div class="text-26 lh-16 fw-600 mt-5">$8,100</div>
                            <div class="text-15 lh-14 text-light-1 mt-5">Total bookings</div>
                        </div>

                        <div class="col-auto">
                            <img src="{{ asset('assets/front') }}/img/dashboard/icons/3.svg" alt="icon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                    <div class="row y-gap-20 justify-between items-center">
                        <div class="col-auto">
                            <div class="fw-500 lh-14">Services</div>
                            <div class="text-26 lh-16 fw-600 mt-5">22,786</div>
                            <div class="text-15 lh-14 text-light-1 mt-5">Total bookable services</div>
                        </div>

                        <div class="col-auto">
                            <img src="{{ asset('assets/front') }}/img/dashboard/icons/4.svg" alt="icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('customer.common.footer')
    </div>
@endsection
@section('page-script')
@endsection
