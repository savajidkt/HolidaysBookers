@extends('admin.layout.app')
@section('page_title', __('country/country.list_page_title'))
@section('content')   
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">{{ __('country/country.list_page_title') }}</h4>
                </div>
                <div class="col-md-6 text-right">

                    <button type="button" class="btn btn-outline-primary waves-effect" id="DownloadCountries">
                        {{ __('core.download_sample') }}
                    </button>
                    <button type="button" class="btn btn-outline-primary waves-effect" data-toggle="modal"
                        data-target="#ImportCountries" data-backdrop="false">
                        {{ __('core.import_excel') }}
                    </button>


                    <a href="{{ route('countries.create') }}"><button type="reset"
                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">{{ __('country/country.add_new') }}</button></a>
                </div>
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>{{ __('country/country.table_country_name') }}</th>
                            <th>{{ __('country/country.table_country_code') }}</th>
                            <th>{{ __('country/country.table_country_phone_code') }}</th>
                            <th>{{ __('country/country.table_nationality') }}</th>
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
    <div class="modal fade text-left" id="ImportCountries" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{{ __('country/country.modal_title') }}</h4>
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
                                    <form action="{{ route('importsCountries') }}" class="dropzone dropzone-area"
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
                    <button type="button" id="import-countries" class="btn btn-primary">{{ __('core.import') }}</button>
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
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
            autoProcessQueue: false,
            maxFilesize: 1,
            acceptedFiles: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            success: function(file, response) {
                table.ajax.reload();
                $('#ImportCountries').modal('hide');
                myDropzone.destroy();
                Swal.fire(
                    'Excel import success!',
                    response.message,
                    'success'
                )
            }
        });
        $('#import-countries').click(function() {
            myDropzone.processQueue();
        });

        $(document).on('click', '#DownloadCountries', function() {
            var link = "{{ asset('sample-file/Countries-Sample.xlsx') }}";
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
                ajax: "{{ route('countries.index') }}",
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
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'phone_code',
                        name: 'phone_code'
                    },
                    {
                        data: 'nationality',
                        name: 'nationality'
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
                    title: "{{ __('country/message.swal_title_are_you_sure') }}",
                    text: "{{ __('country/message.swal_text_are_you_sure') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "{{ __('core.cancel') }}",
                    confirmButtonText: "{{ __('country/message.swal_confirm_button_text_are_you_sure') }}",
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
                    country_type_id = $this.data('country_type_id'),
                    status = $this.data('status'),
                    message = status == 1 ? "{{ __('country/message.swal_confirm_message_deactive') }}" :
                    "{{ __('country/message.swal_confirm_message_active') }}";


                Swal.fire({
                    title: "{{ __('country/message.swal_update_title_are_you_sure') }}",
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
                            url: "{{ route('change-country-status') }}",
                            dataType: 'json',
                            data: {
                                country_type_id: country_type_id,
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
