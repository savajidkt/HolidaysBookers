@if (count($hotelRooms) > 0)

    @foreach ($hotelRooms as $room)
        <div class="row bg-blue-2 mt-20">
            <h3 class="text-18 fw-500 mb-10 mt-10">
                {{ $room['room_type'] }}
            </h3>
           
            <div class="col-xl">
                <div class="bg-dark rounded-4 px-30 py-30 mt-10">
                    @if (count($room['room_price']) > 0)
                        @foreach ($room['room_price'] as $price)
                        
                            <div class="row y-gap-30 border-top-light">
                                <div class="col-md-2">
                                    <ul class="text-15 pt-10">
                                        <li class="d-flex items-center">
                                            <div class="col-xl-auto">
                                                <div class="">
                                                    <div class="text-18 fw-500 mt-10">
                                                        <div class="tooltip -top h-50">
                                                            <div class="tooltip__text">
                                                                <i
                                                                    class="input-icon field-icon icofont-ruler-compass-alt"></i>
                                                                <span>{{ $price['meal_plan_short'] }}</span>
                                                            </div>
                                                            <div class="tooltip__content">{{ $price['meal_plan'] }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </li>
                                      
                                    </ul>
                                </div>
                                <div class="col-lg col-md-6">
                                    <ul class="text-15 pt-10">
                                       
                                        @foreach ($room['room_facilities'] as $key => $facilities)
                                                        @if ($facilities['status'] == '0')
                                                        <li class="d-flex items-center">
                                                                <i class="icon-close text-12 mr-10"></i>
                                                                <div class="text-15">{{ $facilities['title'] }}
                                                                </div>
                                                            </li>
                                                        @else
                                                        <li class="d-flex items-center">
                                                                <i class="icon-check text-12 mr-10"></i>
                                                                <div class="text-15">{{ $facilities['title'] }}
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                        
                                    </ul>
                                </div>
                                <div class="col-lg-auto col-md-4 border-left-light lg:border-none">
                                    <div class="px-40 lg:px-0">
                                        {{-- <div class="text-12 text-red-2">2 Left! (Static)</div> --}}
                                        <div class="text-12 text-red-2"><del> {{ $price['currency']}} {{ $price['market_price']}}</del></div>
                                        <div class="text-15 fw-500 ">{{ $price['currency']}} {{ $price['total_price']}}</div><span class="text-red-2">Per night/person</span>
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
