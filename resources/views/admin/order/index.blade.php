@extends('admin.layout.app')
@section('page_title', 'Hotel Orders')
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
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title">Hotel Orders List</h4>              
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>PNR No.</th>                          
                            <th>{{ __('core.status') }}</th>
                            <th>Booking Date</th>                            
                            <th>Lead Guest</th>
                            <th>Passenger Details</th>
                            
                            <th>Payment Received</th>
                            <th>{{ __('core.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
        <!-- list section end -->
    </section>
    <!-- users list ends -->
@endsection

@section('extra-script')
    <script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            var table = $('.user-list-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                order: [
                    [1, 'desc']
                ],
                ajax: "{{ route('orders.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'prn_number',                        
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                  
                        data: 'passenger_type',
                        name: 'passenger_type'
                    },
                    {
                        data: 'pax',
                        name: 'pax'
                    },                   
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                "createdRow": function(row, data, dataIndex) {
                    Survey.Utils.dtAnchorToForm(row);
                }
            }).on('click', '.delete_action', function(e) {
                e.preventDefault();
                var $this = $(this);
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won`t be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "{{ __('core.cancel') }}",
                    confirmButtonText: "Yes, delete it!",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        $this.find("form").trigger('submit');
                    }
                });
            }).on('click', '.Generate_action', function(e) {

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
                            
                            $.blockUI({ message: null, overlayCSS: { backgroundColor: '#F8F8F8' } });
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
            }).on('click', '.status_update', function(e) {
                e.preventDefault();
                var $this = $(this),
                    order_id = $this.data('order_id'),
                    status = $this.data('status'),
                    message = status == 1 ?
                    "Are you sure you want to deactivate order?" :
                    "Are you sure you want to activate order?";
                Swal.fire({
                    title: "Update order status",
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "{{ __('core.cancel') }}",
                    confirmButtonText: "{{ __('core.yes') }}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('change-order-status') }}",
                            dataType: 'json',
                            data: {
                                order_id: order_id,
                                status: status
                            },
                            success: function(data) {
                                if (data.status) {
                                    table.ajax.reload();
                                }
                            }

                        });
                    }
                });

                return false;
            });
        });
    </script>
@endsection