@if ($hotelRooms->count() > 0)

    @foreach ($hotelRooms as $room)
        <div class="row bg-blue-2 mt-20">
            <h3 class="text-18 fw-500 mb-10 mt-10">
                @if (isset($room->roomtype->room_type))
                    {{ $room->roomtype->room_type }}
                @endif
            </h3>
            <div class="col-xl-auto">
                <div class="">
                    <div class="text-18 fw-500 mt-10">
                        @php
                            if (isset($room->mealplan->name)) {
                                $string = $room->mealplan->name;
                                preg_match_all('/\b\w/', $string, $matches);
                                echo implode('', $matches[0]);
                            } else {
                                echo "-";
                            }
                        @endphp
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="bg-dark rounded-4 px-30 py-30 mt-10">
                    @if ($room->price->count() > 0)
                        @foreach ($room->price as $price)
                        
                            <div class="row y-gap-30 border-top-light">
                                <div class="col-lg col-md-6">
                                    <ul class="text-15 pt-10">
                                        <li class="d-flex items-center">
                                            <i class="icon-check text-10 mr-20"></i>
                                            Towels
                                        </li>
                                        <li class="d-flex items-center">
                                            <i class="icon-check text-10 mr-20"></i>
                                            Bath or shower
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-auto col-md-6 border-left-light lg:border-none">
                                    <div class="px-40 lg:px-0">
                                        <div class="text-12 text-red-2">2 Left!</div>
                                        <div class="text-12 text-red-2"><del>{{ numberFormat($price->price_p_n_single_adult, $price->currency->code) }}</del></div>
                                        <div class="text-15 fw-500 ">{{ numberFormat($price->price_p_n_single_adult, $price->currency->code) }}</div>
                                    </div>
                                </div>
                                <div
                                    class="col-lg-auto col-md-6 border-left-light lg:border-none text-right lg:text-left">
                                    <div class="pl-40 lg:pl-0">

                                        <a href="#" class="button h-50 px-35 -dark-1 bg-blue-1 text-white mt-10">
                                            Add <div class="icon-arrow-top-right ml-15"></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="px-10 py-10 border-light">
        <div class="d-flex items-center">
            <div class="button text-dark-1">No room found!</div>
        </div>
    </div>
@endif
