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


                                @if ($order->passenger_type == 1)

                                    <div class=" px-20 py-20 mt-20">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($order->order_rooms as $key => $value)
                                            @php
                                                $i++;
                                            @endphp
                                            <div class="row y-gap-20 mb-15 mt-15 justify-between">
                                                <div class="col-auto">
                                                    <div class="fw-500">Room {{ $i }} :
                                                        {{ $value->hotel_details->hotel_name }} :
                                                        <span class="fw-300">{{ $value->room_name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($value->order_hotel_room_passenger)
                                                @foreach ($value->order_hotel_room_passenger as $key => $value)
                                                    <div
                                                        class="row mb-15 {{ $value->is_adult == 1 ? ' border-type-2' : 'border-type-1' }} rounded-8">
                                                        <div class="col-12">
                                                            <div class="d-flex justify-between ">
                                                                <div class="text-15 lh-16">Name</div>
                                                                <div class="text-15 lh-16 fw-500 text-blue-1">
                                                                    {{ $value->name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-flex justify-between border-top-light pt-10">
                                                                <div class="text-15 lh-16">ID Proof</div>
                                                                <div class="text-15 lh-16 fw-500 text-blue-1">
                                                                    {{ $value->id_proof }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-flex justify-between border-top-light pt-10">
                                                                <div class="text-15 lh-16">ID Proof No</div>
                                                                <div class="text-15 lh-16 fw-500 text-blue-1">
                                                                    {{ $value->id_proof_no }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($value->is_adult == 0)
                                                            <div class="col-12">
                                                                <div class="d-flex justify-between border-top-light pt-10">
                                                                    <div class="text-15 lh-16">Phone</div>
                                                                    <div class="text-15 lh-16 fw-500 text-blue-1">
                                                                        {{ $value->phone }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
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
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($order->order_rooms as $key => $value)
                                            @php
                                                $i++;
                                            @endphp
                                            <div class="row y-gap-20 mb-15 mt-15 justify-between">
                                                <div class="col-auto">
                                                    <div class="fw-500">Room {{ $i }} :
                                                        {{ $value->hotel_details->hotel_name }} :
                                                        <span class="fw-300">{{ $value->room_name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="row mb-15 rounded-8">
                                            <div class="col-12">
                                                <div class="d-flex justify-between ">
                                                    <div class="text-15 lh-16">Name</div>
                                                    <div class="text-15 lh-16 fw-500 text-blue-1">
                                                        {{ $order->lead_passenger_name }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-between border-top-light pt-10">
                                                    <div class="text-15 lh-16">ID Proof</div>
                                                    <div class="text-15 lh-16 fw-500 text-blue-1">
                                                        {{ $order->lead_passenger_id_proof }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-between border-top-light pt-10">
                                                    <div class="text-15 lh-16">ID Proof No</div>
                                                    <div class="text-15 lh-16 fw-500 text-blue-1">
                                                        {{ $order->lead_passenger_id_proof_no }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-between border-top-light pt-10">
                                                    <div class="text-15 lh-16">Phone</div>
                                                    <div class="text-15 lh-16 fw-500 text-blue-1">
                                                        {{ $order->lead_passenger_phone }}
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

                                            @if ($order->order_hotel)
                                                <ul class=" y-gap-4 pt-5">
                                                    @foreach ($order->order_hotel as $key => $value)
                                                        @if ($value->order_hotel_room)
                                                            @foreach ($value->order_hotel_room as $key1 => $value1)
                                                                @php
                                                                    $finalAmt = $finalAmt + $value1->price;
                                                                @endphp
                                                                <li class="">
                                                                    <div class="text-15 fw-500">
                                                                        <i class="fa fa-bed"></i>
                                                                        {{ $value->hotel_name }}
                                                                        <br>
                                                                        <span class="text-12 fw-500">
                                                                            {{ $value1->room_name }}, Adults
                                                                            {{ $value1->adult }}, Children
                                                                            {{ $value1->child }}</span>
                                                                        <br>
                                                                        <span class="text-12 fw-500">
                                                                            From
                                                                            {{ date('d M, Y', strtotime($value1->check_in_date)) }}
                                                                            To
                                                                            {{ date('d M, Y', strtotime($value1->check_out_date)) }}
                                                                        </span>
                                                                        <span class="pull-right text-15 fw-500">
                                                                            {{ numberFormat($value1->price, trim($order->order_currency)) }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="mt-10 border-top-light"></div>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    <li class="">
                                                        <div class="text-15 fw-500">
                                                            Taxes and fees:
                                                            {{ '(' . $order->tax . '%)' }}
                                                            <span class="pull-right text-15 fw-500">
                                                                @php
                                                                    
                                                                    $finalAmt = $finalAmt + $order->tax_amount;
                                                                    
                                                                @endphp
                                                                {{ numberFormat($order->tax_amount, trim($order->order_currency)) }}
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
                                                        class="pull-right text-20">{{ numberFormat($finalAmt, trim($order->order_currency)) }}</span>
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
