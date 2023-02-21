<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Country Name</label>
            <input type="text" id="basic-addon-name" name="name" class="form-control" placeholder="Country Name"
                value="{{ isset($model->name) ? $model->name : old('name') }}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">Looks good!</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-code">Country Code</label>
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
            <label class="form-label" for="basic-addon-phone_code">Phone Code</label>
            <input type="text" id="basic-addon-phone_code" name="phone_code" class="form-control"
                placeholder="Phone Code"
                value="{{ isset($model->phone_code) ? $model->phone_code : old('phone_code') }}"
                aria-describedby="basic-addon-phone_code" />
            <div class="valid-feedback">Looks good!</div>
            @error('phone_code')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-nationality">Nationality</label>
            <input type="text" id="basic-addon-nationality" name="nationality" class="form-control"
                placeholder="Nationality"
                value="{{ isset($model->nationality) ? $model->nationality : old('nationality') }}"
                aria-describedby="basic-addon-nationality" />
            <div class="valid-feedback">Looks good!</div>
            @error('nationality')
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