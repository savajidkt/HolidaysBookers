@if ($hotelList->count() > 0)
    @foreach ($hotelList as $hotel)
        <div class="col-12 topScroll" data-hot="{{ $hotel->id }}">
            <div class="border-top-light pt-30">
                <div class="row x-gap-20 y-gap-20">
                    <div class="col-md-auto">
                        <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4">
                            <div class="cardImage__content">
                                @if (strlen($hotel->hotel_image_location) > 0)
                                    <img class="rounded-4 col-12"
                                        src="{{ url(Storage::url('app/upload/Hotel/' . $hotel->id . '/' . $hotel->hotel_image_location)) }}"
                                        alt="{{ $hotel->hotel_name }}">
                                @else
                                    <img class="rounded-4 col-12" src="{{ asset('assets/front') }}/img/hotel/1.png"
                                        alt="{{ $hotel->hotel_name }}">
                                @endif
                            </div>
                            <div class="cardImage__wishlist">
                                <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                    <i class="icon-heart text-12"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <h3 class="text-18 lh-16 fw-500">
                            {{ $hotel->hotel_name }}<br class="lg:d-none">
                            {{ $hotel->property->property_name }},
                            {{ $hotel->country->name }}
                            @if ($hotel->category)
                                <div class="d-inline-block ml-10">
                                    @for ($i = 1; $i <= $hotel->category; $i++)
                                        <i class="icon-star text-10 text-yellow-2"></i>
                                    @endfor
                                </div>
                            @endif
                        </h3>
                        <div class="row x-gap-10 y-gap-10 items-center pt-10">
                            <div class="col-auto">
                                <p class="text-14">Westminster Borough, London</p>
                            </div>
                            <div class="col-auto">
                                <button data-x-click="mapFilter" class="d-block text-14 text-blue-1 underline">Show on
                                    map</button>
                            </div>
                            <div class="col-auto">
                                <div class="size-3 rounded-full bg-light-1"></div>
                            </div>
                            <div class="col-auto">
                                <p class="text-14">2 km to city center</p>
                            </div>
                        </div>
                        <div class="text-14 lh-15 mt-20">
                            <div class="fw-500">King Room</div>
                            <div class="text-light-1">1 extra-large double bed</div>
                        </div>
                        <div class="text-14 text-green-2 lh-15 mt-10">
                            <div class="fw-500">Free cancellation</div>
                            <div class="">You can cancel later, so lock in this great price
                                today.
                            </div>
                        </div>
                        @if ($hotel->hotelamenity->count() > 0)
                            <div class="row x-gap-10 y-gap-10 pt-20">
                                @foreach ($hotel->hotelamenity as $amenity)
                                    <div class="col-auto">
                                        <div class="border-light rounded-100 py-5 px-20 text-14 lh-14">
                                            {{ $amenity->amenity_name }}
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
                                <div class="text-14 lh-14 text-light-1">3,014 reviews</div>
                            </div>
                            <div class="col-auto">
                                <div class="flex-center text-white fw-600 text-14 size-40 rounded-4 bg-blue-1">
                                    {{ $hotel->hotel_review }}</div>
                            </div>
                        </div>
                        <div class="">
                            <div class="text-14 text-light-1 mt-50 md:mt-20">8 nights, 2 adult
                            </div>
                            <div class="text-22 lh-12 fw-600 mt-5">US$72</div>
                            <div class="text-14 text-light-1 mt-5">+US$828 taxes and charges</div>
                            <a href="#" class="button -md -dark-1 bg-blue-1 text-white mt-24">
                                See Availability <div class="icon-arrow-top-right ml-15"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
{{-- {{ $hotelList->render() }} --}}
{{ $hotelList->withQueryString()->links('common.pagination', ['hotelCount' => $hotelCount]) }}
