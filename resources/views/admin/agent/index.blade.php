@extends('admin.layout.app')
@section('page_title',__('agent/agent.title'))
@section('content')    
<!-- users list start -->
<section class="app-user-list">
    <!-- users filter end -->
    <!-- list section start -->
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
          <h4 class="card-title">{{__('agent/agent.title')}}</h4>
          <a href="{{ route('agents.create') }}"><button type="reset" class="btn btn-primary mr-1 waves-effect waves-float waves-light">{{__('agent/agent.add_new')}}</button></a>
        </div>
        <div class="card-datatable pt-0 table-responsive">
            <table class="user-list-table datatables-ajax table">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>{{__('core.id')}}</th>
                        <th>{{__('agent/agent.code')}}</th>
                        <th>{{__('agent/agent.company')}}</th>
                        <th>{{__('agent/agent.contact_person')}}</th>
                        <th>{{__('agent/agent.phone')}}</th>
                        <th>{{__('agent/agent.email')}}</th>
                        <th>{{__('agent/agent.username')}}</th>
                        <th>{{__('agent/agent.balance')}}</th>
                        <th>{{__('core.status')}}</th>
                        <th>{{__('core.table_action')}}</th>
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
            order: [[1, 'desc']],
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
                    data: 'agent_code',
                    name: 'agent_code'
                },
                {
                    data: 'agent_company_name',
                    name: 'agent_company_name'
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'agent_mobile_number',
                    name: 'agent_mobile_number'
                },
                {
                    data: 'agent_email',
                    name: 'agent_email'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'balance',
                    name: 'balance'
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
                title: '{{__("swal_title_are_you_sure")}}',
                text: '{{__("swal_text_are_you_sure")}}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{__("swal_confirm_button_text_are_you_sure")}}',
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
        }).on('click', '.status_update', function(e){
            e.preventDefault();
                var $this   = $(this),
                userId  = $this.data('user_id'),
                status  = $this.data('status'),
                message = status == 1 ? '{{__("swal_confirm_message_deactive")}}' : '{{__("swal_confirm_message_active")}}';
            Swal.fire({
                title: '{{__("swal_update_title_are_you_sure")}}',
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
                    var survey_id = $('#survey_id').val();
                    $.ajax({
                    type:'POST',
                    url:"{{route('change-agent-status')}}",
                    dataType:'json',
                    data:{user_id:userId, status: status},
                    success:function(data){
                        if(data.status)
                        {
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