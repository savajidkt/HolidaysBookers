<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-property_name">Property Name</label>
            <input type="text" id="basic-addon-property_name" name="property_name" class="form-control" placeholder="Property  Name" value="{{(isset($model->property_name))?$model->property_name:old('property_name')}}" aria-describedby="basic-addon-property_name" />
            <div class="valid-feedback">Looks good!</div>
            @error('property_name')
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