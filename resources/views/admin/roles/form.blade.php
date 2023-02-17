<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Role Name</label>
            <input type="text" id="basic-addon-name" name="rolename" class="form-control" placeholder="Role Name" value="{{(isset($model->name))?$model->name:old('rolename')}}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">Looks good!</div>
            @error('rolename')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">Permissions</label>
            <section class="custom-checkbox">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="demo-inline-spacing">
                                    
                                    @foreach($permission as $value)

                                    <div class="col-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="permissions[]" class="custom-control-input" id="permission-{{$value->id}}" value="{{$value->id}}" @if(is_array(old("permissions")) && in_array($value->id, old('permissions')) || in_array($value->id,$model->permissions()->pluck('permission_id')->toArray())) checked @endif />
                                            <label class="custom-control-label" for="permission-{{$value->id}}">{{ $value->name }}</label>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="valid-feedback">Looks good!</div>
            @error('permissions')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
</div>

@section('extra-script')

@endsection