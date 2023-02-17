<div class="row">
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
</div>

@section('extra-script')

@endsection