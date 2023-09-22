<div class="row">
    <div class="col-md-4 col-12">
        <div class="col-md-12">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="basic-addon-name">First Name <span class="text-danger">*</span></label>
                    <input type="text" id="basic-addon-name" name="fullname" class="form-control" onkeydown="return /[a-z]/i.test(event.key)" placeholder="Full Name" value="{{(isset($model->name))?$model->name:old('fullname')}}" aria-describedby="basic-addon-name" data-error="Name is required" />
                    <div class="valid-feedback">Looks good!</div>
                    @error('fullname')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror

                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <input type="hidden" value="{{ isset($model->id) ? 'yes' : 'no' }}" class="editPage" id="editPage">
                    <label class="form-label" for="basic-default-email1">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="basic-default-email1" value="{{(isset($model->email))?$model->email:old('email')}}" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe@email.com" data-error="Email is required" />
                    <div class="valid-feedback">Looks good!</div>
                    @error('email')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="role">Role <span class="text-danger">*</span></label>
                    <select name="role" class="select2 form-control" id="role" data-error="Role is required">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                        @if($model->roles->count() > 0)
                        <option value="{{$role->id}}" {{($model->roles[0]->id == $role->id)? 'selected' : ''}}>{{$role->name}}</option>
                        @else
                        <option value="{{$role->id}}">{{$role->name}}</option>
                        @endif
                        @endforeach
                    </select>

                    <div class="valid-feedback">Looks good!</div>
                    <span id="role_id"></span>
                    @error('role')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror

                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    
                    @if($model->id == '')
                        <label class="form-label" for="basic-default-password1">Password  <span class="text-danger">*</span></label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="" data-error="password is required"/>
                        <div class="valid-feedback">Looks good!</div>
                        @error('password')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    @endif
                    @if($model->id != '')
                        <label class="form-label" for="basic-default-password1">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="" />
                        <div class="valid-feedback">Looks good!</div>
                        @error('password')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    
                    @if($model->id != '')
                        <label class="form-label" for="basic-default-password1">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm_password" class="form-control" placeholder="" />
                        <div class="valid-feedback">Looks good!</div>
                        @error('confirm_password')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    @endif
                    @if($model->id == '')
                        <label class="form-label" for="basic-default-password1">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" id="confirm-password" require name="confirm_password" class="form-control" placeholder="" data-error="Confirm password is required"/>
                        <div class="valid-feedback">Looks good!</div>
                        @error('confirm_password')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
            </div>
            <div class="col-12">
                @if($model->id != '')
                <div class="row">
                    <div class="col-12">
                        <a class="btn btn-outline-secondary waves-effect"
                            href="{{ route('admins.index') }}">Back</a>
                        <button type="submit" id="user-save" class="btn btn-primary">Update</button>
                    </div>
                </div>
                @endif
                @if($model->id == '')
                <div class="row">
                    <div class="col-12">
                        <a class="btn btn-outline-secondary waves-effect"
                            href="{{ route('admins.index') }}">Back</a>
                            <button type="submit" id="user-save" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
    <div class="col-md-6 col-12">
        <div class="col-12">
            <div class="form-group">
            <div class="col-6"><label class="form-label" for="basic-default-password1"><strong>Permissions</strong></label></div>
                <div class="col-6">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="selectAll" id="selectAll"/>
                        <label class="custom-control-label" for="selectAll">Select All</label>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Modules</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $key=>$permission)
                            <tr>
                                <td>{{$key}}</td>
                                @foreach($permission as $val)
                                <td>
                                <div class="demo-inline-spacing">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="permissions[]" id="permissions{{$val->id}}" value="{{$val->id}}" @if(is_array(old("permissions")) && in_array($val->id, old('permissions')) || in_array($val->id,$model->permissions()->pluck('permission_id')->toArray())) checked @endif />
                                        <label class="custom-control-label" for="permissions{{$val->id}}"></label>
                                    </div>
                                </div>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@section('extra-script')
<script>
    $('.select2').select2();
</script>
<script>
    $('#role').on('change', function() {
            var selected_option_value = $(this).find(":selected").val();
            if (selected_option_value == '') {
                $('#role-error').show();
                $('#role').addClass('error');
            } else {
                $('#role-error').hide();
                $('#role').removeClass('error');
            }
        });
</script>
<script src="{{ asset('js/form/Staff.js') }}"></script>
<script type="text/javascript">
    jQuery(function() {
       
        jQuery('#selectAll').on('click', function() {
            if($(this).prop('checked') == true){
                $('input[type="checkbox"]').prop('checked',true);
            }else{
                $('input[type="checkbox"]').prop('checked',false);
            }
            
        });

    })
</script>
@endsection