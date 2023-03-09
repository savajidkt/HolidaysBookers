@extends('admin.layout.app')
@section('page_title','Offline Hotels')
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">

                <div class="col-md-6">
                    <h4 class="card-title">Offline Hotels</h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-outline-primary waves-effect" id="DownloadOfflineHotel">
                       Download Sample
                    </button>
                    
                    <a href="{{ route('offline-hotels-export') }}" class="btn btn-outline-primary waves-effect">
                        Export Excel
                    </a>
                    <button type="button" class="btn btn-outline-primary waves-effect" data-toggle="modal"
                        data-target="#ImportOfflineHotels" data-backdrop="false">
                        Import Excel
                    </button>
                    <a href="{{ route('offlinehotels.create') }}"><button type="reset"
                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">New Hotel</button></a>
                </div>
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Hotel Name</th>
                            <th>Category</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Rating</th>
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

<div class="modal fade text-left" id="ImportOfflineHotels" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Import Offline Hotels</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- single file upload starts -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('import-offline-hotels') }}" class="dropzone dropzone-area"
                                    id="dpz-single-file" enctype="multipart/form-data">
                                    @csrf
                                    <div class="dz-message">{{ __('core.drop_files') }}</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single file upload ends -->
            </div>
            <div class="modal-footer">
                <button type="button" id="import-offline-hotels" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</div>

@section('extra-script')
    <script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/form/OfflineHotel.js') }}"></script>

    <script type="text/javascript">
        var table = "";
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
            autoProcessQueue: false,
            maxFilesize: 1,
            acceptedFiles: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            success: function(file, response) {
                table.ajax.reload();
                $('#ImportAgentss').modal('hide');
                myDropzone.destroy();
                Swal.fire({
                    title: 'Excel import success!',
                    text: response.message,
                    html: response.html,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false
                })
            }
        });
        $('#import-offline-hotels').click(function() {
            myDropzone.processQueue();
        });

        $(document).on('click', '#DownloadAgent', function() {
            var link = "{{ asset('sample-file/Agents-Sample.xlsx') }}";
            var element = document.createElement('a');
            element.setAttribute('href', link);
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        });

        $(function() {
            table = $('.user-list-table').DataTable({
                language: {
                    emptyTable: '{{ __('core.table_no_data') }}',
                    info: '{{ __('core.table_info_data') }}',
                    infoEmpty: '{{ __('core.table_infoEmpty_data') }}',
                    lengthMenu: '{{ __('core.table_lengthMenu') }}',
                    search: '{{ __('core.table_search') }}',
                    paginate: {
                        "first": '{{ __('core.table_paginate_first') }}',
                        "last": '{{ __('core.table_paginate_last') }}',
                        "next": '{{ __('core.table_paginate_next') }}',
                        "previous": '{{ __('core.table_paginate_previous') }}',
                    },
                },
                processing: true,
                serverSide: true,
                searching: true,
                order: [
                    [1, 'desc']
                ],
                ajax: "{{ route('agents.index') }}",
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
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'state',
                        name: 'state'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'hotel_email',
                        name: 'hotel_email'
                    },
                    {
                        data: 'hotel_review',
                        name: 'hotel_review',
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
                    title: 'Are you sure?',
                    text: 'You won`t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
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
                    userId = $this.data('user_id'),
                    status = $this.data('status'),
                    message = status == 1 ? 'Are you sure you want to deactivate Hotel?' :
                    'Are you sure you want to activate Hotel?';
                Swal.fire({
                    title: 'Update Hotel status',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
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
                            url: "{{ route('change-offlinehotels-status') }}",
                            dataType: 'json',
                            data: {
                                user_id: userId,
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
