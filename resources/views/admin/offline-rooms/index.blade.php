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
                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">Add New</button></a>
                </div>
            </div>

            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>Hotel Name</th>
                            <th>Room Type</th>
                            <th>Adult</th>
                            <th>CWB</th>
                            <th>CNB</th>
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
            var table = $('.user-list-table').DataTable({
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
                        name: 'hotel_name'
                    },
                    {
                        data: 'room_type',
                        name: 'room_type'
                    },
                    {
                        data: 'total_adult',
                        name: 'total_adult'
                    },
                    {
                        data: 'total_cwb',
                        name: 'total_cwb'
                    },
                    {
                        data: 'total_cnb',
                        name: 'total_cnb'
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
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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