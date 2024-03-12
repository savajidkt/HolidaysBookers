@extends('admin.layout.app')
@section('page_title', 'Edit Offline Room')
@section('content')
<div class="card-header border-bottom d-flex justify-content-between align-items-center my-2">
  
    <div class="col-md-6">
        <a class="btn btn-outline-secondary waves-effect" href="{{ route('hotel-room-list', $model->hotel_id) }}">Back</a>
    </div>  
    <div class="col-md-6 text-right">                
        <a href="{{ route('room-create', $model->hotel_id) }}" class="btn btn-primary btn-sm waves-effect waves-float waves-light" data-toggle="tooltip" data-original-title="Add New Room" data-animation="false"><i class="fa fa-plus" aria-hidden="true"></i> Add Room</a>                
        <a href="{{ route('add-room-price', $model->id) }}" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Add Room Price" data-animation="false"><i class="fa fa-plus" aria-hidden="true"></i> Add Room Price</a> 
        
    </div>  
</div>
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Edit Offline Room</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmEditOfflineRoom" class="needs-validation1" novalidate method="post"
                            enctype="multipart/form-data" action="{{ route('offlinerooms.update', $model) }}">
                            @csrf
                            @method('PUT')
                            @include('admin.offline-rooms.edit-form')
                            <div class="row">
                                <div class="col-12">
                                   
                                    <button type="submit" id="user-save" class="btn btn-primary btn-sm "><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.update') }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal fade text-left" id="roomTypeBTN" tabindex="-1" aria-labelledby="myModalLabel120"
                        aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel120">Add Room Type</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="" method="post" id="FrmroomType"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="basic-addon-room_type">{{ __('roomtype/roomtype.form_room_type') }} <span class="text-danger">*</span></label>
                                                        <input type="text" id="basic-addon-room_type" name="room_type"
                                                            class="form-control" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                                            placeholder="{{ __('roomtype/roomtype.form_room_type') }}"
                                                            value="" aria-describedby="basic-addon-room_type"
                                                            data-error="{{ __('roomtype/message.room_type_required') }}" />
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-float waves-light"><span
                                                            class="spinner-border spinner-border-sm buttonLoader hide"
                                                            role="status" aria-hidden="true"></span><span
                                                            class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                  

                    <div class="modal fade text-left" id="roomAmenityBTN" tabindex="-1" aria-labelledby="myModalLabel120"
                        aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel120">Add Amenity</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="" method="post" id="FrmroomAmenity"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="basic-addon-amenity_name">Amenity Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="basic-addon-amenity_name"
                                                            name="amenity_name" class="form-control"
                                                            placeholder="Amenity Name" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                                            value="" aria-describedby="basic-addon-amenity_name"
                                                            data-error="Amenity name is required." />

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-float waves-light"><span
                                                            class="spinner-border spinner-border-sm buttonLoader hide"
                                                            role="status" aria-hidden="true"></span><span
                                                            class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade text-left" id="roomFreebiesBTN" tabindex="-1"
                            aria-labelledby="myModalLabel120" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel120">Add Freebies</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="" method="post" id="FrmFreebies"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="basic-addon-name">Freebies
                                                                Name <span class="text-danger">*</span></label>
                                                            <input type="text" id="basic-addon-name" name="name"
                                                                class="form-control" placeholder="Freebies Name" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                                                value="" aria-describedby="basic-addon-name"
                                                                data-error="Freebies name is required." />

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm waves-effect waves-float waves-light"><span
                                                                class="spinner-border spinner-border-sm buttonLoader hide"
                                                                role="status" aria-hidden="true"></span><span
                                                                class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                                    </div>
                                                </form>
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
    <section class="form-control-repeater">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Room Price</h4>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable pt-10 table-responsive">
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
                </div>
            </div>
        </div>
    </section>

    @endsection

   
<script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            // var dt_filter_table = $('.dt-column-search');

            // if (dt_filter_table.length) {
            //     // Setup - add a text input to each footer cell
            //     $('.dt-column-search thead tr').clone(true).appendTo('.dt-column-search thead');
            //     $('.dt-column-search thead tr:eq(0) th').each(function(i) {
            //         var title = $(this).text();

            //         if (i == 0 || i == 7) {
            //             $(this).html('');
            //         } else if (i == 4) {
            //             $(this).html(
            //                 '<select name="price_type" class="form-control form-control-sm" id="price_type"><option value="">Select Price Type</option><option value="1">NORMAL</option><option value="3">PROMOTIONAL</option><option value="2">BLACKOUT SALE</option><option value="0">STOPSALE</option></select>'
            //             );
            //             $('select', this).on('change', function() {
            //                 if (room_table.column(i).search() !== this.value) {
            //                     room_table.column(i).search(this.value).draw();
            //                 }
            //             });
            //         } else if (i == 5) {
            //             $(this).html('');
            //             // $(this).html(
            //             //     '<div class="input-group input-daterange"><input type="text" name="start_date" class="form-control form-control-sm flatpickr-basic flatpickr-input"/><div class="input-group-addon" style="margin-top: 5px;">to</div><input type="text" name="end_date" class="form-control form-control-sm flatpickr-basic flatpickr-input"/></div>'
            //             //     );
            //         } else if (i == 6) {
            //             $(this).html('');
            //             //$(this).html('<div class="input-group input-daterange"><input type="text" name="start_date" class="form-control form-control-sm flatpickr-basic flatpickr-input"/><div class="input-group-addon" style="margin-top: 5px;">to</div><input type="text" name="end_date" class="form-control form-control-sm flatpickr-basic flatpickr-input"/></div>');
            //         } else {
            //             $(this).html(
            //                 '<input type="text" class="form-control form-control-sm" placeholder="Search ' +
            //                 title + '" />');
            //             $('input', this).on('keyup change', function() {
            //                 if (room_table.column(i).search() !== this.value) {
            //                     room_table.column(i).search(this.value).draw();
            //                 }
            //             });
            //         }
            //     });
            // }           

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
