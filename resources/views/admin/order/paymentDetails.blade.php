@extends('admin.layout.app')
@section('page_title', 'Order Payment')
@section('content')
    <section id="page-account-settings">
        <div class="row">
            <div class="card col-12">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div class="col-md-6">
                        <h4 class="card-title">Payment Details</h4>
                    </div>

                    <div class="col-md-6 text-right">
                        Balance Remaining: <h4 class="mb-0 ml-75">
                            {{ numberFormat($model->booking_payment->remaining_amount, $model->booking_currency) }}</h4>

                    </div>
                </div>
                <div class="card-body mt-3">
                    <form method="post" enctype="multipart/form-data" action="{{ route('update-order-payment', $model) }}">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ isset($model->id) ? $model->id : null }}">
                        <div class="row">
                            <div class="col-xl-3 col-md-6 col-12 mb-1">
                                <div class="form-group">
                                    <label for="basicInput">Total Booking Amount</label>
                                    <input type="text" class="form-control" id="basicInput"
                                        value="{{ numberFormat($model->booking_payment->total_amount, $model->booking_currency) }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12 mb-1">
                                <div class="form-group">
                                    <label for="basicInput">Paid Amount</label>
                                    <input type="text" class="form-control"
                                        value="{{ numberFormat($model->booking_payment->paid_amount, $model->booking_currency) }}"
                                        disabled>
                                </div>
                            </div>

                            @if ($model->booking_payment->remaining_amount > 0)
                                <div class="col-xl-3 col-md-6 col-12 mb-1">
                                    <div class="form-group">
                                        <label for="basicInput">Advance Amount</label>
                                        <input type="text" class="form-control" id="basicInput" name="paid_amount"
                                            placeholder="Advance Amount" value=""
                                            onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')">
                                        @error('paid_amount')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 col-12">

                                    <button type="submit" id="user-save" class="btn btn-primary mt-2"><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.update') }}</span></button>
                                </div>
                            @endif

                        </div>
                    </form>
                    <a class="btn btn-outline-secondary waves-effect"
                        href="{{ route('orders.index') }}">{{ __('core.back') }}</a>
                    @if ($model->mail_sent == 1)
                        <a target="_blank" class="btn btn btn-info waves-effect"
                            href="{{ url('storage/app/public/order/' . $model->id . '/vouchers/order-vouchers-' . $model->id . '.pdf') }}"><i
                                class="fa fa-cloud-download" aria-hidden="true"></i> Voucher</a>
                        {{-- <a class="btn btn btn-info waves-effect" href="{{ route('order-itinerary', $model) }}"><i
                                class="fa fa-cloud-download" aria-hidden="true"></i> Itinerary</a> --}}
                        <a class="btn btn btn-info waves-effect" href="{{ route('order-invoice', $model) }}"><i
                                class="fa fa-cloud-download" aria-hidden="true"></i> Invoice</a>
                    @else
                        <a class="btn btn btn-info waves-effect Generate_action" data-order-id="{{ $model->id }}"
                            href="javascript:void(0);">Generate
                            voucher &
                            send mail</a>
                    @endif


                </div>
            </div>
        </div>
    </section>
@endsection




@section('extra-script')

    <script type="text/javascript">
        $(function() {
            var order_id = "{!! $model->id !!}"
            $(document).on('click', '.Generate_action', function () {
            
               
                $('<form action="{!! route('order-voucher-download') !!}" method="POST">' +
                    '<input type="hidden" name="_token" value="' +
                    $('meta[name="csrf-token"]').attr('content') + '" />' +
                    '<input type="hidden" name="order_id" value="' + order_id + '" />' +
                    '</form>').appendTo('body').submit();
            });
        });
    </script>
@endsection
