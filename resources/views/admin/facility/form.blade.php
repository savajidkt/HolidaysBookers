<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Name <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-name" name="name" class="form-control"
                placeholder="Hotel Facility name" 
                onkeydown="return /[a-zA-Z ]/.test(event.key)" 
                oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);"
                value="{{ isset($model->name) ? $model->name : old('name') }}"
                aria-describedby="basic-addon-name"
                data-error="Hotel facility name is required." />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="type">Type <span class="text-danger">*</span></label>
            <select name="type" class="select2 form-control" id="type" data-minimum-results-for-search="Infinity"
                data-error="Hotel facility type is required.">
                <option value="0" {{ $model->type == 0 ? 'selected' : '' }}>
                    Both</option>
                <option value="1" {{ $model->type == 1 ? 'selected' : '' }}>
                    Hotel</option>
                <option value="2" {{ $model->type == 2 ? 'selected' : '' }}>
                    Room</option>
                
            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            <span id="type_id"></span>
            @error('type')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Icon </label>
            <input type="file" id="basic-addon-name" name="icon" class="form-control" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @if (strlen($model->icon) > 0)            
                <img src="<?php echo url("storage/app/public/facility-icon/$model->icon")?>" style="width:50px;">
            @endif            
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">Status <span class="text-danger">*</span></label>
            <select name="status" class="select2 form-control" id="status" data-minimum-results-for-search="Infinity" data-error="Status is required">
                <option value="">Select Status</option>
                <option value="1" {{ (isset($model->id) && $model->status == 1) ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ (isset($model->id) && $model->status == 0) ? 'selected' : '' }}> {{ __('core.inactive') }}
                </option>
            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            <span id="status_id"></span>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
<script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
    <script src="{{ asset('js/form/HotelFacility.js') }}"></script>
    <script>
        $('#type').on('change', function() {
            var selected_option_value = $(this).find(":selected").val();
            if (selected_option_value == '') {
                $('#type-error').show();
                $('#type').addClass('error');
            } else {
                $('#type-error').hide();
                $('#type').removeClass('error');
            }
        }); 

        $('#status').on('change', function() {
            var selected_option_value = $(this).find(":selected").val();
            if (selected_option_value == '') {
                $('#status-error').show();
                $('#status').addClass('error');
            } else {
                $('#status-error').hide();
                $('#status').removeClass('error');
            }
        });
    </script>
    <script type="text/javascript">
        $(function() {
            var RequestURL = "{{ route('hotelfacilities.index') }}";            
            var table = $('.user-list-table').DataTable({                
                processing: true,
                serverSide: true,
                searching: true,
                order: [
                    [1, 'desc']
                ],                
                ajax: RequestURL+'?facility_id='+{!! $model->id !!},                
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
                facilities_id = $this.data('facilities_id'),
                    status = $this.data('status'),
                    message = status == 1 ?
                    "Are you sure you want to deactivate facility?" :
                    "Are you sure you want to activate facility?";


                Swal.fire({
                    title: "Update facility status",
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
                            url: "{{ route('change-hotelfacilities-status') }}",
                            dataType: 'json',
                            data: {
                                facilities_id: facilities_id,
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
