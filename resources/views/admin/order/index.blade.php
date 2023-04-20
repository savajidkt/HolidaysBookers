@extends('admin.layout.app')
@section('page_title', 'Hotel Orders')
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title">Hotel Orders List</h4>
                @if ($user->can('reach-us-create'))
                    <a href="{{ route('reachus.create') }}"><button type="reset"
                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">{{ __('reach-us/reach-us.add_new') }}</button></a>
                @endif
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>PNR No.</th>
                            <th>Hotel Name</th>
                            <th>City</th>
                            <th>Booking Date</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Lead Guest</th>
                            <th>Cancel Upto</th>
                            <th>No. Of Rooms</th>
                            <th>Total Nights</th>
                            <th>Hotel Supplier</th>
                            <th>HCN</th>
                            <th>Agency Name</th>
                            <th>Agency Code</th>
                            <th>Remarks</th>
                            <th>Pay Received</th>
                            <th>Sales</th>
                            <th>Purchase</th>
                            <th>Profit</th>
                            <th>Currency</th>
                            <th>{{ __('core.status') }}</th>
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
                        data: 'prn_no',
                        visible: false,
                    },
                    {
                        data: 'country_id',
                        name: 'country_id'
                    },
                    {
                        data: 'city_id',
                        name: 'city_id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'check_in_date',
                        name: 'check_in_date'
                    },
                    {
                        data: 'check_out_date',
                        name: 'check_out_date'
                    },
                    {
                        data: 'guest_lead',
                        name: 'guest_lead'
                    },
                    {
                        data: 'cancelled_date',
                        name: 'cancelled_date'
                    },
                    {
                        data: 'total_rooms',
                        name: 'total_rooms'
                    },
                    {
                        data: 'total_nights',
                        name: 'total_nights'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'agent_code',
                        name: 'agent_code'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: false
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
