@extends('admin.layout.app')
@section('page_title', __('country/listing.title'))
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('country/listing.title') }}</h4>
                <a href="{{ route('countries.create') }}"><button type="reset" class="btn btn-primary mr-1 waves-effect waves-float waves-light">New Country</button></a>
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>{{ __('country/listing.name') }}</th>
                            <th>{{ __('country/listing.code') }}</th>
                            <th>{{ __('country/listing.phonecode') }}</th>
                            <th>{{ __('country/listing.nationality') }}</th>
                            <th>{{ __('country/listing.status') }}</th>
                            <th>{{ __('country/listing.action') }}</th>
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
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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
                    country_type_id = $this.data('country_type_id'),
                    status = $this.data('status'),
                    message = status == 1 ? 'Are you sure you want to deactivate country?' :
                    'Are you sure you want to activate country?';


                Swal.fire({
                    title: 'Update country status',
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
