@extends('admin.layout.app')
@section('page_title', 'Customers')
@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">

                <div class="col-md-6">
                    <h4 class="card-title">Customers</h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-outline-primary waves-effect" id="DownloadCustomer">
                        {{ __('core.download_sample') }}
                    </button>
                    <a href="{{ route('customerExport') }}" class="btn btn-outline-primary waves-effect">
                        Export Excel
                    </a>
                    <button type="button" class="btn btn-outline-primary waves-effect" data-toggle="modal"
                        data-target="#CustomerImports" data-backdrop="false">
                        {{ __('core.import_excel') }}
                    </button>
                    <a href="{{ route('customers.create') }}"><button type="reset"
                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">Add New</button></a>
                </div>
            </div>

            <div class="card-datatable pt-0 table-responsive">
                <table class="user-list-table datatables-ajax table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ __('core.id') }}</th>
                            <th>Fulll Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Action</th>
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
                                <form action="{{ route('update-customer-password') }}" method="post" id="changePassword"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="updateCls" id="modal_user_id" name="modal_user_id"
                                        value="">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="password">{{ __('agent/agent.agent_password') }}</label>
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="{{ __('agent/agent.agent_password') }}" value=""
                                                data-error="{{ __('agent/agent.agent_password') }}" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="confirm_password">{{ __('agent/agent.agent_confirm_password') }}</label>
                                            <input type="password" id="confirm_password" name="confirm_password"
                                                class="form-control"
                                                placeholder="{{ __('agent/agent.agent_confirm_password') }}" value=""
                                                data-error="{{ __('agent/agent.agent_confirm_password') }}" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit"
                                            class="btn btn-primary waves-effect waves-float waves-light"><span
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

        <div class="modal fade text-left" id="CustomerImports" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Import Customers Excel</h4>
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
                                        <form action="{{ route('importsCustomers') }}" class="dropzone dropzone-area"
                                            id="dpz-single-file" enctype="multipart/form-data">
                                            @csrf
                                            <div class="dz-message">{{ __('core.drop_files') }}</div>
                                        </form>
                                        <div class="emptyDropzone help-block-error hide">Upload Customers Excel File</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- single file upload ends -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="import-customers"
                            class="btn btn-primary waves-effect waves-float waves-light"><span
                                class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                aria-hidden="true"></span><span
                                class="ml-25 align-middle">{{ __('core.import') }}</span></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users list ends -->
@endsection

{{-- model code --}}

@section('extra-script')
    <script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/form/Customer.js') }}"></script>
    <script type="text/javascript">
    
        var moduleConfig = {
            fileUrl: "{!! asset('sample-file/Customers-Sample.xlsx') !!}"
        };

        var table = "";
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
            autoProcessQueue: false,
            maxFilesize: 1,
            acceptedFiles: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            success: function(file, response) {
                table.ajax.reload();
                $('#CustomerImports').modal('hide');
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
        $('#import-customers').click(function() {   
            $("#CustomerImports .emptyDropzone").addClass('hide');        
            if (myDropzone.getQueuedFiles().length > 0) {
                $("#CustomerImports .spinner-border").removeClass('hide');
                myDropzone.processQueue();
            }
            $("#CustomerImports .emptyDropzone").removeClass('hide');
            
        });
        $(function() {
            table = $('.user-list-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                order: [
                    [1, 'desc']
                ],
                ajax: "{{ route('customers.index') }}",
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
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile_number',
                        name: 'mobile_number'
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
                    user_id = $this.data('user_id'),

                    status = $this.data('status'),
                    message = status == 1 ?
                    "Are you sure you want to deactivate Customer?" :
                    "Are you sure you want to activate Customer?";


                Swal.fire({
                    title: "Update Customer status",
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
                            url: "{{ route('change-customer-status') }}",
                            dataType: 'json',
                            data: {
                                user_id: user_id,
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
