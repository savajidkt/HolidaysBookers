<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">CUSTOMER DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>    
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Firstname</label>
            <input type="text" id="basic-addon-first_name" name="first_name" class="form-control"
                placeholder="Firstname" value="{{ isset($model->user->first_name) ? $model->user->first_name : old('first_name') }}"
                aria-describedby="basic-addon-name" data-error="Firstname is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('first_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Lastname</label>
            <input type="text" id="basic-addon-last_name" name="last_name" class="form-control"
                placeholder="Lastname" value="{{ isset($model->user->last_name) ? $model->user->last_name : old('last_name') }}"
                aria-describedby="basic-addon-name" data-error="Lastname is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('last_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Date of birth</label>
            <input type="text" id="fp-default" name="dob" class="form-control flatpickr-basic flatpickr-input"
                placeholder="YYYY-MM-DD" placeholder="Date of birth is required"
                value="{{ isset($model->dob) ? $model->dob : old('dob') }}" data-error="Date of birth is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('dob')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="country">Country</label>
            <select class="select2 form-control form-control-lg" id="country" name="country"
                data-error="Country is required">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ (isset($model->id) && $model->country == $country->id) ? 'selected' : ''}}>
                        {{ $country->name }}</option>
                @endforeach
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('country')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group myState">
            <label class="form-label" for="state">State</label>
            <select class="select2 form-control form-control-lg" id="state" name="state"
                data-error="State is required">
                <option value="">Select State</option>
                @php $states = getCountryStates($model->country);  @endphp
                @if ($states->count() > 0)
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" {{ (isset($model->id) && $model->state == $state->id) ? 'selected' : ''}}>
                            {{ $state->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="spinner-border spinner-border-sm hide" role="status">
                <span class="sr-only">{{ __('core.loading') }}</span>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('state')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group myCity">
            <label class="form-label" for="city">City</label>
            <select class="select2 form-control form-control-lg" id="city" name="city"
                data-error="City is required">
                <option value="">Select City</option>
                @php $cities = getStateCities($model->state);  @endphp
                @if ($cities->count() > 0)
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ (isset($model->id) && $model->city == $city->id) ? 'selected' : ''}}>
                            {{ $city->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="spinner-border spinner-border-sm hide" role="status">
                <span class="sr-only">{{ __('core.loading') }}</span>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('city')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Zipcode</label>
            <input type="text" id="basic-addon-zipcode" name="zipcode" class="form-control"
                placeholder="Zipcode" value="{{ isset($model->zipcode) ? $model->zipcode : old('zipcode') }}"
                aria-describedby="basic-addon-name" data-error="Zipcode is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('zipcode')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Telephone</label>
            <input type="text" id="basic-addon-telephone" name="telephone" class="form-control"
                placeholder="Telephone" value="{{ isset($model->telephone) ? $model->telephone : old('telephone') }}"
                aria-describedby="basic-addon-name" data-error="Telephone is required" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('telephone')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Mobile Number</label>
            <input type="text" id="basic-addon-mobile_number" name="mobile_number" class="form-control"
                placeholder="Mobile Number"
                value="{{ isset($model->mobile_number) ? $model->mobile_number : old('mobile_number') }}"
                aria-describedby="basic-addon-name" data-error="Mobile Number is required" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('mobile_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="role">Status</label>
            <select name="status" class="form-control" id="status" data-error="Status is required">
                <option value="">Select Status</option>
                <option value="1" {{ (isset($model->id) && $model->user->status == 1) ? 'selected' : '' }}> {{ __('core.active') }}</option>
                <option value="0" {{ (isset($model->id) && $model->user->status == 0) ? 'selected' : '' }}> {{ __('core.inactive') }}
                </option>
            </select>
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">ACCESS DETAILS</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-4">
        <div class="form-group">
            <input type="hidden" value="{{ isset($model->id) ? 'yes' : 'no' }}" class="editPage" id="editPage">
            <label class="form-label" for="basic-addon-name">Email Address</label>
            <input type="text" id="basic-addon-email_address" name="email_address" class="form-control"
                placeholder="Email Address"
                value="{{ isset($model->user->email) ? $model->user->email : old('email_address') }}"
                aria-describedby="basic-addon-name" data-error="Email Address is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('email_address')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                value="{{ isset($model->password) ? $model->password : old('password') }}"
                aria-describedby="basic-addon-name" data-error="Password is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('password')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Confirm Password</label>
            <input type="password" id="basic-addon-confirm_password" name="confirm_password" class="form-control"
                placeholder="Confirm Password"
                value="{{ isset($model->confirm_password) ? $model->confirm_password : old('confirm_password') }}"
                aria-describedby="basic-addon-name" data-error="Confirm password is required" />
            <div class="valid-feedback">{{ __('core.looks_good') }}</div>
            @error('confirm_password')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('js/form/Customer.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <script type="text/javascript">
        var moduleConfig = {
            redirectUrl: "{!! route('get-state-list') !!}",
            getCities: "{!! route('get-city-list') !!}",
        };
    </script>
@endsection
