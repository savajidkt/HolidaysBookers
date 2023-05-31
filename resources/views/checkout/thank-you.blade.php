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
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10">{{ $order->id }}</div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Date</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10">
                                    {{ dateFormat($order->created_at, 'd M, Y') }}</div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Total</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10">
                                    {{ numberFormat($order->booking_amount, $order->booking_currency) }}</div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-15 lh-12">Payment Method</div>
                                <div class="text-15 lh-12 fw-500 text-blue-1 mt-10">
                                    {{ paymentMethodName($order->is_pay_using) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="border-light rounded-8 px-50 py-40 mt-40">
                        <h4 class="text-20 fw-500 mb-30">Passenger Adult Information</h4>
                        <div class="row y-gap-10">
                            @if ($order->adult)
                                @foreach ($order->adult as $key => $value)
                                    <div class="col-12">
                                        <div class="d-flex justify-between ">
                                            <div class="text-15 lh-16">Name</div>
                                            <div class="text-15 lh-16 fw-500 text-blue-1">
                                                {{ $value['first_name'] . ' ' . $value['last_name'] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-between ">
                                            <div class="text-15 lh-16">ID Proof</div>
                                            <div class="text-15 lh-16 fw-500 text-blue-1">
                                                {{ idProofName($value['id_proof_type']) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-between">
                                            <div class="text-15 lh-16">ID Proof No</div>
                                            <div class="text-15 lh-16 fw-500 text-blue-1">
                                                {{ $value['id_proof_no'] ? $value['id_proof_no'] : '' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-between">
                                            <div class="text-15 lh-16">Phone</div>
                                            <div class="text-15 lh-16 fw-500 text-blue-1">
                                                {{ $value['phone'] ? $value['phone'] : '' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-between border-top-light pt-10"></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="border-light rounded-8 px-50 py-40 mt-40">
                      <h4 class="text-20 fw-500 mb-30">Passenger Child Information</h4>
                      <div class="row y-gap-10">
                          @if ($order->child)
                              @foreach ($order->child as $key => $value)
                                  <div class="col-12">
                                      <div class="d-flex justify-between ">
                                          <div class="text-15 lh-16">Name</div>
                                          <div class="text-15 lh-16 fw-500 text-blue-1">
                                              {{ $value['child_first_name'] . ' ' . $value['child_last_name'] }}</div>
                                      </div>
                                  </div>
                                  <div class="col-12">
                                      <div class="d-flex justify-between ">
                                          <div class="text-15 lh-16">ID Proof</div>
                                          <div class="text-15 lh-16 fw-500 text-blue-1">
                                              {{ idProofName($value['child_id_proof_type']) }}</div>
                                      </div>
                                  </div>
                                  <div class="col-12">
                                      <div class="d-flex justify-between">
                                          <div class="text-15 lh-16">ID Proof No</div>
                                          <div class="text-15 lh-16 fw-500 text-blue-1">
                                              {{ $value['child_id_proof_no'] ? $value['child_id_proof_no'] : '' }}</div>
                                      </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="d-flex justify-between">
                                        <div class="text-15 lh-16">Age / Bed</div>
                                        <div class="text-15 lh-16 fw-500 text-blue-1">
                                          5 / Yes
                                        </div>
                                    </div>
                                </div>
                                 
                                  <div class="col-12">
                                      <div class="d-flex justify-between border-top-light pt-10"></div>
                                  </div>
                              @endforeach
                          @endif
                      </div>
                  </div>
                </div>
                <div class="col-xl-5 col-lg-4">
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
                                    <div class="fw-500">{{ date('d M, Y', strtotime(getSearchCookies('search_from'))) }}
                                    </div>
                                </div>
                                <div class="col-auto md:d-none">
                                    <div class="h-full w-1 bg-border"></div>
                                </div>
                                <div class="col-auto text-right md:text-left">
                                    <div class="text-15">Check-out</div>
                                    <div class="fw-500">{{ date('d M, Y', strtotime(getSearchCookies('search_to'))) }}
                                    </div>
                                </div>
                            </div>
                            <div class="border-top-light mt-30 mb-20"></div>
                            <div class="">
                                <div class="text-15">Total length of stay:</div>
                                <div class="fw-500">
                                    {{ dateDiffInDays(getSearchCookies('search_from'), getSearchCookies('search_to')) }}
                                    nights</div>
                            </div>
                            <div class="border-top-light mt-30 mb-20"></div>

                            <div class="row y-gap-20 justify-between items-center">
                                <div class="col-auto">
                                    <div class="text-15">You selected:</div>

                                </div>

                                <div class="col-auto">
                                    <div class="text-15">
                                        Adult {{ getSearchCookies('searchGuestAdultCount') }},
                                        Child {{ getSearchCookies('searchGuestChildCount') }}
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
                                                    {{ numberFormat($value['finalAmount'], globalCurrency()) }}

                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
