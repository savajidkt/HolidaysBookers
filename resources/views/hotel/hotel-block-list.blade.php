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
                    <div class="row x-gap-20 y-gap-20">
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
                        <div class="col-md">


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
                            <div class="row x-gap-10 y-gap-10 items-center pt-10">
                                <div class="col-auto">
                                    <p class="text-14">Westminster Borough, London</p>
                                </div>

                            </div>
                            <div class="text-14 lh-15 mt-20">
                                <div class="fw-500">{{ $hotel['room']['room_name'] ?? '' }}</div>
                                <div class="text-light-1">{{ $hotel['room']['occ_num_beds'] ?? '' }} Beds</div>
                            </div>
                            <div class="text-14 text-green-2 lh-15 mt-10">
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
                            @if ($hotel['hotel_amenities'])
                                <div class="row x-gap-10 y-gap-10 pt-20">
                                    @foreach ($hotel['hotel_amenities'] as $amenity)
                                        <div class="col-auto">
                                            <div class="border-light rounded-100 py-5 px-20 text-14 lh-14">
                                                {{ $amenity['amenity_name'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="col-md-auto text-right md:text-left">
                            <div class="row x-gap-10 y-gap-10 justify-end items-center md:justify-start">
                                <div class="col-auto">
                                    <div class="text-14 lh-14 fw-500">Exceptional</div>
                                    <div class="text-14 lh-14 text-light-1"> {{ $hotel['hotel_review'] }} reviews</div>
                                </div>
                                <div class="col-auto">
                                    <div class="flex-center text-white fw-600 text-14 size-40 rounded-4 bg-blue-1">
                                        {{ $hotel['hotel_review'] }}</div>
                                </div>
                            </div>

                            <div class="">
                                <div class="text-14 text-light-1 mt-50 md:mt-20">{{ $hotel['room']['min_nights'] ?? 0 }}
                                    nights, {{ $hotel['room']['occ_max_adults'] ?? 0 }} adult
                                </div>
                                <div class="text-22 lh-12 fw-600 mt-5">
                                    {{ numberFormat($hotel['room']['finalAmount'] ?? 0, $hotel['room']['currency'] ?? 0) }}
                                </div>

                                @php
                                    
                                    $bookingParam = [];
                                    $bookingParam = [
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
                                    @foreach ($bookingCartArr as $key => $value)
                                        @if ($value['hotel_id'] == $hotel['room']['hotel_id'] && $value['room_id'] == $hotel['room']['room_id'])
                                            @php
                                                $isAddedCart = true;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                                @if ($isAddedCart)
                                    <a href="javascript:void(0);"
                                        class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5">
                                        <span class="icons">Added</span>
                                    </a>                                   
                                    <a href="javascript:void(0);" data-hotel-id="{{ $hotel['id'] }}" data-type="see"  
                                        class="viewMoreRooms button -md -dark-1 bg-blue-1 text-white mt-24">
                                        See More <div class="icon-eye ml-15"></div>
                                    </a>
                                @else
                                    <button type="button" data-extra="{{ selectRoomBooking($bookingParam, true) }}"
                                        class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5 SelectRoomBook">
                                        <span class="icons">Add</span>
                                        <div class="icon-arrow-top-right ml-15"></div>
                                        <div class="fa fa-spinner fa-spin ml-15" style="display: none;"></div>
                                    </button>
                                    <a href="javascript:void(0);" data-hotel-id="{{ $hotel['id'] }}" data-type="see"
                                        class="viewMoreRooms button -md -dark-1 bg-blue-1 text-white mt-24">
                                        See More <div class="icon-eye ml-15"></div>
                                    </a>
                                @endif
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
                <div class="px-10 py-10 border-light">
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
                <div class="px-10 py-10 border-light">
                    <div class="d-flex items-center">
                        <div class="galleryGrid -type-2">
                            <div class="galleryGrid__item relative d-flex justify-end items-end">

                                <article id="hotel-photo-210074" class="photo">
                                    <div class="gallery-tb">
                                        <div class="tb-row">
                                            {{-- <div class="photo" style="background-image: url(https://static.hotelbeds.com/static/custom/<!-- NO USER INFO -->/images/loading_photo.gif)">
                                            <div>
                                                <span id="photo-big-210074" title="Room" alt="Room" style="background-image: url('https://photos.hotelbeds.com/giata/bigger/21/210074/210074a_hb_w_001.jpg"></span>
                                            </div>
                                        </div> --}}
                                            <div>
                                                {{-- <div class="container"> --}}
                                                <span onclick="this.parentElement.style.display='none'"
                                                    class="closebtn">&times;</span>
                                                <img id="expandedImg" style="width:100%">
                                                <div id="imgtext"></div>
                                                {{-- </div> --}}
                                            </div>
                                            <div id="photos-small-210074" class="photos-small">
                                                {{-- <div class="row"> --}}
                                                <div class="column">
                                                    <img src="https://tse4.mm.bing.net/th?id=OIP.H6Znb4LwWOEUCbMW8sxrTgHaEo&pid=Api&P=0&h=180"
                                                        alt="Nature" style="width:100%"
                                                        onclick="myFunction(this);">
                                                </div>
                                                <div class="column">
                                                    <img src="https://tse1.mm.bing.net/th?id=OIP._IgGc9h6kbuSmYLsRhBNvwHaEo&pid=Api&P=0&h=180.jpg"
                                                        alt="Snow" style="width:100%"
                                                        onclick="myFunction(this);">
                                                </div>
                                                <div class="column">
                                                    <img src="https://tse1.mm.bing.net/th?id=OIP.NbfPECA64xbFnmW58MbWDQHaEo&pid=Api&P=0&h=180"
                                                        alt="Mountains" style="width:100%"
                                                        onclick="myFunction(this);">
                                                </div>
                                                <div class="column">
                                                    <img src="https://tse1.mm.bing.net/th?id=OIP.1YM53mG10H_U25iPjop83QHaEo&pid=Api&P=0&h=180"
                                                        alt="Lights" style="width:100%"
                                                        onclick="myFunction(this);">
                                                </div>
                                                {{-- </div> --}}
                                                {{-- <div class="">
                                                    <span class="photo-small" id="img-210074-0" title="Lobby" alt="Lobby" data-big-src="https://photos.hotelbeds.com/giata/bigger/21/210074/210074a_hb_l_001.jpg" style="background-image: url('https://photos.hotelbeds.com/giata/21/210074/210074a_hb_l_001.jpg')"></span>
                                                </div>
                                                <div class="">
                                                    <span class="photo-small" id="img-210074-1" title="General view" alt="General view" data-big-src="https://photos.hotelbeds.com/giata/bigger/21/210074/210074a_hb_a_001.jpg" style="background-image: url('https://photos.hotelbeds.com/giata/21/210074/210074a_hb_a_001.jpg')"></span>
                                                </div>
                                                <div class="hovered">
                                                    <span class="photo-small" id="img-210074-2" title="Room" alt="Room" data-big-src="https://photos.hotelbeds.com/giata/bigger/21/210074/210074a_hb_w_001.jpg" style="background-image: url('https://photos.hotelbeds.com/giata/21/210074/210074a_hb_w_001.jpg')"></span>
                                                </div>
                                                <div class="">
                                                    <span class="photo-small" id="img-210074-3" title="Pool" alt="Pool" data-big-src="https://photos.hotelbeds.com/giata/bigger/21/210074/210074a_hb_p_001.jpg" style="background-image: url('https://photos.hotelbeds.com/giata/21/210074/210074a_hb_p_001.jpg')"></span>
                                                </div>
                                                <div class="">
                                                    <span class="photo-small" id="img-210074-4" title="Restaurant" alt="Restaurant" data-big-src="https://photos.hotelbeds.com/giata/bigger/21/210074/210074a_hb_r_001.jpg" style="background-image: url('https://photos.hotelbeds.com/giata/21/210074/210074a_hb_r_001.jpg')"></span>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>

                                </article>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 is-hide description-{{ $hotel['id'] }}">
                <div class="px-10 py-10 border-light">
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
