@extends('admin.layout.app')
@section('page_title', 'Order')
@section('content')
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
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Hotel Name</label>
                                            <strong class="disp-below">{{ $model->hotel->hotel_name }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Hotel Country</label>
                                            <strong class="disp-below">{{ $model->country->name }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">Hotel City</label>
                                            <strong class="disp-below">{{ $model->city->name }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-room-details" role="tabpanel"
                                aria-labelledby="account-pill-room-details-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center mb-1 mt-1">
                                            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
                                            <h4 class="mb-0 ml-75">Passenger Adult Details</h4>
                                        </div>
                                        <hr class="my-2" />
                                    </div>
                                    @foreach ($model->adult as $adult)
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label for="account-username">First Name</label>
                                                <strong class="disp-below">{{ $adult->first_name }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label for="account-username">Last Name</label>
                                                <strong class="disp-below">{{ $adult->last_name }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label for="account-username">ID Proof</label>
                                                <strong
                                                    class="disp-below">{{ getIDProofName($adult->id_proof_type) }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label for="account-username">ID No.</label>
                                                <strong class="disp-below">{{ $adult->id_proof_no }}</strong>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-12">
                                        <div class="d-flex align-items-center mb-1 mt-1">
                                            <i data-feather="arrow-right-circle" class="font-medium-3"></i>
                                            <h4 class="mb-0 ml-75">Passenger Child Details</h4>
                                        </div>
                                        <hr class="my-2" />
                                    </div>
                                    @foreach ($model->child as $child)
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <label for="account-username">First Name</label>
                                                <strong class="disp-below">{{ $child->child_first_name }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <div class="form-group">
                                                <label for="account-username">Last Name</label>
                                                <strong class="disp-below">{{ $child->child_last_name }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <div class="form-group">
                                                <label for="account-username">ID Proof</label>
                                                <strong
                                                    class="disp-below">{{ getIDProofName($child->child_id_proof_type) }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <div class="form-group">
                                                <label for="account-username">ID No.</label>
                                                <strong class="disp-below">{{ $child->child_id_proof_no }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <div class="form-group">
                                                <label for="account-username">Age @if ($child->childBed->count() > 0)
                                                        <i class="fa fa-bed"></i>
                                                    @endif
                                                </label>
                                                <strong class="disp-below">{{ $child->child_age }}</strong>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-galleries-details" role="tabpanel"
                                aria-labelledby="account-pill-galleries-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Booking ID</label>
                                            <strong class="disp-below">{{ $model->booking_id }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Confirmation No</label>
                                            <strong class="disp-below">{{ $model->confirmation_no }}</strong>
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
                                            <strong class="disp-below">{{ $model->original_amount }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Original Currency</label>
                                            <strong class="disp-below">{{ $model->original_currency }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Booking Amount</label>
                                            <strong class="disp-below">{{ $model->booking_amount }}</strong>
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
                                            <label for="account-username">Check In Date</label>
                                            <strong
                                                class="disp-below">{{ dateFormat($model->check_in_date, 'd M, Y') }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Check Out Date</label>
                                            <strong
                                                class="disp-below">{{ dateFormat($model->check_out_date, 'd M, Y') }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Cancelled Upto</label>
                                            <strong
                                                class="disp-below">{{ dateFormat($model->cancelled_date, 'd M, Y') }}</strong>
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
                                            <label for="account-username">Rating</label>
                                            <strong class="disp-below">{{ $model->rating }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Payment</label>
                                            <strong class="disp-below">{{ $model->payment == 1 ? 'Yes' : 'No' }}</strong>
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
                                            <label for="account-username">Guest Lead</label>
                                            <strong class="disp-below">{{ $model->guest_lead }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label for="account-username">Guest Phone</label>
                                            <strong class="disp-below">{{ $model->guest_phone }}</strong>
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
                                            <label for="account-username">Deadline Date</label>
                                            <strong
                                                class="disp-below">{{ dateFormat($model->deadline_date, 'd M, Y') }}</strong>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
