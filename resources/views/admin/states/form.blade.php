<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="country">Country Name</label>
            <select name="country_id" class="form-control" id="country_id">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $model->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('country_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">State Name</label>
            <input type="text" id="basic-addon-name" name="name" class="form-control" placeholder="State Name"
                value="{{ isset($model->name) ? $model->name : old('name') }}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">Looks good!</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-code">State Code</label>
            <input type="text" id="basic-addon-code" name="code" class="form-control" placeholder="Country Code"
                value="{{ isset($model->code) ? $model->code : old('code') }}" aria-describedby="basic-addon-code" />
            <div class="valid-feedback">Looks good!</div>
            @error('code')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">Status</label>
            <select name="status" class="form-control" id="status">
                <option value="">Select Status</option>
                <option value="1" {{ $model->status == 1 ? 'selected' : '' }}> Active</option>
                <option value="0" {{ $model->status == 0 ? 'selected' : '' }}> Inactive</option>

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
