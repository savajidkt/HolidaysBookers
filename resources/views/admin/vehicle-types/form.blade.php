<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-vehicle_name">Vehicle Name</label>
            <input type="text" id="basic-addon-vehicle_name" name="vehicle_name" class="form-control" placeholder="Vehicle Name" value="{{(isset($model->vehicle_name))?$model->vehicle_name:old('vehicle_name')}}" aria-describedby="basic-addon-vehicle_name" />
            <div class="valid-feedback">Looks good!</div>
            @error('vehicle_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-no_of_seats">No of Seats</label>
            <input type="text" id="basic-addon-no_of_seats" name="no_of_seats" class="form-control" placeholder="No of Seats" value="{{(isset($model->no_of_seats))?$model->no_of_seats:old('no_of_seats')}}" aria-describedby="basic-addon-no_of_seats" />
            <div class="valid-feedback">Looks good!</div>
            @error('no_of_seats')
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