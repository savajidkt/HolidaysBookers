@extends('layouts.app')
@section('page_title', 'Thank you')
@section('content')
    <style>
        .total-review .review-list li {
            margin-bottom: 13px;
            display: flex;
            justify-content: space-between
        }
    </style>
    <section class="pt-40 layout-pb-md">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                </div>
                <div class="col-xl-7 col-lg-8">
                    <div class="d-flex flex-column items-center mt-60 lg:md-40 sm:mt-24">
                        <div class="size-80 flex-center rounded-full bg-dark-3">
                            <i class="icon-check text-30 text-white"></i>
                        </div>
                        <div class="text-30 lh-1 fw-600 mt-20">Agent, your order was submitted successfully!</div>
                        <div class="text-15 text-light-1 mt-10">Booking details has been sent to:
                            {{ $order->agentcode->user->email }}
                        </div>
                    </div>
                    <div class="border-type-1 rounded-8 px-50 py-35 mt-40">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Order Number</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10"><a href="{{ route('agent.booking-history', 'all') }}">{{ $order->id }}</a></div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Date</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10"><a href="{{ route('agent.booking-history', 'all') }}">
                                    {{ dateFormat($order->created_at, 'd M, Y') }}</a></div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Total</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10"><a href="{{ route('agent.booking-history', 'all') }}">
                                    {{ numberFormat($order->booking_amount, $order->booking_currency) }}</a></div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Payment Method</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10"><a href="{{ route('agent.booking-history', 'all') }}">
                                    {{ paymentMethodName($order->is_pay_using) }}</a></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <a class="button header-login-btn px-30 py-15 mt-20" href="{{ route('home') }}">
                                    Continue shopping
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <a class="button header-login-btn px-30 py-15 mt-20" href="{{ route('agent.dashboard') }}">
                                    Dashboard
                                </a>                                
                            </div>
                        </div>                        
                    </div> 
                </div>
                <div class="col-xl-3 col-lg-4">
                </div>                
            </div>
        </div>
    </section>
@endsection
