<div class="row">
    <div class="col-md-4 col-12">
        <div class="col-md-12">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="basic-addon-name">First Name</label>
                    <input type="text" id="basic-addon-name" name="fullname" class="form-control" placeholder="Full Name" value="{{(isset($model->name))?$model->name:old('fullname')}}" aria-describedby="basic-addon-name" />
                    <div class="valid-feedback">Looks good!</div>
                    @error('fullname')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror

                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="basic-default-email1">Email</label>
                    <input type="email" name="email" id="basic-default-email1" value="{{(isset($model->email))?$model->email:old('email')}}" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe@email.com" />
                    <div class="valid-feedback">Looks good!</div>
                    @error('email')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="role">Role</label>
                    <select name="role" class="form-control" id="role">
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
                    @error('role')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror

                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="basic-default-password1">Password</label>
                    @if($model->id == '')
                    <input type="text" id="password" name="password" class="form-control" placeholder="" />
                    <div class="valid-feedback">Looks good!</div>
                    @error('password')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                    @endif
                    @if($model->id != '')
                    <input type="text" id="password" name="password" class="form-control" placeholder="" />
                    <div class="valid-feedback">Looks good!</div>
                    @error('password')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                    @endif
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="basic-default-password1">Confirm Password</label>
                    @if($model->id != '')
                    <input type="text" id="confirm-password" name="confirm-password" class="form-control" placeholder="" />
                    <div class="valid-feedback">Looks good!</div>
                    @error('confirm-password')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                    @endif
                    @if($model->id == '')
                    <input type="text" id="confirm-password" require name="confirm-password" class="form-control" placeholder="" />
                    <div class="valid-feedback">Looks good!</div>
                    @error('confirm-password')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                    @endif
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6 col-12">
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="basic-default-password1"><strong>Permissions</strong></label>
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
                            @foreach($permissions as $permission)
                            <tr>
                                <td>{{$permission->module}}</td>
                                <td>{{$permission->name}}</td>
                                <td>{{$permission->type}}</td>
                                <td>{{$permission->slug}}</td>
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
<script type="text/javascript">
    jQuery(function() {
        function generatePassword() {
            return Math.random() // Generate random number, eg: 0.123456
                .toString(36) // Convert  to base-36 : "0.4fzyo82mvyr"
                .slice(-8); // Cut off last 8 characters : "yo82mvyr"
        }
        jQuery('#generate_password').on('click', function() {
            var password = generatePassword();
            jQuery('#password').val(password);
            jQuery('#confirm-password').val(password);
        });

    })
</script>
@endsection