@extends('customer.layouts.app')
@section('page_title', 'WishList')
@section('content')
    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">WishList</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
            </div>
        </div>

        <div class="py-30 px-30 rounded-4 bg-white shadow-3">
            <div class="tabs -underline-2 js-tabs">
                <div class="tabs__contentjs-tabs-content">
                    <div class="tabs__pane -tab-item-1 is-tab-el-active">
                        <div class="row y-gap-20">
                            <div class="col-md-12">
                                <div class="border-bottom-light pb-20">
                                    <div class="row x-gap-20 y-gap-30">
                                        <div class="col-md-auto">
                                            <div class="cardImage ratio ratio-1:1 w-200 md:w-1/1 rounded-4">
                                                <div class="cardImage__content">
                                                    <img src="https://gotrip.bookingcore.org/uploads/gotrip/hotel/4.png"
                                                        class="rounded-4 js-lazy loading" alt="Dylan Hotel"
                                                        data-ll-status="loading">
                                                </div>
                                                <div class="service-wishlist active" data-id="10" data-type="hotel">
                                                    <div class="cardImage__wishlist">
                                                        <button
                                                            class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                                            <i class="icon-heart text-12"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="cardImage__leftBadge">
                                                    <div
                                                        class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-dark-1 text-white">
                                                        Featured
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <a href="https://gotrip.bookingcore.org/hotel/dylan-hotel-1"
                                                class="text-18 lh-14 fw-500 text-dark-1">Dylan Hotel</a>
                                            <div class="rate  pt-10">
                                                <div class="list-star">
                                                    <div class="d-flex relative">
                                                        <ul class="booking-item-rating-stars d-flex x-gap-5">
                                                            <li><i class="fa text-yellow-1 fa-star-o"></i></li>
                                                            <li><i class="fa text-yellow-1 fa-star-o"></i></li>
                                                            <li><i class="fa text-yellow-1 fa-star-o"></i></li>
                                                            <li><i class="fa text-yellow-1 fa-star-o"></i></li>
                                                            <li><i class="fa text-yellow-1 fa-star-o"></i></li>
                                                        </ul>
                                                        <div class="booking-item-rating-stars-active" style="width: 94%">
                                                            <ul class="booking-item-rating-stars d-flex x-gap-5">
                                                                <li><i class="fa text-yellow-1 fa-star"></i></li>
                                                                <li><i class="fa text-yellow-1 fa-star"></i></li>
                                                                <li><i class="fa text-yellow-1 fa-star"></i></li>
                                                                <li><i class="fa text-yellow-1 fa-star"></i></li>
                                                                <li><i class="fa text-yellow-1 fa-star"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pt-10 text-dark-1">
                                                <i class="icofont-license"></i>
                                                Service Type: <span class="badge badge-info">Hotel</span>
                                            </div>
                                            <div class="pt-5 text-dark-1">
                                                <i class="icofont-paper-plane"></i>
                                                Location: Rome
                                            </div>
                                        </div>
                                        <div class="col-md-auto text-right md:text-left">
                                            <div class="d-flex flex-column justify-between h-full">
                                                <div
                                                    class="row x-gap-10 y-gap-10 justify-end items-center md:justify-start">
                                                    <div class="col-auto">
                                                        <div class="text-14 lh-14 fw-500">
                                                            Excellent
                                                        </div>
                                                        <div class="text-14 lh-14 text-light-1">
                                                            3 Reviews
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="flex-center text-white fw-600 text-14 size-40 rounded-4 bg-blue-1">
                                                            4.7</div>
                                                    </div>
                                                </div>
                                                <div class="pt-24">
                                                    <div class="fw-500">Starting from</div>
                                                    <span class="fw-500 text-blue-1 text-20">
                                                        <span class="sale-price"></span>
                                                        $550
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bravo-pagination">
                <span class="count-string">Showing 1 - 1 of 1</span>
            </div>
        </div>

        @include('customer.common.footer')
    </div>
@endsection
@section('page-script')
@endsection
