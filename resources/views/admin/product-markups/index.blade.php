@extends('admin.layout.app')
@section('page_title', __('product-markup/product-markup.list_page_title'))
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('product-markup/product-markup.list_page_title') }}</h4>
                @if($user->can('product-markup-create'))
                <a href="{{ route('productmarkups.create') }}"><button type="reset"
                        class="btn btn-primary mr-1 waves-effect waves-float waves-light">{{ __('product-markup/product-markup.add_new') }}</button></a>
                @endif
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>{{ __('product-markup/product-markup.table_product_markup_name') }}</th>
                            <th>{{ __('product-markup/product-markup.table_product_markup_percentage') }}</th>
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
                ajax: "{{ route('productmarkups.index') }}",
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
                        data: 'percentage',
                        name: 'percentage'
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
                    title: "{{ __('product-markup/message.swal_title_are_you_sure') }}",
                    text: "{{ __('product-markup/message.swal_text_are_you_sure') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "{{ __('core.cancel') }}",
                    confirmButtonText: "{{ __('product-markup/message.swal_confirm_button_text_are_you_sure') }}",
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
                    product_markup_id = $this.data('product_markup_id'),
                    status = $this.data('status'),
                    message = status == 1 ?
                    "{{ __('product-markup/message.swal_confirm_message_deactive') }}" :
                    "{{ __('product-markup/message.swal_confirm_message_active') }}";


                Swal.fire({
                    title: "{{ __('product-markup/message.swal_update_title_are_you_sure') }}",
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
                        var survey_id = $('#survey_id').val();
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('change-product-markup-status') }}",
                            dataType: 'json',
                            data: {
                                product_markup_id: product_markup_id,
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
