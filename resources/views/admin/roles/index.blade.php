@extends('admin.layout.app')
@section('page_title','Roles')
@section('content')
<!-- users list start -->
<section class="app-user-list">
    <!-- users filter end -->
    <!-- list section start -->
    <div class="card">

        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
          <h4 class="card-title">Roles</h4>
           @if($user->can('role-create'))
            <a href="{{ route('roles.create') }}"><button type="reset" class="btn btn-primary mr-1 waves-effect waves-float waves-light">New Role</button></a>
            @endif
        </div>
        <div class="card-datatable pt-0 table-responsive">
            <table class="user-list-table datatables-ajax table">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Actions</th>
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
            order: [[1, 'desc']],
            ajax: "{{ route('roles.index') }}",
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
                    data: 'slug',
                    name: 'slug'
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
        }).on('click', '.status_update', function(e){
            e.preventDefault();
                var $this   = $(this),
                userId  = $this.data('user_id'),
                status  = $this.data('status'),
                message = status == 1 ? 'Are you sure you want to deactivate role?' : 'Are you sure you want to activate role?';

          
            Swal.fire({
                title: 'Update role status',
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
                    url:"{{route('change-role-status')}}",
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