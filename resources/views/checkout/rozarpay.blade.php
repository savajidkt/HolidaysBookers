@extends('layouts.app')
@section('page_title', 'RozarPay')
@section('content')

    <style>
        .razorpay-payment-button {
            /* height: 60px !important;
            color: var(--color-white);
            background-color: var(--color-blue-1) !important;
            padding-left: 24px !important;
            padding-right: 24px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
            text-align: center;
            line-height: 1;
            font-weight: 500;
            font-size: 15px;
            line-height: 1.2;
            border-radius: 4px;
            border: 1px solid transparent;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1); */
            display: none;
        }
    </style>

    <section class="pt-40 layout-pb-md">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8">

                    @if (\Session::has('error'))
                        <div class="col-12">
                            <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                <div class="text-error-2 lh-1 fw-500">{!! \Session::get('error') !!}</div>
                            </div>
                        </div>
                    @endif
                    @if (\Session::has('success'))
                        <div class="col-12">
                            <div class="d-flex items-center justify-between bg-success-1 pl-30 pr-20 py-30 rounded-8">
                                <div class="text-success-2 lh-1 fw-500">{!! \Session::get('success') !!}</div>
                            </div>
                        </div>
                    @endif

                    <form class="needs-validation1" id="RozarPayFrm" method="POST" enctype="multipart/form-data"
                        action="{{ route('razorpaypayment') }}">
                        @csrf
                        <script src="https://checkout.razorpay.com/v1/checkout.js" 
                            data-key="{{ env('RAZORPAY_KEY_ID') }}"                             
                            data-amount="{{ $dataObj->total_amount * 100 }}"
                            data-buttontext="Pay {{ $dataObj->total_amount . ' ' . $dataObj->currency }}" 
                            data-name="Holidays Bookers"
                            data-description="Booking Razorpay payment" 
                            data-image="/images/logo-icon.png"
                            data-prefill.name="{{ $requestData['firstname'] . ' ' . $requestData['firstname'] }}" 
                            data-prefill.email="{{ $requestData['email'] }}"
                            data-theme.color="#ff7529"></script>
                            <input type="hidden" name="temp_order_amount" id="temp_order_amount" value="{{ $dataObj->total_amount }}" />
                            <input type="hidden" name="temp_order_id" id="temp_order_id" value="{{ $dataObj->unique_number }}" />
                            <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="{{ route('razorpaypaymentSuccess') }}"/>
                            <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="{{ route('razorpaypaymentFailed') }}"/>
                    </form>

                    <div class="w-full h-1 bg-border mt-40 mb-40"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>   
    <script language="javascript" type="text/javascript">
       $("#RozarPayFrm").submit();       
    </script>
@endsection
