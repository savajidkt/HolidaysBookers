<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-name">{{ __('product-markup/product-markup.form_product_markup_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-name" name="name" class="form-control"
                placeholder="{{ __('product-markup/product-markup.form_product_markup_name') }}"
                value="{{ isset($model->name) ? $model->name : old('name') }}" aria-describedby="basic-addon-name"
                data-error="{{ __('product-markup/message.product_markup_name_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label"
                for="basic-addon-percentage">{{ __('product-markup/product-markup.form_product_markup_percentage') }} <span class="text-danger">*</span></label>
            <input type="text" id="basic-addon-percentage" name="percentage" class="form-control"
                placeholder="{{ __('product-markup/product-markup.form_product_markup_percentage') }}"
                value="{{ isset($model->percentage) ? $model->percentage : old('percentage') }}"
                aria-describedby="basic-addon-percentage"
                data-error="{{ __('product-markup/message.product_markup_percentage_required') }}" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('percentage')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">{{ __('product-markup/product-markup.form_status') }} <span class="text-danger">*</span></label>
            <select name="status" class="form-control" id="status"
                data-error="{{ __('product-markup/message.status_required') }}">
                <option value="">{{ __('product-markup/product-markup.form_select_status') }}</option>
                <option value="1" {{ $model->status == 1 ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ $model->status == 0 ? 'selected' : '' }}> {{ __('core.inactive') }}</option>

            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('js/form/Product-Markup.js') }}"></script>
@endsection
