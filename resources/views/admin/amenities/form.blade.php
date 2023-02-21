<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-amenity_name">Amenity Name</label>
            <input type="text" id="basic-addon-amenity_name" name="amenity_name" class="form-control" placeholder="Amenity Name" value="{{(isset($model->amenity_name))?$model->amenity_name:old('amenity_name')}}" aria-describedby="basic-addon-amenity_name" />
            <div class="valid-feedback">Looks good!</div>
            @error('amenity_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="type">Type</label>
            <select name="type" class="form-control" id="type">
                <option value="">Select Type</option>
                <option value="1" {{($model->type == 1)? 'selected' : ''}}> Hotel</option>
                <option value="2" {{($model->type == 2)? 'selected' : ''}}> Room</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('type')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="status">Status</label>
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