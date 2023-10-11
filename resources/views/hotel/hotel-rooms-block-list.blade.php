<style>
    .hotel-pricing .even.cebra_gray {
        background: #f3f5f5;
        border-top: 1px solid #bcc7c4;
    }

    .hotel-pricing .even {
        width: 100%;
    }

    .hotel-pricing .tb {
        display: table;
    }

    .hotel-pricing .even .room-type-col.td-left {
        display: table-cell;
        vertical-align: middle;
        padding: 6px 10px 8px 10px;
    }

    ..hotel-pricing .even .room-type-col {
        position: relative;
        top: 0;
    }

    .hotel-pricing .even .item-pay-at.td-right {
        display: table-cell;
        text-align: right;
        padding: 10px 30px 10px 10px;
    }

    .hotel-pricing .even .item-pay-at {
        position: relative;
        top: 0;
    }
</style>

@if (count($hotelRooms) > 0)
    @foreach ($hotelRooms as $key => $room)
        <?php
        
        //dd($hotelRooms);
        ?>
        <div class="row bg-blue-2 mt-20">
            <div>
                <div class="tb even cebra_gray">
                    <div class="room-type-col td-left">
                        <div class="divAvailRoom">
                            <div id="dialog-room-info-973236-SUI-ST-agencia" class="roomextrainfo hidden">
                                <div class="newSpinner"></div><br>
                            </div>
                            <a class="magnifier" data-type="agencia" data-hotel-code="973236"
                                data-room-title="{{ $room['room_type'] }}" data-room-code="SUI"
                                data-room-characteristic="ST" data-load-ajax="true">
                                {{ $room['room_type'] }}
                            </a>
                        </div>
                    </div>
                </div>
                @if (is_array($room['room_price']) && count($room['room_price']) > 0)
                    @foreach ($room['room_price'] as $pricekey => $priceroom)
                        <div class="item-line add-border">
                            <div class="board-col ">
                                <div class="percentage-col">
                                    <div id="disporoomboard_973236_0" class="board-shortname generic-tooltip"
                                        data-tooltip-content="{{ $priceroom['meal_plan'] }}">
                                        {{ $priceroom['meal_plan_short'] }}
                                    </div>
                                </div>
                            </div>
                            <div
                                class="QA_itempricingdetail accommodation-pricing-detail item-pricing-detail add-border">
                                <div class="item-pricing-detail-border form-serviceadd">
                                    <div class="total-price-col dispo-calendar ">
                                        <div class="avail-price">
                                            <span>
                                                {{ numberFormat($priceroom['finalAmount'], $priceroom['currency']) }}
                                            </span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="item-action-col">

                                        @php
                                            
                                            $bookingParam = [];
                                            $bookingParam = [
                                                'is_type' => 'hotel',
                                                'hotel_id' => isset($room['hotel_id']) ? $room['hotel_id'] : '',
                                                'room_id' => isset($room['room_id']) ? $room['room_id'] : '',
                                                'price_id' => isset($priceroom['price_id']) ? $priceroom['price_id'] : '',
                                                'adult' => getSearchCookies('searchGuestAdultCount') ? getSearchCookies('searchGuestAdultCount') : 0,
                                                'child' => getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0,
                                                'room' => getSearchCookies('searchGuestRoomCount') ? getSearchCookies('searchGuestRoomCount') : 0,
                                            
                                                'city_id' => isset($requestParam['filterObjParamCityID']) ? $requestParam['filterObjParamCityID'] : '',
                                                'search_from' => isset($requestParam['filterObjParamStartDate']) ? $requestParam['filterObjParamStartDate'] : '',
                                                'search_to' => isset($requestParam['filterObjParamEndDate']) ? $requestParam['filterObjParamEndDate'] : '',
                                            
                                                'originAmount' => isset($priceroom['originAmount']) ? numberFormat($priceroom['originAmount']) : '',
                                                'productMarkupAmount' => isset($priceroom['adminproductMarkupAmount']) ? numberFormat($priceroom['adminproductMarkupAmount']) : '',
                                                'agentMarkupAmount' => isset($priceroom['adminagentMarkupAmount']) ? numberFormat($priceroom['adminagentMarkupAmount']) : '',
                                                'agentGlobalMarkupAmount' => isset($priceroom['agentMarkupAmount']) ? numberFormat($priceroom['agentMarkupAmount']) : '',
                                                'finalAmount' => isset($priceroom['finalAmount']) ? numberFormat($priceroom['finalAmount']) : '',
                                            ];
                                            $isAddedCart = false;
                                        @endphp

                                        @if (is_array($bookingCartArr) && count($bookingCartArr))
                                            @foreach ($bookingCartArr as $bo_key => $bo_value)
                                                @if ($bo_key == 'hotel')
                                                    @foreach ($bo_value as $key => $value)
                                                        @if ($value['hotel_id'] == $room['hotel_id'] && $value['room_id'] == $room['room_id'])
                                                            @php
                                                                $isAddedCart = true;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif

                                        @if ($isAddedCart)
                                            <button type="button"
                                                class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5">
                                                <span class="icons">Added</span>
                                    </div>
                                    </button>
                                @else
                                    <button type="button" data-extra="{{ selectRoomBooking($bookingParam, true) }}"
                                        class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5 SelectRoomBook">
                                        <span class="icons">Add</span>
                                        <div class="icon-arrow-top-right ml-15"></div>
                                        <div class="fa fa-spinner fa-spin ml-15" style="display: none;"></div>
                                    </button>
                    @endif


            </div>
        </div>

        </div>
        </div>
    @endforeach
@endif
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
