@extends('admin.layout.app')
@section('page_title', __('city/city.list_page_title'))
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">{{ __('city/city.list_page_title') }}</h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-outline-primary waves-effect" id="DownloadCities">
                        {{ __('core.download_sample') }}
                    </button>
                    <button type="button" class="btn btn-outline-primary waves-effect" data-toggle="modal"
                        data-target="#ImportCities" data-backdrop="false">
                        {{ __('core.import_excel') }}
                    </button>
                    <a href="{{ route('cities.create') }}"><button type="reset"
                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">{{ __('city/city.add_new') }}</button></a>
                </div>
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>{{ __('city/city.table_city') }}</th>
                            <th>{{ __('city/city.table_state') }}</th>
                            <th>{{ __('city/city.table_country') }}</th>
                            <th>{{ __('core.table_status') }}</th>
                            <th>{{ __('core.table_action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- list section end -->
    </section>
    <!-- users list ends -->
    <div class="modal fade text-left" id="ImportCities" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{{ __('city/city.modal_title') }}</h4>
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
                                    <form action="{{ route('importsCities') }}" class="dropzone dropzone-area"
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
                    <button type="button" id="import-cities" class="btn btn-primary">{{ __('core.import') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-script')
    <script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script type="text/javascript">
        var table = "";
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
                ajax: "{{ route('cities.index') }}",
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'state_id',
                        name: 'state_id'
                    },
                    {
                        data: 'country_id',
                        name: 'country_id'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                    title: "{{ __('city/message.swal_title_are_you_sure') }}",
                    text: "{{ __('city/message.swal_text_are_you_sure') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "{{ __('core.cancel') }}",
                    confirmButtonText: "{{ __('city/message.swal_confirm_button_text_are_you_sure') }}",
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
                    city_id = $this.data('city_id'),
                    status = $this.data('status'),
                    message = status == 1 ? "{{ __('city/message.swal_confirm_message_deactive') }}" :
                    "{{ __('city/message.swal_confirm_message_active') }}";


                Swal.fire({
                    title: "{{ __('city/message.swal_update_title_are_you_sure') }}",
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
                            url: "{{ route('change-city-status') }}",
                            dataType: 'json',
                            data: {
                                city_id: city_id,
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

        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
            autoProcessQueue: false,
            maxFilesize: 1,
            acceptedFiles: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            success: function(file, response) {
                table.ajax.reload();
                $('#ImportCities').modal('hide');
                myDropzone.destroy();
                Swal.fire(
                    'Excel import success!',
                    response.message,
                    'success'
                )
            }
        });
        $('#import-cities').click(function() {
            myDropzone.processQueue();
        });

        $(document).on('click', '#DownloadCities', function() {
            var link = "{{ asset('sample-file/Cities-Sample.xlsx') }}";
            var element = document.createElement('a');
            element.setAttribute('href', link);
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        });
    </script>
@endsection
