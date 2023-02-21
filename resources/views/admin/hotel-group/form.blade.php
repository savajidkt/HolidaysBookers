<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Group Name</label>
            <input type="text" id="basic-addon-name" name="group_name" class="form-control" placeholder="Group Name" value="{{(isset($model->name))?$model->name:old('group_name')}}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">Looks good!</div>
            @error('group_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">Status</label>
            <select name="status" class="form-control" id="status">
                <option value="">Select Status</option>
                <option value="1" {{($model->status == 1)? 'selected' : ''}}> Active</option>
                <option value="0" {{($model->status == 0)? 'selected' : ''}}> Inactive</option>

            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('status')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
</div>

@section('extra-script')

@endsection