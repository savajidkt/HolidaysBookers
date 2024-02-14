@if (count($hotelRooms) > 0)
    @foreach ($hotelRooms as $key => $room)
        <div class="col-12">
            <div class="col-12 bg-blue-2 show-data-hb-list">
                <div class="tb even cebra_gray htl-active">
                    <div class="room-type-col td-left">
                        <div class="divAvailRoom">
                            <div id="dialog-room-info-973236-SUI-ST-agencia" class="roomextrainfo hidden">
                                <div class="newSpinner"></div><br>
                            </div>
                            <div class="show-hide-list">
                                <a class="magnifier" data-type="agencia" data-hotel-code="973236"
                                data-room-title="{{ $room['room_type'] }}" data-room-code="SUI"
                                data-room-characteristic="ST" data-load-ajax="true">
                                {{ $room['room_type'] }}
                            </a>                           
                            <p>{{ $room['room_title_with_child'] }}</p> 
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="main-htl_list">  
                    <div class="hotal-room-list">
                    @if (is_array($room['room_price']) && count($room['room_price']) > 0)
                        @foreach ($room['room_price'] as $pricekey => $priceroom)
                                @php
                                    $bookingParam = [];
                                    $bookingParam = [
                                        'is_type' => 'hotel',
                                        'hotel_id' => isset($room['hotel_id']) ? $room['hotel_id'] : '',
                                        'room_id' => isset($room['room_id']) ? $room['room_id'] : '',
                                        'price_id' => isset($priceroom['price_id']) ? $priceroom['price_id'] : '',
                                        'adult' => isset($room['room_adults']) ? $room['room_adults'] : 0,
                                        'child' => isset($room['room_childs']) ? $room['room_childs'] : 0,
                                        'room_child_age' => isset($room['room_child_age']) ? $room['room_child_age'] : '',
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
                                    $offlineRoom = getRoomDetailsByRoomID($room['room_id']);
                                @endphp
                                <div class="item-line add-border">
                                <div class="board-col ">
                                    <div class="percentage-col">
                                        <div id="disporoomboard_973236_0" class="board-shortname generic-tooltip"
                                            data-tooltip-content="{{ $priceroom['meal_plan'] }}">
                                            {{ $priceroom['meal_plan_short'] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="hb-add-border">
                                    <hr>
                                    
                                    <div class="hb-form-serviceadd">
                                        <div class="sub-hb-htl-list">
                                         <div class="tooltip-trigger-popup">
                                           @if($offlineRoom->price[0]->cancelation_policy=='non_refundeble')                                            
                                             <div class="tooltip -top px-30 h-50">
                                                <i class="fa fa-ban" aria-hidden="true"></i> Non refundable
                                                <div class="tooltip__content">Non refundable</div>
                                              </div>
                                            @endif
                                            @if($offlineRoom->price[0]->cancelation_policy=='refundeble')
                                                @php
                                                $cancellatoin = RoomWiseCancellationPolicy($offlineRoom->price[0],  $bookingParam['search_from']);
                                                    //echo '<pre>';
                                                    //print_r($cancellatoin);
                                                @endphp
                                                <div class="tooltip -top px-30 h-50">
                                                    @if($cancellatoin['free'])
                                                    <i class="fa fa-ban" aria-hidden="true"></i>Free Cancellation unit <p>{{ $cancellatoin['free'] }}</p>
                                                    @else
                                                    <i class="fa fa-ban" aria-hidden="true"></i>Non refundable
                                                    @endif 
                                                  
                                                    <div class="tooltip__content">Cancellation Charges<br>
                                                        @if(isset($cancellatoin['charge']))
                                                            @foreach ($cancellatoin['charge'] as $cancel )
                                                                {{ $cancel['after'] }}  {{ $cancel['charge'] }} <br>
                                                            @endforeach
                                                        @endif
                                                        Date and time is calculated based on local time of destination.
                                                    </div>
                                                    
                                                    
                                                </div>
                                            @endif
                                         </div>
                                            <div class="hb-table__info__features">
                                                <div class="hb-ng-star-inserted">
                                                   <span class="hb-packaging__text"> Product for packaging </span>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="sub-hb-htl-list">
                                        <div class="total-price-col dispo-calendar ">
                                            <div class="avail-price">
                                                <span>
                                                    {{ getNumberWithCommaGlobalCurrency($priceroom['finalAmount']) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="item-action-col">
                                            
    
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
                                            
                                            <button type="button" data-extra="{{ selectRoomBooking($bookingParam, true) }}"
                                                class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5 SelectRoomBook">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                                                    <path
                                                        d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                                                </svg>
                                                <span class="icons">Add</span>
                                                <div class="fa fa-spinner fa-spin ml-15" style="display: none;"></div>
                                            </button>
    
    
                                        </div>
                                     </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
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

<script>
    $(document).ready(function() {
        $('.tb.even.cebra_gray.htl-active').click(function() {  
            var relatedDiv = $(this).next('.main-htl_list');    
            relatedDiv.toggle();
           $(this).find('.show-hide-list').toggleClass('new-activ-rom');
        });
    });
</script>
