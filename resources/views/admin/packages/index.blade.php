@extends('admin.layout.app')
@section('page_title', 'Packages')
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">

                <div class="col-md-6">
                    <h4 class="card-title">Packages</h4>
                </div>
                <div class="col-md-6 text-right">
                    {{-- <button type="button" class="btn btn-outline-primary waves-effect" id="DownloadAgent">
                        {{ __('core.download_sample') }}
                    </button>
                    
                    <a href="{{ route('agentExport') }}" class="btn btn-outline-primary waves-effect">
                        Export Excel
                    </a>
                    <button type="button" class="btn btn-outline-primary waves-effect" data-toggle="modal"
                        data-target="#ImportAgentss" data-backdrop="false">
                        {{ __('core.import_excel') }}
                    </button> --}}
                    <a href="{{ route('packages.create') }}"><button type="reset"
                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">Add New</button></a>
                </div>
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>Package Name</th>
                            <th>Code</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>From Date</th>
                            <th>End Date</th>
                            <th>Max PAX</th>
                            <th>{{ __('core.status') }}</th>
                            <th>{{ __('core.table_action') }}</th>
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
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            var table = $('.user-list-table').DataTable({
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
                ajax: "{{ route('packages.index') }}",
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
                        data: 'package_name',
                        name: 'package_name'
                    },
                    {
                        data: 'package_code',
                        name: 'package_code'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'valid_from',
                        name: 'valid_from'
                    },
                    {
                        data: 'valid_till',
                        name: 'valid_till'
                    },
                    {
                        data: 'maximum_pax',
                        name: 'maximum_pax'
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
                    package_id = $this.data('package_id'),
                    status = $this.data('status'),
                    message = status == 1 ?
                    "Are you sure you want to deactivate package?" :
                    "Are you sure you want to activate package?";
                Swal.fire({
                    title: "Update Package status",
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
                            url: "{{ route('change-package-status') }}",
                            dataType: 'json',
                            data: {
                                package_id: package_id,
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
