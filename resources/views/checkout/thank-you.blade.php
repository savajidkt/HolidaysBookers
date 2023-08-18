@extends('layouts.app')
@section('page_title', 'Thank you')
@section('content')
    <style>
        .total-review .review-list li {
            margin-bottom: 13px;
            display: flex;
            justify-content: space-between
        }
    </style>
    <section class="pt-40 layout-pb-md">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                </div>
                <div class="col-xl-7 col-lg-8">
                    <div class="d-flex flex-column items-center mt-60 lg:md-40 sm:mt-24">
                        <div class="size-80 flex-center rounded-full bg-dark-3">
                            <i class="icon-check text-30 text-white"></i>
                        </div>
                        <div class="text-30 lh-1 fw-600 mt-20">Agent, your order was submitted successfully!</div>
                        <div class="text-15 text-light-1 mt-10">Booking details has been sent to:
                            {{ $order->agentcode->user->email }}
                        </div>
                    </div>
                    <div class="border-type-1 rounded-8 px-50 py-35 mt-40">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Order Number</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10"><a href="{{ route('agent.booking-history', 'all') }}">{{ $order->id }}</a></div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Date</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10"><a href="{{ route('agent.booking-history', 'all') }}">
                                    {{ dateFormat($order->created_at, 'd M, Y') }}</a></div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Total</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10"><a href="{{ route('agent.booking-history', 'all') }}">
                                    {{ numberFormat($order->booking_amount, $order->booking_currency) }}</a></div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Payment Method</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10"><a href="{{ route('agent.booking-history', 'all') }}">
                                    {{ paymentMethodName($order->is_pay_using) }}</a></div>
                            </div>
                        </div>
                    </div>

                    {{-- @if ($order->room)
                        @php
                            $currentRoom = '';
                            $i = 0;
                        @endphp
                        <div class="border-type-1 rounded-8 px-20 py-20 mt-20">

                            @foreach ($order->room as $key => $value)
                                @php
                                    $passengerData = orderRoomIDByAdultChild($value['id']);
                                @endphp
                                @if (empty($currentRoom) || $currentRoom != $value['room_id'])
                                    @php
                                        $currentRoom = $value['room_id'];
                                        $i++;
                                    @endphp
                                    <div class="row y-gap-20 mb-15 mt-15 justify-between">
                                        <div class="col-auto">
                                            <div class="fw-500">Room {{ $i }}
                                            </div>
                                        </div>                                      
                                    </div>
                                @endif
                                <div class="py-5 border-top-light"></div>
                                <div class="row  pt-5">
                                    <div class="col-12">
                                        <div class="d-flex justify-between ">
                                            <div class="text-15 lh-16">Name</div>
                                            <div class="text-15 lh-16 fw-500 text-blue-1">
                                                @if ($value['type'] == 'adult')
                                                    {{ $passengerData->adult->first_name }}
                                                @elseif ($value['type'] == 'child')
                                                    {{ $passengerData->child->child_first_name }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-between border-top-light pt-10">
                                            <div class="text-15 lh-16">ID Proof</div>
                                            <div class="text-15 lh-16 fw-500 text-blue-1">
                                                @if ($value['type'] == 'adult')
                                                    {{ idProofName($passengerData->adult->id_proof_type) }}
                                                @elseif ($value['type'] == 'child')
                                                    {{ idProofName($passengerData->child->child_id_proof_type) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-between border-top-light pt-10">
                                            <div class="text-15 lh-16">ID Proof No</div>
                                            <div class="text-15 lh-16 fw-500 text-blue-1">
                                                @if ($value['type'] == 'adult')
                                                    {{ $passengerData->adult->id_proof_no }}
                                                @elseif ($value['type'] == 'child')
                                                    {{ $passengerData->child->child_id_proof_no }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if ($value['type'] == 'adult')
                                        <div class="col-12">
                                            <div class="d-flex justify-between border-top-light pt-10">
                                                <div class="text-15 lh-16">Phone</div>
                                                <div class="text-15 lh-16 fw-500 text-blue-1">
                                                    {{ $passengerData->adult->phone }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($value['type'] == 'child')                                    
                                        <div class="col-12">
                                            <div class="d-flex justify-between border-top-light pt-10">
                                                <div class="text-15 lh-16">Age / CWB</div>
                                                <div class="text-15 lh-16 fw-500 text-blue-1">
                                                    {{ $passengerData->child->child_age }} / {{ chidWithBed($passengerData) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif --}}

                </div>
                <div class="col-xl-3 col-lg-4">
                </div>
                {{-- <div class="col-xl-5 col-lg-4">
                    <div class="ml-80 lg:ml-40 md:ml-0">
                        <div class="px-30 py-30 border-light rounded-4">
                            <div class="text-20 fw-500 mb-30">Your booking details</div>

                            <div class="row x-gap-15 y-gap-20">
                                <div class="col-auto">
                                    @if (strlen($hotelsDetails['hotel']['hotel_image_location']) > 0)
                                        <img class="size-140 rounded-4 object-cover"
                                            src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/' . $hotelsDetails['hotel']['hotel_image_location'])) }}"
                                            alt="{{ $hotelsDetails['hotel']['hotel_name'] }}">
                                    @endif
                                </div>
                                <div class="col">
                                    @if ($hotelsDetails['hotel']['category'] > 0)
                                        <div class="d-flex x-gap-5 pb-10">
                                            @for ($i = 1; $i <= $hotelsDetails['hotel']['category']; $i++)
                                                <i class="icon-star text-10 text-yellow-1"></i>
                                            @endfor
                                        </div>
                                    @endif
                                    <div class="lh-17 fw-500">{{ $hotelsDetails['hotel']['hotel_name'] }}</div>
                                    <div class="text-14 lh-15 mt-5">{{ $hotelsDetails['hotel']['hotel_address'] }}</div>
                                    <div class="row x-gap-10 y-gap-10 items-center pt-10">
                                        <div class="col-auto">
                                            <div class="d-flex items-center">
                                                <div class="size-30 flex-center bg-blue-1 rounded-4">
                                                    <div class="text-12 fw-600 text-white">
                                                        {{ $hotelsDetails['hotel']['hotel_review'] }}</div>
                                                </div>
                                                <div class="text-14 fw-500 ml-10">Exceptional</div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-14">{{ $hotelsDetails['hotel']['hotel_review'] }} reviews
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top-light mt-30 mb-20"></div>
                            <div class="row y-gap-20 justify-between">
                                <div class="col-auto">
                                    <div class="text-15">Check-in</div>
                                    <div class="fw-500">{{ date('d M, Y', strtotime($order->check_in_date)) }}
                                    </div>
                                </div>
                                <div class="col-auto md:d-none">
                                    <div class="h-full w-1 bg-border"></div>
                                </div>
                                <div class="col-auto text-right md:text-left">
                                    <div class="text-15">Check-out</div>
                                    <div class="fw-500">{{ date('d M, Y', strtotime($order->check_out_date)) }}
                                    </div>
                                </div>
                            </div>
                            <div class="border-top-light mt-30 mb-20"></div>
                            <div class="">
                                <div class="text-15">Total length of stay:</div>
                                <div class="fw-500">
                                    {{ dateDiffInDays($order->check_in_date, $order->check_out_date) }}
                                    nights</div>
                            </div>
                            <div class="border-top-light mt-30 mb-20"></div>

                            <div class="row y-gap-20 justify-between items-center">
                                <div class="col-auto">
                                    <div class="text-15">You selected:</div>

                                </div>

                                <div class="col-auto">
                                    <div class="text-15">
                                        Adult {{ count($order->adult) }},
                                        Child {{ count($order->child) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-30 py-30 border-light rounded-4 mt-30">
                            <div class="text-20 fw-500 mb-20">Your price summary</div>
                            <div class="review-section total-review">
                                <ul class="review-list">
                                    @if (is_array($requiredParamArr['cartData']) && count($requiredParamArr['cartData']) > 0)
                                        @foreach ($requiredParamArr['cartData'] as $key => $value)
                                            @php
                                                $offlineRoom = getRoomDetailsByRoomID($value['room_id']);
                                            @endphp
                                            <li class="flex-wrap">
                                                <div class="label"> {{ $offlineRoom->roomtype->room_type }} * 1</div>
                                                <div class="val">
                                                    {{ numberFormat($value['finalAmount'], $order->booking_currency) }}
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
@endsection
