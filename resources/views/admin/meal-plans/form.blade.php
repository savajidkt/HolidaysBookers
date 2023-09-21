<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">MEAL PLAN DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-8">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Meal Plan <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-name" name="name" class="form-control" placeholder="Meal Plan Name"
                value="{{ isset($model->name) ? $model->name : old('name') }}"
                aria-describedby="basic-addon-name" data-error="Meal plan name is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="role">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control" id="status" data-error="Status is required">
                <option value="">Select Status</option>
                <option value="1" {{ isset($model->id) && $model->status == 1 ? 'selected' : '' }}>
                    {{ __('core.active') }}</option>
                <option value="0" {{ isset($model->id) && $model->status == 0 ? 'selected' : '' }}>
                    {{ __('core.inactive') }}
                </option>
            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('js/form/MealPlan.js') }}"></script>
@endsection
