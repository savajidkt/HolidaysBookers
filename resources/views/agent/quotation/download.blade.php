@php
    $serviceSection = '';
    $serviceSectionLeft = '';
    $serviceSectionAMT = 0;
@endphp
<html>

<head>

    <head>
        <link rel="stylesheet" href="http://localhost/holidays-bookers/public/assets/front/css/vendors.css">
        <link rel="stylesheet" href="http://localhost/holidays-bookers/public/assets/front/css/main.css">
        <style>
            .help-block-error {
                color: #EA5455;
            }
        </style>
    </head>

<body>
    <div class="dashboard" data-x="dashboard" data-x-toggle="-is-sidebar-open">
        <div class="">
            <div class="dashboard__content bg-light-2">
                <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
                    <div class="col-12">
                        <div class="row x-gap-20 y-gap-30">
                            @if ($quoteData)
                                @if (count($quoteData->quote_hotel_rooms) > 0)
                                    @foreach ($quoteData->quote_hotel_rooms as $key => $value)
                                        @php
                                            
                                            $offlineRoom = getRoomDetailsByRoomID($value->room_id);
                                            $hotelsDetails = $hotelListingRepository->hotelDetailsArr($value->hotel_id);
                                            
                                        @endphp
                                        @if (count($hotelsDetails) > 0 && count($hotelsDetails['hotel']) > 0)
                                            @php
                                                $hotelsRoomDetails = $hotelsDetails['roomDetails'];
                                                $hotelsDetails = $hotelsDetails['hotel'];
                                                $serviceSection .= '<li class="text-14 border-bottom-light mt-5 ">' . $hotelsDetails['hotel_name'] . '<span class="pull-right">' . numberFormat($value['finalAmount'], globalCurrency()) . '</span></li>';
                                                $serviceSectionLeft .= '<li class="text-14"><i class="fa fa-bed"></i> ' . $hotelsDetails['hotel_name'] . ' <span class="pull-right"> ' . numberFormat($value['finalAmount'], globalCurrency()) . ' <a href="javascript:void(0);" data-hotel-id="' . $value['hotel_id'] . '" data-hotel-room-id="' . $value['room_id'] . '" class="removeHotel"><i class="fa fa-times text-danger"></i></a></span></li>';
                                                $serviceSectionAMT = $serviceSectionAMT + $value['price'] + $value['extra_markup_price'];                                                
                                            @endphp
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div
                                                                class="border-light rounded-4 px-30 py-30 sm:px-20 sm:py-20 mb-30">

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
                                                                                        <div
                                                                                            class="text-15 fw-500 mb-10">
                                                                                            <i class="fa fa-bed"></i>
                                                                                            {{ $hotelsDetails['hotel_name'] }}

                                                                                        </div>
                                                                                        <div class="y-gap-8">
                                                                                            <div
                                                                                                class="d-flex items-center">
                                                                                                @if ($hotelsDetails['category'] > 0)
                                                                                                    <div
                                                                                                        class="d-flex x-gap-5 pb-10">
                                                                                                        @for ($i = 1; $i <= $hotelsDetails['category']; $i++)
                                                                                                            <i
                                                                                                                class="icon-star text-10 text-yellow-1"></i>
                                                                                                        @endfor
                                                                                                    </div>
                                                                                                @endif

                                                                                            </div>
                                                                                            <div
                                                                                                class="d-flex items-center">
                                                                                                <i
                                                                                                    class="icon-location-pin text-12 mr-10"></i>
                                                                                                <div
                                                                                                    class="text-14 lh-15 mt-5">
                                                                                                    {{ $hotelsDetails['hotel_address'] }}
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="d-flex items-center">
                                                                                                <i
                                                                                                    class="icon-calendar-2 text-12 mr-10"></i>
                                                                                                <div
                                                                                                    class="text-14 lh-15 mt-5">
                                                                                                    From
                                                                                                    {{ date('d M, Y', strtotime(getSearchCookies('search_from'))) }}

                                                                                                    To
                                                                                                    {{ date('d M, Y', strtotime(getSearchCookies('search_to'))) }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="border-top-light mt-30 mb-20">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row pt-10">
                                                                            <div class="text-20 fw-500 mb-10">
                                                                                Remarks
                                                                            </div>
                                                                            <div class="text-15">Lorem Ipsum is simply
                                                                                dummy
                                                                                text of the printing and typesetting
                                                                            </div>
                                                                        </div>
                                                                        <div class="row pt-10">
                                                                            <div class="text-20 fw-500 mb-10">
                                                                                Rate Information
                                                                            </div>
                                                                            <div class="text-15">Lorem Ipsum is simply
                                                                                dummy
                                                                                text of the printing and typesetting
                                                                            </div>
                                                                        </div>
                                                                        <div class="border-top-light mt-30 mb-20"></div>
                                                                        <div class="row pt-10">
                                                                            <div class="fw-500 mb-10">

                                                                                {{ $offlineRoom->roomtype->room_type }}

                                                                            </div>
                                                                        </div>
                                                                        <div class="row pt-10">
                                                                            <div class="text-15 fw-500 mb-10">
                                                                                Cancellation
                                                                                fees
                                                                            </div>
                                                                            <div class="col-6 border-right-px">
                                                                                <div class="y-gap-8">
                                                                                    <div
                                                                                        class="items-center text-green-2">
                                                                                        <div class="text-13 pull-left">
                                                                                            Lorem
                                                                                            Ipsum Until
                                                                                            23:58 PM on
                                                                                            15/08/2023
                                                                                        </div>
                                                                                        <div class="text-13 pull-right">
                                                                                            <i
                                                                                                class="fa fa-check-circle text-12"></i>
                                                                                            Free
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="items-center">
                                                                                        <div class="text-13 pull-left">
                                                                                            After
                                                                                            23:59 PM on
                                                                                            15/08/2023
                                                                                        </div>
                                                                                        <div
                                                                                            class="text-13 pull-right text-danger">
                                                                                            15,831.96
                                                                                            Rs</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="text-12">Lorem Ipsum is
                                                                                    simply
                                                                                    dummy text of the printing and
                                                                                    typesetting
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="px-20 py-20 bg-blue-2 rounded-4 mt-20">
                                                                            <div class="row y-gap-5 justify-between">
                                                                                <div class="col-auto">
                                                                                    <div class="text-18 lh-13 fw-500">
                                                                                        Price
                                                                                        of service
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <div class="text-18 lh-13 fw-500">
                                                                                        {{ numberFormat($value['price'] + $value['extra_markup_price'], globalCurrency()) }}
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
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="border-light rounded-4 px-30 py-30 sm:px-20 sm:py-20 mb-30 myDelete">

                                        <div class="row y-gap-20">
                                            <div class="col-12">
                                                <div class="d-flex pull-right">
                                                    <div class="text-15 lh-15 text-light-1 fw-500 ml-10"> Total: <span
                                                            class="text-20">{{ numberFormat($serviceSectionAMT, globalCurrency()) }}<span>
                                                            </span></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
