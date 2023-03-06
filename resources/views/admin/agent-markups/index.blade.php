@extends('admin.layout.app')
@section('page_title', __('agent-markup/agent-markup.list_page_title'))
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('agent-markup/agent-markup.list_page_title') }}</h4>
                @if($user->can('agent-markup-create'))
                <a href="{{ route('agentmarkups.create') }}"><button type="reset"
                        class="btn btn-primary mr-1 waves-effect waves-float waves-light">{{ __('agent-markup/agent-markup.add_new') }}</button></a>
                @endif
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>{{ __('agent-markup/agent-markup.table_agent_markup_code') }}</th>
                            <th>{{ __('agent-markup/agent-markup.table_agent_markup_rezlive_markup') }}</th>
                            <th>{{ __('agent-markup/agent-markup.table_agent_markup_offline_hotel_markup') }}</th>
                            <th>{{ __('agent-markup/agent-markup.table_agent_markup_sightseeing_markup') }}</th>
                            <th>{{ __('agent-markup/agent-markup.table_agent_markup_transfer_markup') }}</th>
                            <th>{{ __('agent-markup/agent-markup.table_agent_markup_package_markup') }}</th>
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
                ajax: "{{ route('agentmarkups.index') }}",
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
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'rezlive',
                        name: 'rezlive'
                    },
                    {
                        data: 'offline_hotel',
                        name: 'offline_hotel'
                    },
                    {
                        data: 'sightseeing',
                        name: 'sightseeing'
                    },
                    {
                        data: 'transfer',
                        name: 'transfer'
                    },
                    {
                        data: 'package',
                        name: 'package'
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
                    title: "{{ __('agent-markup/message.swal_title_are_you_sure') }}",
                    text: "{{ __('agent-markup/message.swal_text_are_you_sure') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "{{ __('core.cancel') }}",
                    confirmButtonText: "{{ __('agent-markup/message.swal_confirm_button_text_are_you_sure') }}",
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
                    agent_markup_id = $this.data('agent_markup_id'),
                    status = $this.data('status'),
                    message = status == 1 ?
                    "{{ __('agent-markup/message.swal_confirm_message_deactive') }}" :
                    "{{ __('agent-markup/message.swal_confirm_message_active') }}";


                Swal.fire({
                    title: "{{ __('agent-markup/message.swal_update_title_are_you_sure') }}",
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
                            url: "{{ route('change-agent-markup-status') }}",
                            dataType: 'json',
                            data: {
                                agent_markup_id: agent_markup_id,
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
