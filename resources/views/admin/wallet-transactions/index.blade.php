@extends('admin.layout.app')
@section('page_title', 'Agent Transactions')
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">Agent Transactions : #{{ $model->agent_code }}</h4>
                </div>
                <div class="col-md-6 text-right">
                    
                    <a href="{{ route('agents.index') }}"><button type="reset"
                            class="btn btn-outline-secondary waves-effectt">
                            {{ __('core.back') }}</button></a>
                   <button type="reset"
                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">Balance:
                            {{ availableBalance($model->id) }}</button>
                </div>
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>Transaction Type</th>
                            <th>PNR</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Comment</th>
                            <th>Created At</th>
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
                ajax: "{{ route('list-hb-credit', $model) }}",
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
                        data: 'transaction_type',
                        name: 'transaction_type'
                    },
                    {
                        data: 'pnr',
                        name: 'pnr'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'comment',
                        name: 'comment'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ],
                "createdRow": function(row, data, dataIndex) {
                    Survey.Utils.dtAnchorToForm(row);
                }
            })
        });
    </script>
@endsection
