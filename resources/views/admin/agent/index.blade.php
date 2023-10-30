@extends('admin.layout.app')
@section('page_title', __('agent/agent.title'))
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">

                <div class="col-md-6">
                    <h4 class="card-title">{{ __('agent/agent.title') }}</h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-outline-primary waves-effect" id="DownloadAgent">
                        {{ __('core.download_sample') }}
                    </button>
                    
                    <a href="{{ route('agentExport') }}" class="btn btn-outline-primary waves-effect">
                        Export Excel
                    </a>
                    <button type="button" class="btn btn-outline-primary waves-effect" data-toggle="modal"
                        data-target="#ImportAgentss" data-backdrop="false">
                        {{ __('core.import_excel') }}
                    </button>
                    <a href="{{ route('agents.create') }}"><button type="reset"
                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">{{ __('agent/agent.add_new') }}</button></a>
                </div>
            </div>
            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>{{ __('agent/agent.code') }}</th>
                            <th>{{ __('agent/agent.company') }}</th>
                            <th>{{ __('agent/agent.contact_person') }}</th>
                            <th>{{ __('agent/agent.phone') }}</th>
                            <th>{{ __('agent/agent.email') }}</th>
                            <th>{{ __('agent/agent.username') }}</th>
                            <th>{{ __('agent/agent.balance') }}</th>
                            <th>{{ __('core.status') }}</th>
                            <th>{{ __('core.table_action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
        <!-- list section end -->
        <div class="modal fade text-left" id="ResetPasswordModal" tabindex="-1" aria-labelledby="myModalLabel120"
            aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel120">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('update-agent-password') }}" method="post" id="changePassword"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="updateCls" id="modal_user_id" name="modal_user_id"
                                        value="">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="password">{{ __('agent/agent.agent_password') }} <span class="text-danger">*</span></label>
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="{{ __('agent/agent.agent_password') }}" value=""
                                                data-error="{{ __('agent/agent.agent_password') }}" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="confirm_password">{{ __('agent/agent.agent_confirm_password') }} <span class="text-danger">*</span></label>
                                            <input type="password" id="confirm_password" name="confirm_password"
                                                class="form-control"
                                                placeholder="{{ __('agent/agent.agent_confirm_password') }}" value=""
                                                data-error="{{ __('agent/agent.agent_confirm_password') }}" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit"
                                            class="btn btn-primary waves-effect waves-float waves-light">{{ __('core.submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="HBCreditModal" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true"
            data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel120">HB Credit: <span>Agent Code-<strong
                                    class="agentName">CA</strong></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('update-hb-credit') }}" method="post" id="updateHBCredit"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="updateCls" id="HBCredit_user_id" name="HBCredit_user_id"
                                        value="">
                                    <input type="hidden" class="updateCls" id="HBCredit_Bal" name="HBCredit_Bal"
                                        value="">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="Type">Type <span class="text-danger">*</span></label>
                                            <select class="select2 form-control form-control-lg" name="type"
                                                data-error="Type">
                                                <option value="">Select type</option>
                                                <option value="1">HB Credit</option>
                                                <option value="0">HB Debit</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="amount">Amount <span class="text-danger">*</span></label>
                                            <input type="text" id="amount" name="amount" class="form-control"
                                                value="" data-error="Amount"
                                                onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')" />
                                            <small id="availableBal" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="comment">Comment <span class="text-danger">*</span></label>
                                            <textarea name="comment" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-float waves-light"><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.submit') }}</span></button>                                
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="ImportAgentss" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Import Agents Excel</h4>
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
                                        <form action="{{ route('importsAgents') }}" class="dropzone dropzone-area"
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
                        <button type="button" id="import-agents" class="btn btn-primary">{{ __('core.import') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users list ends -->
@endsection



@section('extra-script')
    <script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/form/Agent.js') }}"></script>

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
        $('#import-agents').click(function() {
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
                    title: '{{ __('agent/message.swal_title_are_you_sure') }}',
                    text: '{{ __('agent/message.swal_text_are_you_sure') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('agent/message.swal_confirm_button_text_are_you_sure') }}',
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
                    message = status == 1 ? '{{ __('agent/message.swal_confirm_message_deactive') }}' :
                    '{{ __('agent/message.swal_confirm_message_active') }}';
                Swal.fire({
                    title: '{{ __('agent/message.swal_update_title_are_you_sure') }}',
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
                            url: "{{ route('change-agent-status') }}",
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
