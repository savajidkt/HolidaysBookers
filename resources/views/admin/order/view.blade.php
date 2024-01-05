@extends('admin.layout.app')
@section('page_title', 'Order')
@section('content')
<style>
    .my-validation-message::before {
        display: none;
    }

    .my-validation-message i {
        margin: 0 .4em;
        color: #f27474;
        font-size: 1.4em;
    }
</style>
    <section id="page-account-settings">
        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column nav-left">
                    <li class="nav-item">
                        <a class="nav-link active" id="account-pill-hotel-details" data-toggle="pill"
                            href="#account-vertical-hotel-details" aria-expanded="true">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">HOTEL DETAILS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-room-details" data-toggle="pill"
                            href="#account-vertical-room-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">PASSENGER DETAILS</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-galleries-details" data-toggle="pill"
                            href="#account-vertical-galleries-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">BOOKING DETAILS</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!--/ left menu section -->

            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="account-vertical-hotel-details"
                                aria-labelledby="account-pill-hotel-details" aria-expanded="true">
                                @if (count($model->order_hotel) > 0)
                                    <div class="col-12">
                                        <div class="d-flex align-items-center mb-1 mt-1">
                                            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
                                            <h4 class="mb-0 ml-75">Hotel Details</h4>
                                        </div>
                                        <hr class="my-2" />
                                    </div>
                                    @foreach ($model->order_hotel as $key => $value)
                                        @if (count($value->order_hotel_room) > 0)
                                            @foreach ($value->order_hotel_room as $sub_key => $sub_value)
                                                <div class="row">
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="account-username">Hotel Name</label>
                                                            <strong
                                                                class="disp-below">{{ $value->hotel_name . ' - ' . $sub_value->room_name }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="account-username">Hotel Country</label>
                                                            <strong
                                                                class="disp-below">{{ $value->hotel->country->name }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="account-username">Hotel City</label>
                                                            <strong
                                                                class="disp-below">{{ $value->hotel->city->name }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="account-username">Check-in</label>
                                                            <strong
                                                                class="disp-below">{{ $sub_value->check_in_date }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="account-username">Check-out</label>
                                                            <strong
                                                                class="disp-below">{{ $sub_value->check_out_date }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="my-2" />
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif

                            </div>
                            <div class="tab-pane fade" id="account-vertical-room-details" role="tabpanel"
                                aria-labelledby="account-pill-room-details-details" aria-expanded="false">

                                @if ($model->passenger_type == '0')
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center mb-1 mt-1">
                                                <i data-feather="arrow-right-circle" class="font-medium-3"></i>
                                                <h4 class="mb-0 ml-75">Lead Passenger Details</h4>
                                            </div>
                                            <hr class="my-2" />
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label for="account-username">Full Name</label>
                                                <strong class="disp-below">{{ $model->lead_passenger_name }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label for="account-username">ID Proof</label>
                                                <strong class="disp-below">{{ $model->lead_passenger_id_proof }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label for="account-username">ID No.</label>
                                                <strong class="disp-below">{{ $model->lead_passenger_id_proof_no }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label for="account-username">Mobile Number.</label>
                                                <strong
                                                    class="disp-below">{{ $model->lead_passenger_phone_code . ' ' . $model->lead_passenger_phone }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="d-flex align-items-center mb-1 mt-1">
                                            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
                                            <h4 class="mb-0 ml-75">Passenger Details</h4>
                                        </div>
                                        <hr class="my-2" />
                                    </div>
                                    @if (count($model->order_hotel) > 0)
                                        @foreach ($model->order_hotel as $key => $value)
                                            @if (count($value->order_hotel_room) > 0)
                                                @foreach ($value->order_hotel_room as $sub_key => $sub_value)
                                                    @if (count($sub_value->order_hotel_room_passenger) > 0)
                                                        @foreach ($sub_value->order_hotel_room_passenger as $pass_key => $pass_value)
                                                            <div class="row">

                                                                <div class="col-12 col-sm-3">
                                                                    <div class="form-group">
                                                                        <label for="account-username">Full Name</label>
                                                                        <strong
                                                                            class="disp-below">{{ $pass_value->name }}</strong>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-3">
                                                                    <div class="form-group">
                                                                        <label for="account-username">ID Proof</label>
                                                                        <strong
                                                                            class="disp-below">{{ $pass_value->id_proof }}</strong>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-2">
                                                                    <div class="form-group">
                                                                        <label for="account-username">ID No.</label>
                                                                        <strong
                                                                            class="disp-below">{{ $pass_value->id_proof_no }}</strong>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-2">
                                                                    <div class="form-group">
                                                                        <label for="account-username">Mobile
                                                                            Number.</label>
                                                                        <strong
                                                                            class="disp-below">{{ $pass_value->phone_code . ' ' . $pass_value->phone }}</strong>
                                                                    </div>
                                                                </div>
                                                                @if ($pass_value->is_adult == '0')
                                                                    <div class="col-12 col-sm-2">
                                                                        <div class="form-group">
                                                                            <label for="account-username">Adult</label>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-12 col-sm-2">
                                                                        <div class="form-group">
                                                                            <label for="account-username">Child</label>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </div>
                                                            <hr class="my-2" />
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endif

                            </div>
                            <div class="tab-pane fade" id="account-vertical-galleries-details" role="tabpanel"
                                aria-labelledby="account-pill-galleries-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">PRN Number</label>
                                            <strong class="disp-below">{{ $model->prn_number }}</strong>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Booking Status</label>
                                            <strong class="disp-below">{{ getOrderStatus($model->status) }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Voucher</label>
                                            <strong class="disp-below">{{ $model->voucher == 1 ? 'Yes' : 'No' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Original Amount</label>
                                            <strong class="disp-below">{{ getNumberWithComma($model->order_amount, $model->order_currency) }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Original Currency</label>
                                            <strong class="disp-below">{{ $model->order_currency }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Booking Amount</label>
                                            <strong class="disp-below">{{ getNumberWithComma($model->booking_amount, $model->order_currency) }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Booking Currency</label>
                                            <strong class="disp-below">{{ $model->booking_currency }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Agent Code</label>
                                            <strong class="disp-below">{{ $model->agent_code }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Agent Email</label>
                                            <strong class="disp-below">{{ $model->agent_email }}</strong>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Hotel Supplier</label>
                                            <strong
                                                class="disp-below">{{ $model->type == 1 ? 'API' : 'Offline' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Total Rooms</label>
                                            <strong class="disp-below">{{ $model->total_rooms }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Total Nights</label>
                                            <strong class="disp-below">{{ $model->total_nights }}</strong>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Payment</label>
                                            <strong
                                                class="disp-below">{{ $model->payment_status == 1 ? 'Yes' : 'No' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Comments</label>
                                            <strong class="disp-below">{{ $model->comments }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Mail Sent</label>
                                            <strong
                                                class="disp-below">{{ $model->mail_sent == 1 ? 'Yes' : 'No' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Booked By</label>
                                            <strong class="disp-below">{{ getOrderBookedBy($model->booked_by) }}</strong>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Agent Markup Type</label>
                                            <strong class="disp-below">{{ $model->agent_markup_type }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Agent Markup Value</label>
                                            <strong class="disp-below">{{ $model->agent_markup_val }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Total Price Markup</label>
                                            <strong class="disp-below">{{ $model->total_price_markup }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Payment Type</label>
                                            <strong
                                                class="disp-below">{{ $model->is_pay_using == 1 ? 'Online' : 'Wallet' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            @php
                                                echo '<a href="' . route('view-order-payment', $model->id) . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Payment Details" data-animation="false"><i class="fa fa-check-square-o" aria-hidden="true"></i></a> ';
                                                if ($model->mail_sent == 1) {
                                                    echo '<a target="_blank" href="' . url('storage/app/public/order/' . $model->id . '/vouchers/order-vouchers-' . $model->id . '.pdf') . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Voucher" data-animation="false"><i class="fa fa-file-o" aria-hidden="true"></i></a> ';
                                                } else {
                                                    echo '<a href="javascript:void(0);" class="edit btn btn-info btn-sm Generate_action" data-order-id="' . $model->id . '" data-toggle="tooltip" data-original-title="Generate voucher & send mail" data-animation="false"><i class="fa fa-file-o" aria-hidden="true"></i></a> ';
                                                }
                                                
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('extra-script')
    <script type="text/javascript">
        $('.Generate_action').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);

            Swal.fire({
                title: 'Enter Confirmation code',
                input: 'text',
                customClass: {
                    validationMessage: 'my-validation-message'
                },
                showCancelButton: true,
                preConfirm: (value) => {
                    if (!value) {
                        Swal.showValidationMessage(
                            '<i class="fa fa-info-circle"></i> Your confirmation code required'
                        )
                    } else {

                        $.blockUI({
                            message: null,
                            overlayCSS: {
                                backgroundColor: '#F8F8F8'
                            }
                        });
                        $('<form action="{!! route('order-voucher-download') !!}" method="POST">' +
                            '<input type="hidden" name="_token" value="' +
                            $('meta[name="csrf-token"]').attr('content') + '" />' +
                            '<input type="hidden" name="confirmation_code" value="' +
                            value + '" />' +
                            '<input type="hidden" name="order_id" value="' + $(this)
                            .attr('data-order-id') + '" />' +
                            '</form>').appendTo('body').submit();
                    }
                }
            });
        });
    </script>
@endsection
