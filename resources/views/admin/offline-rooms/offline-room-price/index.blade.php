@extends('admin.layout.app')
@section('page_title', 'Offline Rooms')
@section('content')
    <!-- users list start -->
    <div class="card-header border-bottom d-flex justify-content-between align-items-center my-2">
   
        <div class="col-md-6">
            <a class="btn btn-outline-secondary waves-effect" href="{{ route('view-room', $model->id) }}">Back</a>
        </div>
        <div class="col-md-6 text-right">                        
            <a href="{{ route('add-room-price', $model) }}" class="btn btn-primary btn-sm waves-effect waves-float waves-light" data-toggle="tooltip" data-original-title="Add New Room Price" data-animation="false"><i class="fa fa-plus" aria-hidden="true"></i></a>        
        </div>     
    </div>
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">

                <div class="col-md-6">
                    <h4 class="card-title">Offline Room Price</h4>
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
                            <th>Price Type</th>
                            <th>Travel Date Validity</th>
                            <th>Booking Date Validity</th>
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
    <!-- END: Page JS-->
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            var dt_filter_table = $('.dt-column-search');

            if (dt_filter_table.length) {
                // Setup - add a text input to each footer cell
                $('.dt-column-search thead tr').clone(true).appendTo('.dt-column-search thead');
                $('.dt-column-search thead tr:eq(0) th').each(function(i) {
                    var title = $(this).text();

                    if (i == 0 || i == 7) {
                        $(this).html('');
                    } else if (i == 4) {
                        $(this).html(
                            '<select name="price_type" class="form-control form-control-sm" id="price_type"><option value="">Select Price Type</option><option value="1">NORMAL</option><option value="3">PROMOTIONAL</option><option value="2">BLACKOUT SALE</option><option value="0">STOPSALE</option></select>'
                        );
                        $('select', this).on('change', function() {
                            if (room_table.column(i).search() !== this.value) {
                                room_table.column(i).search(this.value).draw();
                            }
                        });
                    } else if (i == 5) {
                        $(this).html('');
                        // $(this).html(
                        //     '<div class="input-group input-daterange"><input type="text" name="start_date" class="form-control form-control-sm flatpickr-basic flatpickr-input"/><div class="input-group-addon" style="margin-top: 5px;">to</div><input type="text" name="end_date" class="form-control form-control-sm flatpickr-basic flatpickr-input"/></div>'
                        //     );
                    } else if (i == 6) {
                        $(this).html('');
                        //$(this).html('<div class="input-group input-daterange"><input type="text" name="start_date" class="form-control form-control-sm flatpickr-basic flatpickr-input"/><div class="input-group-addon" style="margin-top: 5px;">to</div><input type="text" name="end_date" class="form-control form-control-sm flatpickr-basic flatpickr-input"/></div>');
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
                ajax: "{{ route('view-room-price', $model) }}",
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
                        data: 'price_type',
                        name: 'price_type'
                    },
                    {
                        data: 'from_date',
                        name: 'from_date'
                    },
                    {
                        data: 'booking_start_date',
                        name: 'booking_start_date'
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
            });
        });
    </script>
@endsection
