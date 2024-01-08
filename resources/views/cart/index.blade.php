@extends('layouts.app')
@section('page_title', 'Cart')
@section('content')
    <style>
        .roomGrid__grid {
            grid-template-columns: 180px auto 0px;
        }

        .border-right-px {
            border-right: 1px solid #dadada;
        }

        .myDelete {
            position: relative;
        }

        .pull-right.deleteCart {
            position: absolute;
            right: 14px;
            top: 10px;

            text-align: center;
            padding: 0 5px;

        }

        ul.inline-block li {
            display: inline-block;
        }
    </style>
    @php
        $serviceSection = '';
        $serviceSectionLeft = '';
        $serviceSectionAMT = 0;
    @endphp
    <section id="rooms" class="pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="row pb-20">
                    <div class="col-auto">
                        <h1><span class="fa fa-shopping-cart"></span> Cart</h1>
                        <h3 class="text-22 fw-500">{{ count($bookingCartArr) > 0 ? count($bookingCartArr) : 0 }} products
                            added to the cart</h3>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-8">

                    @if (count($bookingCartArr) > 0)
                        @foreach ($bookingCartArr as $bo_key => $bo_value)
                            @if ($bo_key == 'hotel')
                                @foreach ($bo_value as $key => $value)
                            @php
                                $offlineRoom = getRoomDetailsByRoomID($value['room_id']);
                                $hotelsDetails = $hotelListingRepository->hotelDetailsArr($value['hotel_id']);
                                
                            @endphp
                            @if (count($hotelsDetails) > 0 && count($hotelsDetails['hotel']) > 0)
                                @php
                               
                                    $hotelsRoomDetails = $hotelsDetails['roomDetails'];
                                    $hotelsDetails = $hotelsDetails['hotel'];
                                    $serviceSection .= '<li class="text-14 border-bottom-light mt-5 ">' . $hotelsDetails['hotel_name'] .'<br>'.$offlineRoom->roomtype->room_type . '<span class="pull-right">' . getNumberWithCommaGlobalCurrency($value['finalAmount']) . '</span></li>';
                                    $serviceSectionLeft .= '<li class="text-14"><i class="fa fa-bed"></i> ' . $hotelsDetails['hotel_name'].'<br>'.$offlineRoom->roomtype->room_type . ' <span class="pull-right"> ' . getNumberWithCommaGlobalCurrency($value['finalAmount']) . ' <a href="javascript:void(0);" data-hotel-id="' . $value['hotel_id'] . '" data-hotel-room-id="' . $value['room_id'] . '" class="removeHotel"><i class="fa fa-times text-danger"></i></a></span></li>';
                                    $serviceSectionAMT = $serviceSectionAMT + $value['finalAmount'];
                                @endphp

                                <div class="border-light rounded-4 px-30 py-30 sm:px-20 sm:py-20 mb-30 myDelete">

                                    <div class="row y-gap-20">
                                        <div class="col-12">
                                            <div class="roomGrid">
                                                <div class="roomGrid__grid">
                                                    <div>
                                                        <div class="ratio ratio-1:1">
                                                            @if (strlen($hotelsDetails['hotel_image_location']) > 0)
                                                                <img class="img-ratio rounded-4"
                                                                    src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['id'] . '/' . $hotelsDetails['hotel_image_location'])) }}"
                                                                    alt="{{ $hotelsDetails['hotel_name'] }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="y-gap-30">
                                                        <div class="row">
                                                            <div class="text-15 fw-500 mb-10">
                                                                        <i class="fa fa-bed"></i>
                                                                        {{ $hotelsDetails['hotel_name'] }}
                                                                <div class="pull-right deleteCart">
                                                                    <a href="javascript:void(0);"
                                                                        data-hotel-id="{{ $value['hotel_id'] }}"
                                                                        data-hotel-room-id="{{ $value['room_id'] }}"
                                                                        class="removeHotel"> <i
                                                                            class="fa fa-times fa-2x text-danger"></i>
                                                                        Delete Product</a>
                                                                </div>
                                                            </div>
                                                            <div class="y-gap-8">
                                                                <div class="d-flex items-center">
                                                                    @if ($hotelsDetails['category'] > 0)
                                                                        <div class="d-flex x-gap-5 pb-10">
                                                                            @for ($i = 1; $i <= $hotelsDetails['category']; $i++)
                                                                                <i
                                                                                    class="icon-star text-10 text-yellow-1"></i>
                                                                            @endfor
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                                <div class="d-flex items-center">
                                                                    <i class="icon-location-pin text-12 mr-10"></i>
                                                                    <div class="text-14 lh-15 mt-5">
                                                                        {{ $hotelsDetails['hotel_address'] }}</div>
                                                                </div>
                                                                <div class="d-flex items-center">
                                                                    <i class="icon-calendar-2 text-12 mr-10"></i>
                                                                    <div class="text-14 lh-15 mt-5">From                                                                        
                                                                        {{ dateFormat( str_replace('/', '-', $value['search_from']),'d M, Y'); }}                                                                        
                                                                        To
                                                                        {{ dateFormat( str_replace('/', '-', $value['search_to']),'d M, Y'); }}                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="border-top-light mt-30 mb-20"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="row pt-10">
                                                <div class="text-20 fw-500 mb-10">
                                                    Remarks
                                                </div>
                                                        <div class="text-15">Check-in hour from 14:00. Car park Yes with
                                                            charges.
                                                            Car park YES (with additional debit notes). Check-in hour 14:00
                                                            -
                                                        </div>
                                            </div> --}}
                                            {{-- <div class="row pt-10">
                                                <div class="text-20 fw-500 mb-10">
                                                    Rate Information
                                                </div>
                                                        <div class="text-15">Please note that these rates don't allow
                                                            modifications,
                                                    therefore you would need to cancel and create a new booking.
                                                    Cancellation charges apply as per cancellation policy. </div>
                                            </div> --}}
                                            <div class="border-top-light mt-30 mb-20"></div>
                                            <div class="row pt-10">
                                                <div class="fw-500 mb-10">

                                                    {{ $offlineRoom->roomtype->room_type }}
                                                    <div class="pull-right">
                                                                {{ getNumberWithCommaGlobalCurrency($value['finalAmount']) }}
                                                            </div>
                                                </div>
                                            </div>
                                            <div class="row pt-10">
                                                <div class="text-15 fw-500 mb-10">Cancellation fees</div>
                                                <div class="col-6 border-right-px">
                                                    <div class="y-gap-8">
                                                        <?php if($offlineRoom->price[0]->cancelation_policy != "refundeble"){ ?>
                                                            <div class="items-center">
                                                                <div class="text-13 pull-left">Non refundable</div>
                                                            </div>
                                                            <?php } else { ?>
                                                                <?php echo CancellationFeesCalculated($offlineRoom->price[0],  $value['search_from']); ?>
                                                            <?php } ?>
                                                        
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-12">Date and time are calculated based on local
                                                        time in the destination. In case of no-show, different fees
                                                        will apply. Please refer to our T&C.</div>
                                                </div>
                                            </div>
                                            <div class="px-20 py-20 bg-blue-2 rounded-4 mt-20">
                                                <div class="row y-gap-5 justify-between">
                                                    <div class="col-auto">
                                                        <div class="text-18 lh-13 fw-500">Price</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="text-18 lh-13 fw-500">
                                                            {{ getNumberWithCommaGlobalCurrency($value['finalAmount']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                        @endforeach
                    @endif
                    <div class="border-light rounded-4 px-30 py-30 sm:px-20 sm:py-20 mb-30 myDelete">
                        <div class="row y-gap-20">
                            <div class="col-12">
                                <div class="">
                                    <ul class=" y-gap-4 pt-5">
                                        <li class="text-14 border-bottom-light mt-5 mb-5 fw-500">Services<span
                                                class="pull-right fw-500">Net Price</span></li>
                                        @php
                                            echo $serviceSection;
                                        @endphp
                                        <li class="text-14 border-bottom-light mt-5 mb-5 fw-500">Total<span
                                                class="pull-right fw-500">{{ getNumberWithCommaGlobalCurrency($serviceSectionAMT) }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row y-gap-20">
                            <div class="col-12">
                                <div class="d-flex pull-right">
                                    <div class="text-15 lh-15 text-light-1 fw-500 ml-10"> Total net price to pay to Holidays
                                        Bookers: <span
                                            class="text-20">{{ getNumberWithCommaGlobalCurrency($serviceSectionAMT) }}<span>
                                    </div>
                                </div>
                            </div>
                            
                            <ul class="y-gap-4 pt-5 text-right inline-block">
                                <li class="text-14 removeCart">
                                    <a href="javascript:void(0);" class="removeCart"> <i
                                            class="fa fa-times fa-2x text-danger"></i> Empty shopping cart</a>
                                </li>
                                {{-- <li class="text-14"><a href="javascript:void(0);" class="saveQuote"><i
                                            class="fa fa-bookmark fa-2x text-blue-1"></i> Save as quote </a></li> --}}
                                <li class="text-14"><a class="button -white bg-blue-1 px-30 fw-400 text-14 h-50 text-white"
                                        href="{{ route('checkout.index') }}">
                                        Process to checkout
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-4">
                    <div class="ml-80 lg:ml-40 md:ml-0">
                        <div class="px-30 py-30 border-light rounded-4">
                            {{-- <div class="row x-gap-15 y-gap-20">
                                <div class="col bg-blue-2 rounded-4 y-gap-30">
                                    <div class="lh-17 fw-500"></div>
                                </div>
                            </div>
                            <div class="border-top-light mt-30 mb-20"></div> --}}

                            <div class="">
                                <ul class=" y-gap-4 pt-5">
                                    @php
                                        echo $serviceSectionLeft;
                                    @endphp
                                </ul>
                            </div>

                            <div class="border-top-light mt-30 mb-20"></div>

                            <div class="row y-gap-20 justify-between items-center">
                                <div class="">
                                    <div class="text-15 fw-500">Booking total: <span
                                            class="pull-right text-20">{{ getNumberWithCommaGlobalCurrency($serviceSectionAMT) }}</span>
                                    </div>
                                    <a class="button -white bg-blue-1 px-30 fw-400 text-14 h-50 text-white mt-20"
                                        href="{{ route('checkout.index') }}">
                                        Process to checkout
                                    </a>
                                </div>
                                <div class="">
                                    <ul class=" y-gap-4 pt-5 text-right">
                                        <li class="text-14"><a href="javascript:void(0);" class="removeCart"> <i
                                                    class="fa fa-times fa-2x text-danger"></i> Empty shopping cart</a></li>
                                        {{-- <li class="text-14"><a href="javascript:void(0);" class="saveQuote"><i
                                                    class="fa fa-bookmark fa-2x text-blue-1"></i> Save as quote</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-script')
    <script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/front/js/Cart.js') }}"></script>
    <script src="{{ asset('assets/front/js/search-form/Currencies.js') }}"></script>    
    <script type="text/javascript">
        var moduleConfig = {
            removeHotel: "{!! route('remove-cart-hotel') !!}",
            saveQuote: "{!! route('save-cart-quote') !!}",
            removeCart: "{!! route('remove-cart') !!}",
        };
    </script>
@endsection
