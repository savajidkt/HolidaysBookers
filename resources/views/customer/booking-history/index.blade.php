@extends('customer.layouts.app')
@section('page_title', 'Booking History')
@section('content')
    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Booking History</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
            </div>
        </div>
        <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
            <div class="tabs -underline-2 js-tabs">
                <div class="tabs__controls row x-gap-40 y-gap-10 lg:x-gap-20 js-tabs-controls">
                    <div class="col-auto">
                        <a href="{{ route('customer.booking-history','all') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0  {{ $status == 'all' ? 'is-tab-el-active' : '' }} ">
                            All Booking
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('customer.booking-history','completed') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'completed' ? 'is-tab-el-active' : '' }}">
                            Completed
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('customer.booking-history','processing') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'processing' ? 'is-tab-el-active' : '' }}">
                            Processing
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('customer.booking-history','confirmed') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'confirmed' ? 'is-tab-el-active' : '' }}">
                            Confirmed
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('customer.booking-history','cancelled') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'cancelled' ? 'is-tab-el-active' : '' }}">
                            Cancelled
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('customer.booking-history','paid') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'paid' ? 'is-tab-el-active' : '' }}">
                            Paid
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('customer.booking-history','unpaid') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'unpaid' ? 'is-tab-el-active' : '' }}">
                            Unpaid
                        </a>
                    </div>                    
                </div>
                <div class="tabs__content pt-30 js-tabs-content">
                    <div class="tabs__pane -tab-item-1 is-tab-el-active">
                        <div class="overflow-scroll scroll-bar-1">
                            No Booking History
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
