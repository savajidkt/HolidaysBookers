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
.hotel-pricing .even .room-type-col.td-left{
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
    @foreach ($hotelRooms as $room)
        <div class="row bg-blue-2 mt-20">
            <div>
                <div class="tb even cebra_gray">
                    <div class="room-type-col td-left">
                            <div class="divAvailRoom">
                                    <div id="dialog-room-info-973236-SUI-ST-agencia" class="roomextrainfo hidden">
                                        <div class="newSpinner"></div><br>
                                    </div>
                                    
                                    <a class="magnifier" data-type="agencia" data-hotel-code="973236" data-room-title="Suite standard" data-room-code="SUI" data-room-characteristic="ST" data-load-ajax="true">
                                        Suite standard
                                    </a>
                            </div>
                    </div>
        
                    <div class="td-right item-pay-at">
                            <span class="paytypeagency">
                            Hotelbeds
                        </span>
                    </div>
                </div>
                        <div class="item-line add-border">
                                        <div class="board-col ">
                                                <div class="percentage-col">
                                                    <div id="disporoomboard_973236_0" class="board-shortname generic-tooltip" data-tooltip-content="ROOM ONLY">
                                                        RO
                                                    </div>
                                                </div>
                                        </div>
                                        <div rel="H_973236#C_NRF#P_073#T_UNKNOWN_B2BNRFCH#D_#E_N#O_N" class="QA_itempricingdetail accommodation-pricing-detail item-pricing-detail add-border">
                                            <div class="item-pricing-detail-border form-serviceadd">
                                    
                                                <div class="cancellationdate-col">
                                                    <div>
                                                        <div>
                                                                <div class="nomodification-col avail-promo custom-tooltip" data-id="hot973236_acc1_boo00" rel-tooltip="tooltip-cancellation-policies_hot973236_acc1_boo00" data-hasqtip="22">
                                                                        <span class="icon-coin"></span><span class="promo-name" data-tl="non-refundable">Non refundable</span>
                                                                </div>
                                                                <div class="hidden" id="tooltip-cancellation-policies_hot973236_acc1_boo00">
                                                                    <div class="cancellation-policies-tooltip">
                                                                        <div class="title">Cancellation Charges</div>
                                                                        <ul>
                                                                                <li>
                                                                                    11/06/2023, 23:59 PM <strong>17,849.76 Rs</strong>
                                                                                </li>
                                                                        </ul>
                                                                        <span>Date and time is calculated based on local time of destination.</span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                    
                                                </div>
                                    
                                                    <div class="promo-col avail-promo amenity"></div>
                                    
                                                <div class="total-price-col dispo-calendar ">
                                                                        <div class="avail-price">
                                                        <span data-roomtype="Suite standard#" data-roomprice="17,849.76 Rs#" data-room-occupancy="2#" data-multi-rooms="false" data-average-price="5949.92 Rs" data-day-price="5,949.92#5,949.92#5,949.92#" data-commission-pct="0" data-commission-price="0" data-net-price="17849.76" data-selling-price="17849.76" data-shortdate="Jun 11#Jun 12#Jun 13#Jun 14#Jun 15#Jun 16#Jun 17#Jun 18#" data-currency="Rs" class="calendarInfo">
                                                                 <span data-qa="room-price-text" id="currentprice_973236_00" class="current-price" data-tl="si-rate">
                                                                        17,849.76 Rs
                                                                </span>
                                                        </span>
                                    
                                    
                                    
                                                    </div>
                                                    <span class="exchanged-price" data-qa="exchanged-price"></span>
                                    
                                    
                                                </div>
                                    
                                                        <div class="item-action-col">
                                                            <form id="form-hot973236-acc1-boo00" class="mod-validable checkPurchaseCompat form_loading_dialog gildir" data-booking-modification="false" data-payment-type="agencia" data-hotel-code="973236" data-is-corporate="false" action="/serviceadd" method="post">
                                                                <button data-tl="  " type="submit" class="add-cart    pdf-hidden availability book-button agencia  no-external-hotel-room button-medium" data-qa="  external-hotel-room" name="accomodation">Add</button>
                                                                <input type="hidden" id="service-add-data-973236-RO-ST-SUI-IDB2B70-agencia-B2BNRFCH-17849_76-17849_76" name="serviceadd_data" value="{&quot;type&quot;:&quot;accommodation&quot;,&quot;data&quot;:{&quot;dataType&quot;:&quot;com.evo.api.resources.model.serviceadd.AccommodationServiceAddData&quot;,&quot;hotelAvailId&quot;:&quot;d07cd6c5-39d4-49e1-b825-f439cf580798|67|MTAuMjIyLjY2LjY3fDA=&quot;,&quot;availtoken&quot;:&quot;90aa184d-f1eb-4579-89da-5f57d969c11c&quot;,&quot;datefrom&quot;:&quot;20230613&quot;,&quot;dateto&quot;:&quot;20230616&quot;,&quot;hotelcode&quot;:&quot;973236&quot;,&quot;destinationcode&quot;:&quot;BAI&quot;,&quot;incomingoffice&quot;:&quot;325&quot;,&quot;contractname&quot;:&quot;ID_B2B_70&quot;,&quot;isprovider&quot;:&quot;Y&quot;,&quot;hotelname&quot;:&quot;Monolocale Resort Seminyak by Ini Vie Hospitality&quot;,&quot;typepayment&quot;:&quot;N&quot;,&quot;rooms&quot;:{&quot;2_0_0[]&quot;:{&quot;roominage&quot;:&quot;&quot;,&quot;roomcount&quot;:1,&quot;ratecode&quot;:&quot;B2BNRFCH&quot;,&quot;shrui&quot;:&quot;20230613|20230616|W|325|973236|SUI.ST|ID_B2B_70|RO|B2BNRFCH|1~2~0||N@06~A-SIC~~275197539~N~~~NRF~AF646C9372D24B2168655297530703PAIN0000114006700150824c45b9&quot;,&quot;roomadage&quot;:&quot;30-30&quot;,&quot;roomcharacteristic&quot;:&quot;ST&quot;,&quot;boardcode&quot;:&quot;RO&quot;,&quot;boardtype&quot;:&quot;SIMPLE&quot;,&quot;roomtypecode&quot;:&quot;SUI&quot;,&quot;roomchage&quot;:&quot;&quot;}},&quot;groupCode&quot;:&quot;GRUPO5&quot;,&quot;destinationSearchType&quot;:&quot;destinationSearch&quot;,&quot;establishmentType&quot;:&quot;H&quot;,&quot;isResident&quot;:&quot;N&quot;,&quot;s-room-price&quot;:&quot;17849.76&quot;},&quot;purchaseToken&quot;:null,&quot;extraInfo&quot;:null}" class="hotel-bt">
                                                                <input type="hidden" name="s-locata" value="">
                                                                <input type="hidden" id="hotel-name-form-hot973236-acc1-boo00" value="Monolocale Resort Seminyak by Ini Vie Hospitality">
                                                                <input type="hidden" id="hotel-room-form-hot973236-acc1-boo00" value="Suite standard">
                                                                <input type="hidden" id="hotel-reg-form-hot973236-acc1-boo00" value="ROOM ONLY" name="board-description">
                                                                <input type="hidden" id="hotel-rates-form-hot973236-acc1-boo00" value="8" name="rates-count">
                                                                <input type="hidden" id="hotel-position-form-hot973236-acc1-boo00" value="1" name="position">
                                                                <input type="hidden" id="SID" name="SID" value="385bc4e82c3b5ea0c27d9c39e9f9ca6e">
                                                                    <input type="hidden" name="tealeaf-results-source" value="ACC_AVAIL">
                                                            </form>
                                                        </div>
                                            </div>
                                    
                                        </div>
                        </div>
                        <div class="item-line add-border">
                                        <div class="board-col ">
                                                <div class="percentage-col">
                                                    <div id="disporoomboard_973236_1" class="board-shortname generic-tooltip" data-tooltip-content="BED AND BREAKFAST">
                                                        BB
                                                    </div>
                                                </div>
                                        </div>
                                        <div rel="H_973236#C_NRF#P_073#T_UNKNOWN_B2BNRFCH#D_#E_N#O_N" class="QA_itempricingdetail accommodation-pricing-detail item-pricing-detail add-border">
                                            <div class="item-pricing-detail-border form-serviceadd">
                                    
                                                <div class="cancellationdate-col">
                                                    <div>
                                                        <div>
                                                                <div class="nomodification-col avail-promo custom-tooltip" data-id="hot973236_acc1_boo10" rel-tooltip="tooltip-cancellation-policies_hot973236_acc1_boo10">
                                                                        <span class="icon-coin"></span><span class="promo-name" data-tl="non-refundable">Non refundable</span>
                                                                </div>
                                                                <div class="hidden" id="tooltip-cancellation-policies_hot973236_acc1_boo10">
                                                                    <div class="cancellation-policies-tooltip">
                                                                        <div class="title">Cancellation Charges</div>
                                                                        <ul>
                                                                                <li>
                                                                                    11/06/2023, 23:59 PM <strong>19,712.69 Rs</strong>
                                                                                </li>
                                                                        </ul>
                                                                        <span>Date and time is calculated based on local time of destination.</span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                    
                                                </div>
                                    
                                                    <div class="promo-col avail-promo amenity"></div>
                                    
                                                <div class="total-price-col dispo-calendar ">
                                                                        <div class="avail-price">
                                                        <span data-roomtype="Suite standard#" data-roomprice="19,712.69 Rs#" data-room-occupancy="2#" data-multi-rooms="false" data-average-price="6570.9 Rs" data-day-price="6,570.90#6,570.90#6,570.90#" data-commission-pct="0" data-commission-price="0" data-net-price="19712.69" data-selling-price="19712.69" data-shortdate="Jun 11#Jun 12#Jun 13#Jun 14#Jun 15#Jun 16#Jun 17#Jun 18#" data-currency="Rs" class="calendarInfo">
                                                                 <span data-qa="room-price-text" id="currentprice_973236_10" class="current-price" data-tl="si-rate">
                                                                        19,712.69 Rs
                                                                </span>
                                                        </span>
                                    
                                    
                                    
                                                    </div>
                                                    <span class="exchanged-price" data-qa="exchanged-price"></span>
                                    
                                    
                                                </div>
                                    
                                                        <div class="item-action-col">
                                                            <form id="form-hot973236-acc1-boo10" class="mod-validable checkPurchaseCompat form_loading_dialog gildir" data-booking-modification="false" data-payment-type="agencia" data-hotel-code="973236" data-is-corporate="false" action="/serviceadd" method="post">
                                                                <button data-tl="  " type="submit" class="add-cart    pdf-hidden availability book-button agencia  no-external-hotel-room button-medium" data-qa="  external-hotel-room" name="accomodation">Add</button>
                                                                <input type="hidden" id="service-add-data-973236-BB-ST-SUI-IDB2B70-agencia-B2BNRFCH-19712_69-19712_69" name="serviceadd_data" value="{&quot;type&quot;:&quot;accommodation&quot;,&quot;data&quot;:{&quot;dataType&quot;:&quot;com.evo.api.resources.model.serviceadd.AccommodationServiceAddData&quot;,&quot;hotelAvailId&quot;:&quot;d07cd6c5-39d4-49e1-b825-f439cf580798|67|MTAuMjIyLjY2LjY3fDA=&quot;,&quot;availtoken&quot;:&quot;90aa184d-f1eb-4579-89da-5f57d969c11c&quot;,&quot;datefrom&quot;:&quot;20230613&quot;,&quot;dateto&quot;:&quot;20230616&quot;,&quot;hotelcode&quot;:&quot;973236&quot;,&quot;destinationcode&quot;:&quot;BAI&quot;,&quot;incomingoffice&quot;:&quot;325&quot;,&quot;contractname&quot;:&quot;ID_B2B_70&quot;,&quot;isprovider&quot;:&quot;Y&quot;,&quot;hotelname&quot;:&quot;Monolocale Resort Seminyak by Ini Vie Hospitality&quot;,&quot;typepayment&quot;:&quot;N&quot;,&quot;rooms&quot;:{&quot;2_0_0[]&quot;:{&quot;roominage&quot;:&quot;&quot;,&quot;roomcount&quot;:1,&quot;ratecode&quot;:&quot;B2BNRFCH&quot;,&quot;shrui&quot;:&quot;20230613|20230616|W|325|973236|SUI.ST|ID_B2B_70|BB|B2BNRFCH|1~2~0||N@06~A-SIC~~782055824~N~~~NRF~AF646C9372D24B2168655297530703PAIN000011400670015082454d00&quot;,&quot;roomadage&quot;:&quot;30-30&quot;,&quot;roomcharacteristic&quot;:&quot;ST&quot;,&quot;boardcode&quot;:&quot;BB&quot;,&quot;boardtype&quot;:&quot;SIMPLE&quot;,&quot;roomtypecode&quot;:&quot;SUI&quot;,&quot;roomchage&quot;:&quot;&quot;}},&quot;groupCode&quot;:&quot;GRUPO5&quot;,&quot;destinationSearchType&quot;:&quot;destinationSearch&quot;,&quot;establishmentType&quot;:&quot;H&quot;,&quot;isResident&quot;:&quot;N&quot;,&quot;s-room-price&quot;:&quot;19712.69&quot;},&quot;purchaseToken&quot;:null,&quot;extraInfo&quot;:null}" class="hotel-bt">
                                                                <input type="hidden" name="s-locata" value="">
                                                                <input type="hidden" id="hotel-name-form-hot973236-acc1-boo10" value="Monolocale Resort Seminyak by Ini Vie Hospitality">
                                                                <input type="hidden" id="hotel-room-form-hot973236-acc1-boo10" value="Suite standard">
                                                                <input type="hidden" id="hotel-reg-form-hot973236-acc1-boo10" value="BED AND BREAKFAST" name="board-description">
                                                                <input type="hidden" id="hotel-rates-form-hot973236-acc1-boo10" value="8" name="rates-count">
                                                                <input type="hidden" id="hotel-position-form-hot973236-acc1-boo10" value="1" name="position">
                                                                <input type="hidden" id="SID" name="SID" value="385bc4e82c3b5ea0c27d9c39e9f9ca6e">
                                                                    <input type="hidden" name="tealeaf-results-source" value="ACC_AVAIL">
                                                            </form>
                                                        </div>
                                            </div>
                                    
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
