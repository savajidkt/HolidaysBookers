@extends('agent.layouts.app')
@section('page_title', 'View Booking History')
@section('content')
    <style>
        .total-review .review-list li {
            margin-bottom: 13px;
            display: flex;
            justify-content: space-between
        }

        .border-type-2 {
            border: 1px solid green;
        }
    </style>

    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Booking Details</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
                <a href="{{ url()->previous() }}" class="button h-50 px-24 -blue-1 bg-blue-1-05 text-blue-1">Back</a>
            </div>
        </div>
        <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
            <div class="tabs -underline-2 js-tabs">

                <section class="pt-40 layout-pb-md">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-7 col-lg-8">
                                <div class="d-flex flex-column items-center  lg:md-40 sm:mt-24">
                                    <div class="text-30 lh-1 fw-600 mt-20">Your Booking Details</div>
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
                                                @php
                                                    $orderAmtWithTax = $order->booking_amount;
                                                    if (isset($requiredParamArr['taxes_and_fees_amt']) && $requiredParamArr['taxes_and_fees_amt'] > 0) {
                                                        $orderAmtWithTax = $orderAmtWithTax + $requiredParamArr['taxes_and_fees_amt'];
                                                    }
                                                @endphp
                                                {{ numberFormat($orderAmtWithTax, $order->booking_currency) }}</div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="text-15 lh-12">Payment Method</div>
                                            <div class="text-15 lh-12 fw-500 text-blue-1 mt-10">
                                                {{ paymentMethodName($order->is_pay_using) }}</div>
                                        </div>
                                    </div>
                                </div>


                                @if ($order->room && (isset($requiredParamArr['passenger_type']) && $requiredParamArr['passenger_type'] == 'all'))
                                    @php
                                        $currentRoom = '';
                                        $i = 0;
                                    @endphp
                                    <div class=" px-20 py-20 mt-20">

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

                                            <div
                                                class="row mb-15 {{ $value['type'] == 'child' ? ' border-type-2' : 'border-type-1' }} rounded-8">
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
                                                                {{ $passengerData->child->child_age }} /
                                                                {{ chidWithBed($passengerData) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class=" px-20 py-20 mt-20">

                                        <div class="row y-gap-20 mb-15 mt-15 justify-between">
                                            <div class="col-auto">
                                                <div class="fw-500">Lead Passenger
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-15 rounded-8">
                                            <div class="col-12">
                                                <div class="d-flex justify-between ">
                                                    <div class="text-15 lh-16">Name</div>
                                                    <div class="text-15 lh-16 fw-500 text-blue-1">
                                                        {{ $requiredParamArr['lead_passenger']['name'] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-between border-top-light pt-10">
                                                    <div class="text-15 lh-16">ID Proof</div>
                                                    <div class="text-15 lh-16 fw-500 text-blue-1">
                                                        {{ $requiredParamArr['lead_passenger']['id_proof'] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-between border-top-light pt-10">
                                                    <div class="text-15 lh-16">ID Proof No</div>
                                                    <div class="text-15 lh-16 fw-500 text-blue-1">
                                                        {{ $requiredParamArr['lead_passenger']['id_proof_no'] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-between border-top-light pt-10">
                                                    <div class="text-15 lh-16">Phone</div>
                                                    <div class="text-15 lh-16 fw-500 text-blue-1">
                                                        {{ $requiredParamArr['lead_passenger']['phone'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @php
                                $finalAmt = 0;
                            @endphp
                            <div class="col-xl-5 col-lg-4">
                                <div class="ml-80 lg:ml-40 md:ml-0">
                                    <div class="px-30 py-30 border-light rounded-4">
                                        <div class="">
                                            @if (count($requiredParamArr['cartData']))
                                                <ul class=" y-gap-4 pt-5">
                                                    @foreach ($requiredParamArr['cartData'] as $key => $value)
                                                        @php
                                                            // dd($requiredParamArr['taxes_and_fees']);
                                                            // dd($requiredParamArr['taxes_and_fees_amt']);
                                                            $offlineRoom = getRoomDetailsByRoomID($value['room_id']);
                                                            $hotelRoomTypeStr = $offlineRoom->roomtype->room_type ? $offlineRoom->roomtype->room_type : '';
                                                            $hotelAdultTypeStr = $value['adult'] > 0 ? ', ' . $value['adult'] . ' Adults' : '';
                                                            $hotelChildTypeStr = $value['child'] > 0 ? ', ' . $value['child'] . ' Children' : '';
                                                            $hotelTitleName = '<span class="text-12 fw-500">' . $hotelRoomTypeStr . '' . $hotelAdultTypeStr . '' . $hotelChildTypeStr . '</span>';
                                                            
                                                            $finalAmt = $finalAmt + $value['finalAmount'];
                                                            $hotelsDetails = $hotelListingRepository->hotelDetailsArr($value['hotel_id']);
                                                        @endphp
                                                        <li class="">
                                                            <div class="text-15 fw-500">
                                                                <i class="fa fa-bed"></i>
                                                                {{ $hotelsDetails['hotel']['hotel_name'] }}
                                                                <br>
                                                                @php
                                                                    echo $hotelTitleName;
                                                                @endphp
                                                                <br>
                                                                <span class="text-12 fw-500">
                                                                    From
                                                                    {{ date('d M, Y', strtotime($value['search_from'])) }}
                                                                    To
                                                                    {{ date('d M, Y', strtotime($value['search_to'])) }}
                                                                </span>
                                                                <span class="pull-right text-15 fw-500">
                                                                    {{ numberFormat($value['finalAmount'], trim($order->original_currency)) }}
                                                                </span>
                                                            </div>
                                                            <div class="mt-10 border-top-light"></div>
                                                        </li>
                                                    @endforeach
                                                    <li class="">
                                                        <div class="text-15 fw-500">
                                                            Taxes and fees:
                                                            {{ isset($requiredParamArr['taxes_and_fees']) ? '(' . $requiredParamArr['taxes_and_fees'] . '%)' : '' }}
                                                            <span class="pull-right text-15 fw-500">
                                                                @php
                                                                    if (isset($requiredParamArr['taxes_and_fees_amt']) && $requiredParamArr['taxes_and_fees_amt'] > 0) {
                                                                        $finalAmt = $finalAmt + $requiredParamArr['taxes_and_fees_amt'];
                                                                    }
                                                                    
                                                                @endphp
                                                                {{ numberFormat(isset($requiredParamArr['taxes_and_fees_amt']) ? $requiredParamArr['taxes_and_fees_amt'] : 0, trim($order->original_currency)) }}
                                                            </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endif
                                        </div>
                                        <div class="border-top-light mt-30 mb-20"></div>
                                        <div class="row y-gap-20 justify-between items-center">
                                            <div class="">
                                                <div class="text-15 fw-500">Booking Amount:
                                                    <span
                                                        class="pull-right text-20">{{ numberFormat($finalAmt, trim($order->original_currency)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        @include('agent.common.footer')
    </div>



@endsection
@section('page-script')
@endsection
