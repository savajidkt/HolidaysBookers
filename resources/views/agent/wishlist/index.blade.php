@extends('agent.layouts.app')
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

                            @if ($wishlist->count() > 0)
                                @foreach ( $wishlist as $item)
                                
                                <div class="col-md-12 wishlist-id-{{ $item->hotel->id }}">
                                    <div class="border-bottom-light pb-20">
                                        <div class="row x-gap-20 y-gap-30">
                                            <div class="col-md-auto">
                                                <div class="cardImage ratio ratio-1:1 w-200 md:w-1/1 rounded-4">
                                                    <div class="cardImage__content">
                                                        @if (strlen($item->hotel->hotel_image_location) > 0)
                                                        <img src="{{ url(Storage::url('app/upload/Hotel/' . $item->hotel->id . '/' . $item->hotel->hotel_image_location)) }}"
                                                            class="rounded-4 js-lazy loading" alt="{{ $item->hotel->hotel_name }}"
                                                            data-ll-status="loading">
                                                            @else
                                                            <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/hotel/1.png"
                                        alt="{{ $item->hotel->hotel_name }}">
                                                        @endif
                                                    </div>
                                                    <div class="service-wishlist active" data-id="10" data-type="hotel">
                                                        <div class="cardImage__wishlist">
                                                            <button
                                                                class="button -blue-1 bg-white size-30 rounded-full shadow-2 wishlistMe {{ isWishlist($item->hotel->id, 'hotel') }}" data-wishlist-h-id="{{ $item->hotel->id }}" data-wishlist-type="hotel" data-wishlist-u-id="{{ isset($item->user_id) ? $item->user_id : '' }}">
                                                                <i class="icon-heart text-12"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="cardImage__leftBadge">
                                                        <div
                                                            class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-dark-1 text-white">
                                                            Featured
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <a href="{{ route('hotel-details', selectRoomBooking(array('hotel_id'=>$item->hotel->id),true)) }}"
                                                    class="text-18 lh-14 fw-500 text-dark-1">{{ $item->hotel->hotel_name }}</a>
                                                <div class="rate  pt-10">
                                                    <div class="list-star">
                                                        @if ($item->hotel->category)
                                                        <div class="d-flex relative">
                                                            <ul class="booking-item-rating-stars d-flex x-gap-5">
                                                                @for ($i = 1; $i <= $item->hotel->category; $i++)
                                                                <li><i class="fa text-yellow-1 fa-star-o"></i></li>
                                                                @endfor                                                               
                                                            </ul>
                                                            <div class="booking-item-rating-stars-active" style="width: 94%">
                                                                <ul class="booking-item-rating-stars d-flex x-gap-5">
                                                                    @for ($i = 1; $i <= $item->hotel->category; $i++)
                                                                    <li><i class="fa text-yellow-1 fa-star"></i></li>
                                                                    @endfor
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="pt-10 text-dark-1">
                                                    <i class="icofont-license"></i>
                                                    Service Type: <span class="badge badge-info">{{ $item->hotel->property->property_name }}</span>
                                                </div>
                                                <div class="pt-5 text-dark-1">
                                                    <i class="icofont-paper-plane"></i>
                                                    Location: {{ $item->hotel->hotel_address }}
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
                                                                {{ $item->hotel->hotel_review }} reviews
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div
                                                                class="flex-center text-white fw-600 text-14 size-40 rounded-4 bg-blue-1">
                                                                {{ $item->hotel->hotel_review }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- <div class="pt-24">
                                                        <div class="fw-500">Starting from</div>
                                                        <span class="fw-500 text-blue-1 text-20">
                                                            <span class="sale-price"></span>
                                                            $550
                                                        </span>
                                                    </div> --}}

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            No Items 
                            @endif                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="bravo-pagination">
                <span class="count-string">{!! $wishlist->links() !!}</span>
            </div>
        </div>

        @include('agent.common.footer')
    </div>
@endsection
@section('page-script')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript">

    var moduleConfig = {           
            addToWishList: "{!! route('add-to-wishlist') !!}",
        };
    jQuery(document).on('click', '.wishlistMe', function () {
       
        // $(this).addClass('teampCLS');
        var tempD = $(this);
        var h_id = $(this).attr('data-wishlist-h-id');
        if ($(this).attr('data-wishlist-u-id') > 0) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: moduleConfig.addToWishList,
                type: "POST",
                dataType: "json",
                data: {
                    user_id: $(this).attr('data-wishlist-u-id'),
                    hotel_id: $(this).attr('data-wishlist-h-id'),
                    type: $(this).attr('data-wishlist-type'),
                },
                success: function (data) {                    
                    jQuery('.wishlist-id-'+h_id).remove();
                }
            });
        }             
    });
</script>
@endsection
