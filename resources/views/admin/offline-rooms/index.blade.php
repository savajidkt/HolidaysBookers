@extends('admin.layout.app')
@section('page_title', 'Offline Rooms')
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">

                <div class="col-md-6">
                    <h4 class="card-title">Offline Rooms</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('offlinerooms.create') }}"><button type="reset"
                            class="btn btn-primary btn-sm mr-1 waves-effect waves-float waves-light">Add New</button></a>
                </div>
            </div>

            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table dt-column-search">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>Hotel Name</th>
                            <th>Room Type</th>
                            <th>Max Occupancy</th>
                            <th>No. of Beds</th>
                            <th>Max Adults</th>
                            <th>Status</th>
                            <th>Action</th>
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
            var dt_filter_table = $('.dt-column-search');

            if (dt_filter_table.length) {
                // Setup - add a text input to each footer cell
                $('.dt-column-search thead tr').clone(true).appendTo('.dt-column-search thead');
                $('.dt-column-search thead tr:eq(0) th').each(function(i) {
                    var title = $(this).text();
                    
                    if (i == 0) {

                    } else if (i == 7) {
                        $(this).html(
                            '<select name="status" class="form-control form-control-sm" id="status"><option value="">Select Status</option><option value="1"> Active</option><option value="0"> Inactive</option></select>'
                            );
                        $('select', this).on('change', function() {
                            if (room_table.column(i).search() !== this.value) {
                                room_table.column(i).search(this.value).draw();
                            }
                        });
                    } else if (i == 8) {
                        $(this).html('');
                    } else {
                        $(this).html(
                            '<input type="text" class="form-control form-control-sm" placeholder="Search ' +
                            title + '" />');
                        $('input', this).on('keyup change', function() {
                            if (room_table.column(i).search() !== this.value) {
                                room_table.column(i).search(this.value).draw();
                            }
                        });
                    }
                });
            }

            var room_table = $('.user-list-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                order: [
                    [1, 'desc']
                ],
                ajax: "{{ route('offlinerooms.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        visible: false,
                    },
                    {
                        data: 'hotel_name',
                        name: 'hotel_name',
                    },
                    {
                        data: 'room_type',
                        name: 'room_type'
                    },
                    {
                        data: 'occ_sleepsmax',
                        name: 'occ_sleepsmax'
                    },
                    {
                        data: 'occ_num_beds',
                        name: 'occ_num_beds'
                    },
                    {
                        data: 'occ_max_adults',
                        name: 'occ_max_adults'
                    },
                    {
                        data: 'status',
                        name: 'status',                        
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
                    offline_room_id = $this.data('offline_room_id'),

                    status = $this.data('status'),
                    message = status == 1 ?
                    "Are you sure you want to deactivate room?" :
                    "Are you sure you want to activate room?";


                Swal.fire({
                    title: "Update Room status",
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
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('change-offline-room-status') }}",
                            dataType: 'json',
                            data: {
                                offline_room_id: offline_room_id,
                                status: status
                            },
                            success: function(data) {
                                if (data.status) {
                                    room_table.ajax.reload();
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
