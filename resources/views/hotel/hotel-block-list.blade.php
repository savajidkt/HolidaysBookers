@php
    $user = auth()->user();
@endphp
<script>
    function myFunction(imgs) {
        var expandImg = document.getElementById("expandedImg");
        var imgText = document.getElementById("imgtext");
        expandImg.src = imgs.src;
        imgText.innerHTML = imgs.alt;
        expandImg.parentElement.style.display = "block";
    }
</script>
@if (count($hotelList) > 0)
    @foreach ($hotelList as $hotel)
        @if (isset($hotel['room']['finalAmount']) && $hotel['room']['finalAmount'] > 0)
            <div class="col-12 topScroll" data-hot="{{ $hotel['id'] }}">
                <div class="border-top-light pt-30">
                    <div class="row x-gap-20 y-gap-20 main-hb-hotal-list">
                        <div class="col-md-auto">
                            <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4">
                                <div class="cardImage__content">

                                    <a href="{{ route('hotel-details', selectRoomBooking($requestParam)) }}">
                                        @if (strlen($hotel['hotel_image_location']) > 0)
                                            <img class="rounded-4 col-12"
                                                src="{{ url(Storage::url('app/upload/Hotel/' . $hotel['id'] . '/' . $hotel['hotel_image_location'])) }}"
                                                alt="{{ $hotel['hotel_name'] }}">
                                        @else
                                            <img class="rounded-4 col-12"
                                                src="{{ asset('assets/front') }}/img/hotel/1.png"
                                                alt="{{ $hotel['hotel_name'] }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="cardImage__wishlist">
                                    <button
                                        class="button -blue-1 bg-white size-30 rounded-full shadow-2 wishlistMe {{ isWishlist($hotel['id'], 'hotel') }}"
                                        data-wishlist-h-id="{{ $hotel['id'] }}" data-wishlist-type="hotel"
                                        data-wishlist-u-id="{{ isset($user->id) ? $user->id : '' }}">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md sec-hb-list-block">
                            @php
                                $singlePageParam = [
                                    'hotel_id' => $hotel['id'],
                                    'adult' => getSearchCookies('searchGuestAdultCount') ? getSearchCookies('searchGuestAdultCount') : 1,
                                    'child' => getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0,
                                    'room' => getSearchCookies('searchGuestRoomCount') ? getSearchCookies('searchGuestRoomCount') : 1,
                                    'city_id' => $requestParam['requested_city_id'],
                                    'location' => $requestParam['requested_location'],
                                    'country_id' => $requestParam['requested_country_id'],
                                    'search_from' => $requestParam['requested_search_from'],
                                    'search_to' => $requestParam['requested_search_to'],
                                ];
                            @endphp

                            <a href="{{ route('hotel-details', selectRoomBooking($singlePageParam, true)) }}">
                                <h3 class="text-18 lh-16 fw-500">
                                    {{ $hotel['hotel_name'] }}<br class="lg:d-none">
                                    {{ $hotel['property_type_id'] }},
                                    {{ $hotel['hotel_country'] }}
                                    @if ($hotel['category'])
                                        <div class="d-inline-block ml-10">
                                            @for ($i = 1; $i <= $hotel['category']; $i++)
                                                <i class="icon-star text-10 text-yellow-2"></i>
                                            @endfor
                                        </div>
                                    @endif
                                </h3>
                            </a>
                            <div class="row x-gap-10 y-gap-10 items-center ">
                                <div class="col-auto">
                                    <p class="text-14"><i class="icon-location"></i>{{ $hotel['hotel_address'] }}</p>
                                </div>

                            </div>
                           
                          
                            @if ($hotel['hotel_amenities'])
                                <div class="row x-gap-10 y-gap-10">
                                    @foreach ($hotel['hotel_amenities'] as $amenity)
                                        <div class="col-auto">
                                            <div class="border-light rounded-100 py-5 px-20 text-14 lh-14">
                                                {{ $amenity['amenity_name'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                              <div class="text-14 text-green-2 lh-15 hb-list-dropdown">
                                <a href="javascript:void(0);" data-hotel-id="{{ $hotel['id'] }}" data-type="map"
                                    class="viewMoreRooms bg-blue-1 text-white mt-24">
                                    Map
                                </a>
                                <a href="javascript:void(0);" data-hotel-id="{{ $hotel['id'] }}" data-type="images"
                                    class="viewMoreRooms bg-blue-1 text-white mt-24">
                                    Images
                                </a>
                                <a href="javascript:void(0);" data-hotel-id="{{ $hotel['id'] }}"
                                    data-type="description" class="viewMoreRooms bg-blue-1 text-white mt-24">
                                    Description
                                </a>
                            </div>
                        </div>
                        <div class="col-md-auto text-right md:text-left last-hb-list-block">
                           

                            <div class="last-hb-list-block-d">
                               
                                {{-- <div class="current-amount"> --}}
                                    {{-- {{ getNumberWithCommaGlobalCurrency($hotel['room']['finalAmount']) }}                                     --}}
                                {{-- </div> --}}
                                <div class="text-22 lh-12 fw-600 mt-5 offer-amount">
                                    {{ getNumberWithCommaGlobalCurrency($hotel['room']['finalAmount']) }}                                   
                                </div>

                                @php

                                    $bookingParam = [];

                                    $bookingParam = [
                                        'is_type' => 'hotel',
                                        'hotel_id' => isset($hotel['room']['hotel_id']) ? $hotel['room']['hotel_id'] : '',
                                        'room_id' => isset($hotel['room']['room_id']) ? $hotel['room']['room_id'] : '',
                                        'price_id' => isset($hotel['room']['price_id']) ? $hotel['room']['price_id'] : '',
                                        'adult' => getSearchCookies('searchGuestAdultCount') ? getSearchCookies('searchGuestAdultCount') : 0,
                                        'child' => getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0,
                                        'room' => getSearchCookies('searchGuestRoomCount') ? getSearchCookies('searchGuestRoomCount') : 0,
                                        'city_id' => isset($requestParam['requested_city_id']) ? $requestParam['requested_city_id'] : '',
                                        'search_from' => isset($requestParam['requested_search_from']) ? $requestParam['requested_search_from'] : '',
                                        'search_to' => isset($requestParam['requested_search_to']) ? $requestParam['requested_search_to'] : '',
                                        'originAmount' => isset($hotel['room']['originAmount']) ? numberFormat($hotel['room']['originAmount']) : '',
                                        'productMarkupAmount' => isset($hotel['room']['adminproductMarkupAmount']) ? numberFormat($hotel['room']['adminproductMarkupAmount']) : '',
                                        'agentMarkupAmount' => isset($hotel['room']['adminagentMarkupAmount']) ? numberFormat($hotel['room']['adminagentMarkupAmount']) : '',
                                        'agentGlobalMarkupAmount' => isset($hotel['room']['agentMarkupAmount']) ? numberFormat($hotel['room']['agentMarkupAmount']) : '',
                                        'finalAmount' => isset($hotel['room']['finalAmount']) ? numberFormat($hotel['room']['finalAmount']) : '',
                                    ];

                                    $isAddedCart = false;
                                @endphp

                                @if (is_array($bookingCartArr) && count($bookingCartArr))
                                    @foreach ($bookingCartArr as $bo_key => $bo_value)
                                        @if ($bo_key == 'hotel')
                                            @foreach ($bo_value as $key => $value)
                                                @if ($value['hotel_id'] == $hotel['room']['hotel_id'] && $value['room_id'] == $hotel['room']['room_id'])
                                                    @php
                                                        $isAddedCart = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                                {{-- @if ($isAddedCart) --}}
                                    {{-- <a href="javascript:void(0);"
                                        class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5">
                                        <span class="icons">Added</span>

                                    </a>

                                    <a href="javascript:void(0);" data-hotel-id="{{ $hotel['id'] }}" data-type="see"
                                        class="viewMoreRooms button -md -dark-1 bg-blue-1 text-white mt-24">
                                        See More <div class="icon-eye ml-15"></div>
                                    </a> --}}
                                {{-- @else --}}
                                    
                                   <a href="javascript:void(0);" data-hotel-id="{{ $hotel['id'] }}" data-type="see" class="viewMoreRooms button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5" onclick="toggleTextAndIcon(this)">
                                        More prices & boards
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </a>

                                {{-- @endif --}}






                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 is-hide slide-out-div-h-{{ $hotel['id'] }}">
                <div class="overlay" id="overlay-{{ $hotel['id'] }}">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div>
            </div>
            <div class="col-12 is-hide slide-out-div-{{ $hotel['id'] }}">
            </div>
            <div class="col-12 is-hide map-{{ $hotel['id'] }}">
                <div class="border-light">
                    <div class="d-flex items-center">
                        @if (strlen($hotel['hotel_latitude']) > 0 && strlen($hotel['hotel_longitude']) > 0)
                            <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{ $hotel['hotel_latitude'] }},{{ $hotel['hotel_longitude'] }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        @else
                            <div class="button text-dark-1">Hotel map not found!</div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-12 is-hide images-{{ $hotel['id'] }}">
                <div class=" border-light-hb">
                   
                                <article id="hotel-photo-210074" class="photo">
                                                <div class="gallery-tb">
                                                    <div class="tb-row">
                                                                <div>
                                                                     <img id="expandedImg" src="https://tse4.mm.bing.net/th?id=OIP.H6Znb4LwWOEUCbMW8sxrTgHaEo&pid=Api&P=0&h=180" style="width:100%">
                                                                </div>
                                                                <!-- Grid of smaller images -->
                                                                <div class="photos-small">
                                                                    <div class="column">
                                                                        <img src="https://tse4.mm.bing.net/th?id=OIP.H6Znb4LwWOEUCbMW8sxrTgHaEo&pid=Api&P=0&h=180"
                                                                            alt="Nature" style="width:100%" onclick="changeImage(this);">
                                                                    </div>
                                                                    <div class="column">
                                                                        <img src="https://tse1.mm.bing.net/th?id=OIP._IgGc9h6kbuSmYLsRhBNvwHaEo&pid=Api&P=0&h=180.jpg"
                                                                            alt="Snow" style="width:100%" onclick="changeImage(this);">
                                                                    </div>
                                                                    <div class="column">
                                                                        <img src="https://tse1.mm.bing.net/th?id=OIP.NbfPECA64xbFnmW58MbWDQHaEo&pid=Api&P=0&h=180"
                                                                            alt="Mountains" style="width:100%" onclick="changeImage(this);">
                                                                    </div>
                                                                    <div class="column">
                                                                        <img src="https://tse1.mm.bing.net/th?id=OIP.1YM53mG10H_U25iPjop83QHaEo&pid=Api&P=0&h=180"
                                                                            alt="Lights" style="width:100%" onclick="changeImage(this);">
                                                                    </div>
                                                                    <div class="column">
                                                                        <img src="https://tse1.mm.bing.net/th?id=OIP.1YM53mG10H_U25iPjop83QHaEo&pid=Api&P=0&h=180"
                                                                            alt="Lights" style="width:100%" onclick="changeImage(this);">
                                                                    </div>
                                                                    <!-- Add more image columns as needed -->
                                                                </div>

                                                    </div>
                                                </div>
                                            </article>
                    
                </div>
            </div>
            <div class="col-12 is-hide description-{{ $hotel['id'] }}">
                <div class="border-light">
                    {!! $hotel['hotel_description'] !!}
                </div>
            </div>
        @endif
    @endforeach
@else
    <div class="col-12 topScroll">
        <div class="border-top-light pt-30">
            <div class="row x-gap-20 y-gap-20">
                <div class="col-md-auto">
                    <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4">
                        <div class="cardImage__content">
                            Result not found!
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endif
{{-- {{ $hotelList->render() }} --}}
{{ $hotelListModel->withQueryString()->links('common.pagination', ['hotelCount' => $hotelCount]) }}
