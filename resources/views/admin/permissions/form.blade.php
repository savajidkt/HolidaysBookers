<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-module">Module</label>
            <input type="text" id="basic-addon-module" name="module" class="form-control" placeholder="Module" value="{{(isset($model->module))?$model->module:old('module')}}" aria-describedby="basic-addon-module" />
            <div class="valid-feedback">Looks good!</div>
            @error('module')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Permission Name</label>
            <input type="text" id="basic-addon-name" name="permission_name" class="form-control" placeholder="Permission Name" value="{{(isset($model->name))?$model->name:old('permission_name')}}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">Looks good!</div>
            @error('permission_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Type</label>
            <div class="demo-inline-spacing">
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="type" id="create" value="1" {{($model->type == 1)? 'checked' : ''}} />
                    <label class="custom-control-label" for="create">Create</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="type" id="edit" value="2" {{($model->type == 2)? 'checked' : ''}} />
                    <label class="custom-control-label" for="edit">Edit</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="type" id="delete" value="3" {{($model->type == 3)? 'checked' : ''}} />
                    <label class="custom-control-label" for="delete">Delete</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="type" id="view" value="4" {{($model->type == 4)? 'checked' : ''}} />
                    <label class="custom-control-label" for="view">View</label>
                </div>
                
            </div>
           
            @error('permission_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
</div>

@section('extra-script')

@endsection