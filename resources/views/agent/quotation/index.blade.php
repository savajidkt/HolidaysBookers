@extends('agent.layouts.app')
@section('page_title', 'Quotation')
@section('content')
    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Quotation History</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
                <a href="{{ route('home') }}" class="button h-50 px-24 -dark-1 bg-blue-1 text-white">
                    <i class="fa fa-plus-circle mr-2 pr-10"></i> New Quotation
                </a>
            </div>
        </div>

        @if (count($quoteData) > 0)
            @php
                
                $i = 1;
            @endphp
            @foreach ($quoteData as $key => $value)
                @php
                    $payAmount = 0;
                @endphp
                {{-- {{ dd($value->created_at) }} --}}
                @if ($i == 1)
        <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
                    @else
                        <div class="mt-20 py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
                @endif
                <div class="col-12">
                    <div class="">
                        <div class="row x-gap-20 y-gap-30">
                            <div class="col-md-12 bg-light-2">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3 class="text-18 lh-14 fw-500">{{ $value->quote_name }}</h3>
                                        <div class="row x-gap-10 y-gap-10 items-center">
                                            <div class="col-auto">
                                                <a href="javascript:void(0);" class="text-blue-1 mt-5"
                                                    data-order-id="{{ $value->id }}"> </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h3 class="text-18 lh-14 fw-500">
                                            {{ $user->agents->agent_first_name . ' ' . $user->agents->agent_last_name }}
                                        </h3>
                                        <div class="row x-gap-10 y-gap-10 items-center">
                                            <div class="col-auto">
                                                <a href="javascript:void(0);" class="text-blue-1 mt-5"
                                                    data-order-id="{{ $value->id }}"> </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h3 class="text-18 lh-14 fw-500">{{ $user->agents->agent_mobile_number }}</h3>
                                        <div class="row x-gap-10 y-gap-10 items-center">
                                            <div class="col-auto">
                                                <a href="javascript:void(0);" class="text-blue-1 mt-5"
                                                    data-order-id="{{ $value->id }}"> </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h3 class="text-18 lh-14 fw-500">{{ $user->agents->agent_email }}</h3>
                                        <div class="row x-gap-10 y-gap-10 items-center">
                                            <div class="col-auto">
                                                <a href="javascript:void(0);" class="text-blue-1 mt-5"
                                                    data-order-id="{{ $value->id }}"> </a>
                                    </div>
                                   
                                            </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h3 class="text-18 lh-14 fw-500">Creation</h3>
                                        <div class="row x-gap-10 y-gap-10 items-center">
                                            <div class="col-auto">
                                                <a href="javascript:void(0);" class="text-blue-1 mt-5 text-12"
                                                    data-order-id="{{ dateFormat($value->created_at) }}">
                                                    {{ dateFormat($value->created_at) }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                
                                @if ( isset($value->quote_hotel_rooms) && count($value->quote_hotel_rooms) > 0)
                                    @php
                                        $j = 1;
                                    @endphp
                                    @foreach ($value->quote_hotel_rooms as $roomkey => $roomvalue)
                                       
                                        @php
                                        $child_extraArr = [];
                                        $age=[];
                                            $payAmount = $payAmount + $roomvalue->price;
                                            if ($roomvalue->extra_markup_price > 0) {
                                                $payAmount = $payAmount + $roomvalue->extra_markup_price;
                                            }
                                        @endphp

                                        @if (isset($roomvalue->child_extra))
                                            @php
                                                $child_extraArr = unserialize($roomvalue->child_extra);
                                            @endphp                            
                                        @foreach ($child_extraArr as $ckey => $child)
                                            @php
                                                $age[] = $child->age;
                                            @endphp
                                        @endforeach
                                        @endif

                                        @php
                                   $room_title_with_child='';                                   
                                    if($roomvalue->adult){
                                        $room_title_with_child = dateDiffInDays($roomvalue->check_in_date, $roomvalue->check_out_date).' Nights, ';                                        
                                        $room_title_with_child .='for '.$roomvalue->adult.' adults';                                        
                                    }
                                    if($roomvalue->child){
                                        $room_title_with_child .=', '.$roomvalue->child.' children - '.implode(',',$age).' years old';                                        
                                    }

                               @endphp

                                        @if ($j == 1)
                                            <div class="col-md-12">
                                            @else
                                                <div class="col-md-12 border-top-light pt-20">
                                        @endif

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3 class="text-18 lh-14 fw-500">
                                                    {{ $roomvalue->hotel_details->hotel_name }}
                                                </h3>
                                                <div class="row x-gap-10 y-gap-10 items-center">
                                                    <div class="col-auto">
                                                        <p class="text-14"><i class="icon-location-2 text-16 mr-5"></i> {{ $roomvalue->hotel_details->city->name }} </p>
                                                        <p> {{ $roomvalue->room_name ?  $roomvalue->room_name : '' }}                                                           
                                                            {{ $room_title_with_child }} 
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <h3 class="text-18 lh-14 fw-500">From - to</h3>
                                                <div class="row x-gap-10 y-gap-10 items-center">
                                                    <div class="col-auto">
                                                        <p class="text-14">
                                                            {{ dateFormat($roomvalue->check_in_date, 'd/m/Y') }} -
                                                            {{ dateFormat($roomvalue->check_out_date, 'd/m/Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <h3 class="text-18 lh-14 fw-500">

                                                    {{ getNumberWithComma($roomvalue->price, $value->booking_currency) }}
                                                    {{ $roomvalue->extra_markup_price ? '(markup: ' . getNumberWithComma($roomvalue->extra_markup_price, $value->booking_currency)  . ')' : '' }}

                                                </h3>
                                                <div class="row x-gap-10 y-gap-10 items-center">
                                                    <div class="col-auto">
                                                        <span class="fw-500 text-blue-1 QuoteDetails">
                                                            @if ($value->status == '0')
                                                                
                                                            
                                                            <a href="javascript:void(0);"
                                                                data-order-id="{{ $value->id }}"
                                                                data-room-id="{{ $roomvalue->id }}"
                                                                data-room-name="{{ $roomvalue->hotel_details->hotel_name }}"
                                                                data-room-price="{{ getNumberWithComma($roomvalue->price, $value->booking_currency) }}"
                                                                data-price="{{ $roomvalue->price }}"
                                                                data-cy-price="{{ $value->booking_currency }}"
                                                                data-markup-price="{{ $roomvalue->extra_markup_price }}"
                                                                class="text-blue-1 mt-5 QuoteRoomEdit">Edit
                                                                price</a>
                                                            <a href="javascript:void(0);"
                                                                data-order-id="{{ $value->id }}"
                                                                data-room-id="{{ $roomvalue->id }}"
                                                                class="text-blue-1 mt-5 QuoteRoomDelete">Delete
                                                </a>
                                                            {{-- <a href="javascript:void(0);"
                                                                data-order-id="{{ $value->id }}"
                                                                data-room-id="{{ $roomvalue->id }}" data-cart-type="single"
                                                                class="text-blue-1 mt-5 QuoteRoomAddToCart">Add
                                                                to
                                                                cart</a> --}}
                                                                @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            @php
                                $j++;
                            @endphp
            @endforeach
        @endif

    </div>
    <div class="col-md-2 text-right md:text-left">
        <div class="d-flex flex-column justify-between h-full">
            <div class="row x-gap-10 y-gap-10 justify-end items-center md:justify-start">
                <div class="col-auto">
                    <div class="text-14 lh-14 fw-500">Pay to Holidays Bookers</div>
                    <div class="text-14 lh-14 text-light-1">Total: <span
                            class="text-18 lh-14 fw-500">{{ getNumberWithComma($payAmount, $value->booking_currency) }}</span>
                    </div>
                </div>
            </div>
            <div class="pt-24">
                {{-- <div class="flex-center text-white fw-600 text-14  rounded-4 bg-blue-1 "><a href="javascript:void(0);"
                        class="QuoteRoomAddToCart" data-order-id="{{ $value->id }}" data-cart-type="all">Add to
                        cart</a>
                </div> --}}
                @if ($value->status == '0')
                <a href="javascript:void(0);" class="flex-center text-white fw-600 text-14  rounded-4 bg-blue-1 QuoteRoomAddToCart"
                         data-order-id="{{ $value->id }}" data-cart-type="all">
                         <div class="flex-center text-white fw-600 text-14  rounded-4 bg-blue-1 ">Add to
                            cart
                    </div>
                </a>
                @endif
                <span class="fw-500 text-blue-1 QuoteDetails">                   
                  
                        @if ($value->status == '1')
                        <span class="rounded-100 py-4 px-10 text-center text-14 fw-500 bg-blue-1-05 text-blue-1">Completed</span>
                         @elseif ($value->status == '2')
                         <span class="rounded-100 py-4 px-10 text-center text-14 fw-500 bg-red-3 text-red-2">Canceled</span>
                         @elseif ($value->status == '0')
                         <span class="rounded-100 py-4 px-10 text-center text-14 fw-500 bg-yellow-4 text-yellow-3">Pending</span>
                            @endif
                        

                    <a href="{{ route('agent.order-view', $value->id) }}" class="text-blue-1 mt-5"
                        data-order-id="{{ $value->id }}">View </a>
                        @if ($value->status == '0')
                    <a href="javascript:void(0);" class="text-blue-1 mt-5 QuoteOrderDelete"
                        data-order-id="{{ $value->id }}">Delete</a>
                        @endif
                </span>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    @php
        $i++;
    @endphp
    @endforeach
@else
    @endif
    {!! $quoteData->links() !!}
    {{-- <div class="pt-30">
        <div class="row justify-between">
            <div class="col-auto">
                <button class="button -blue-1 size-40 rounded-full border-light">
                    <i class="icon-chevron-left text-12"></i>
                </button>
            </div>
            <div class="col-auto">
                <div class="row x-gap-20 y-gap-20 items-center">
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full">1</div>
                    </div>
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full bg-dark-1 text-white">2</div>
                    </div>
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full">3</div>
                    </div>
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full bg-light-2">4</div>
                    </div>
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full">5</div>
                    </div>
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full">...</div>
                                            </div>
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full">20</div>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <button class="button -blue-1 size-40 rounded-full border-light">
                    <i class="icon-chevron-right text-12"></i>
                </button>
            </div>
        </div>
    </div> --}}
    <form class="hide" id="addtocartFRM" action="{{ route('quote-temp-store') }}" method="POST">
        @csrf
    </form>
    <div class="modal fade" id="editRoomPrice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="bravo-theme-gotrip-login-form y-gap-20" method="POST"
                        action="{{ route('agent.order-edit-price', '') }}" id="EditPriceFrm" novalidate="novalidate">
                        @csrf
                        <input type="hidden" name="order_id" class="order_id">
                        <input type="hidden" name="room_id" class="room_id">
                        <div class="col-12 display-message">
                            <p class="mt-10 cName"></p>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-input email-error">
                                    <input type="text" class="has-value emailInput pvpInput" value="" disabled>
                                    <label class="lh-1 text-14 text-light-1">PVP</label>
                                </div>
                                            </div>
                            +
                            <div class="col-4">
                                <div class="form-input extra_markup_price-error">
                                    <input data-c-p="" data-cy-price="" type="number" name="extra_markup_price"
                                        class="has-value emailInput extra_markup_price">
                                    <label class="lh-1 text-14 text-light-1">
                                        Markup</label>
                                            </div>
                                        </div>
                            Rs=
                            <div class="col-4">
                                <div class="form-input">
                                    <input type="text" value="" class="has-value emailInput final_markup_price"
                                        disabled>
                                    <label class="lh-1 text-14 text-light-1">
                                        Service final price</label>
                                    </div>
                                </div>
                           
                        </div>

                        <div class="col-12 ">
                            <button type="submit" class="button h-50 px-24 -dark-1 bg-blue-1 text-white mt-5"
                                style="width:100%;">
                                <span class="icons">Confirm</span>
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        @include('agent.common.footer')
    </div>
@endsection
@section('page-script')

    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/quote.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(".tabs").click(function() {
                $(".tabs").removeClass("active");
                $(".tabs h6").removeClass("font-weight-bold");
                $(".tabs h6").addClass("text-muted");
                $(this).children("h6").removeClass("text-muted");
                $(this).children("h6").addClass("font-weight-bold");
                $(this).addClass("active");
                current_fs = $(".active");
                next_fs = $(this).attr('id');
                next_fs = "#" + next_fs + "1";
                $("fieldset").removeClass("show");
                $(next_fs).addClass("show");
                current_fs.animate({}, {
                    step: function() {
                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({
                            'display': 'block'
                        });
                    }
                });
            });

        });
        $(document).ready(function() {
            $(document).on('click', '.QuoteRoomDelete', function() {
                var redirectURL = "{!! url('/agent/quotation/order-room-delete/') !!}";
                redirectURL = redirectURL + '/' + $(this).attr('data-order-id') + '?orde_room_id=' + $(this)
                    .attr('data-room-id');

                swal({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    },
                    function(resp) {
                        if (resp) {
                            $.blockUI({
                            message: null,
                            overlayCSS: {
                                backgroundColor: '#F8F8F8'
                            }
                        });
                            window.location = redirectURL;
                        }
                    });

            });

            $(document).on('click', '.QuoteOrderDelete', function() {
                var redirectURL = "{!! url('/agent/quotation/order-delete/') !!}";
                redirectURL = redirectURL + '/' + $(this).attr('data-order-id');
                swal({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    },
                    function(resp) {
                        if (resp) {
                            $.blockUI({
                            message: null,
                            overlayCSS: {
                                backgroundColor: '#F8F8F8'
                            }
                        });

                            window.location = redirectURL;
                        }
                    });

            });

            $(document).on('click', '.QuoteRoomAddToCart', function() {

                $.blockUI({
                    message: null,
                    overlayCSS: {
                        backgroundColor: '#F8F8F8'
                    }
                });

                var redirectURL = "{!! url('/agent/checkout/quote-add-to-cart') !!}";
                var order_id = $(this).attr('data-order-id');
                var order_room_id = $(this).attr('data-room-id');
                var order_type = $(this).attr('data-cart-type');
                var input1 = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "order_id")
                    .val(order_id);
                var input2 = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "order_room_id")
                    .val(order_room_id);
                var input3 = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "order_type")
                    .val(order_type);
                $('#addtocartFRM').append($(input1));
                $('#addtocartFRM').append($(input2));
                $('#addtocartFRM').append($(input3));

                $('#addtocartFRM').submit();

               

            });
        });
    </script>

@endsection
