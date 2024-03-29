<div class="row">
    <div class="col-md-4 col-12">
        <div class="col-md-12">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="basic-addon-name">Role Name <span class="text-danger">*</span></label>
                    <input type="text" id="basic-addon-name" name="rolename" class="form-control" onkeydown="return /[a-zA-Z ]/.test(event.key)" placeholder="Role Name" value="{{(isset($model->name))?$model->name:old('rolename')}}" aria-describedby="basic-addon-name" />
                    <div class="valid-feedback">Looks good!</div>
                    @error('rolename')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- <div class="col-6">
                <div class="form-group">
                    <button type="submit" id="user-save" class="btn btn-primary">Save</button>
                </div>
            </div> --}}
            <div class="col-12">
                @if($model->id != '')
                <div class="row">
                    <div class="col-12">
                        <a class="btn btn-outline-secondary waves-effect"
                            href="{{ route('roles.index') }}">Back</a>
                        <button type="submit" id="user-save" class="btn btn-primary">Update</button>
                    </div>
                </div>
                @endif
                @if($model->id == '')
                <div class="row">
                    <div class="col-12">
                        <a class="btn btn-outline-secondary waves-effect"
                            href="{{ route('roles.index') }}">Back</a>
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
<script src="{{ asset('js/form/Role.js') }}"></script>
@endsection