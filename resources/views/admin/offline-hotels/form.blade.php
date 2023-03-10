<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">Hotel Details</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_name">Hotel Name</label>
            <input type="text" id="hotel_name" name="hotel_name" class="form-control"
                placeholder="Hotel Name"
                value="{{ isset($model->hotel_name) ? $model->hotel_name : old('hotel_name') }}"
                data-error="Hotel Name" />
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_country">Country</label>
            <select class="select2 form-control form-control-lg" id="hotel_country" name="hotel_country"
                data-error="{{ __('agent/agent.hotel_country') }}">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}"
                        {{ $model->agent_country == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}</option>
                @endforeach
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_country')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group myState">
            <label class="form-label" for="hotel_state">State</label>
            <select class="select2 form-control form-control-lg" id="hotel_state" name="hotel_state"
                data-error="State">
                <option value="">Select State</option>
                @php $states = getCountryStates($model->hotel_state);  @endphp
                @if ($states->count() > 0)
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}"
                            {{ $model->hotel_state == $state->id ? 'selected' : '' }}>
                            {{ $state->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="spinner-border spinner-border-sm hide" role="status">
                <span class="sr-only">{{ __('core.loading') }}</span>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_state')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group myCity">
            <label class="form-label" for="hotel_city">City</label>
            <select class="select2 form-control form-control-lg" id="hotel_city" name="hotel_city"
                data-error="City">
                <option value="">Select City</option>
                @php $cities = getStateCities($model->hotel_city);  @endphp
                @if ($cities->count() > 0)
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ $model->hotel_city == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="spinner-border spinner-border-sm hide" role="status">
                <span class="sr-only">{{ __('core.loading') }}</span>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('hotel_city')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="category">Category</label>
            <select class="select2 form-control form-control-lg" id="category" name="category"
                data-error="Category">
                <option value="">Select Category</option>
                @foreach ($categories as $key => $category)
                    <option value="{{ $key }}"
                        {{ $model->category == $key ? 'selected' : '' }}>
                        {{ $category}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('category')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="hotel_group_id">Hotel Group</label>
            <select class="select2 form-control form-control-lg" id="hotel_group_id" name="hotel_group_id"
                data-error="Hotel Group">
                <option value="">Select Hotel Group</option>
                @foreach ($hotelGroups as $key => $hg)
                    <option value="{{ $hg->id }}"
                        {{ $model->hotel_group_id == $hg->id ? 'selected' : '' }}>
                        {{ $hg->name}}</option>
                @endforeach
            </select>
            @error('hotel_group_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control"
                placeholder="Phone Number"
                value="{{ isset($model->phone_number) ? $model->phone_number : old('phone_number') }}"
                data-error="Phone Number" />
            <div class="valid-feedback">Looks good!</div>
            @error('phone_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="phone_number">Fax Number</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control"
                placeholder="Fax Number"
                value="{{ isset($model->phone_number) ? $model->phone_number : old('phone_number') }}"
                data-error="Fax Number" />
            <div class="valid-feedback">Looks good!</div>
            @error('phone_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
   
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_office_address">{{ __('agent/agent.agent_office_address') }}</label>
            <input type="text" id="agent_office_address" name="agent_office_address" class="form-control"
                placeholder="{{ __('agent/agent.agent_office_address') }}"
                value="{{ isset($model->agent_office_address) ? $model->agent_office_address : old('agent_office_address') }}"
                data-error="{{ __('agent/agent.agent_office_address') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_office_address')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_pincode">{{ __('agent/agent.agent_pincode') }}</label>
            <input type="text" id="agent_pincode" name="agent_pincode" class="form-control"
                placeholder="{{ __('agent/agent.agent_pincode') }}"
                value="{{ isset($model->agent_pincode) ? $model->agent_pincode : old('agent_pincode') }}"
                data-error="{{ __('agent/agent.agent_pincode') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_pincode')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_telephone">{{ __('agent/agent.agent_telephone') }}</label>
            <input type="text" id="agent_telephone" name="agent_telephone" class="form-control"
                placeholder="{{ __('agent/agent.agent_telephone') }}"
                value="{{ isset($model->agent_telephone) ? $model->agent_telephone : old('agent_telephone') }}"
                data-error="{{ __('agent/agent.agent_telephone') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_telephone')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_mobile_number">{{ __('agent/agent.agent_mobile_number') }}</label>
            <input type="text" id="agent_mobile_number" name="agent_mobile_number" class="form-control"
                placeholder="{{ __('agent/agent.agent_mobile_number') }}"
                value="{{ isset($model->agent_mobile_number) ? $model->agent_mobile_number : old('agent_mobile_number') }}"
                data-error="{{ __('agent/agent.agent_mobile_number') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_mobile_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_email">{{ __('agent/agent.agent_email') }}</label>
            <input type="text" id="agent_email" name="agent_email" class="form-control"
                placeholder="{{ __('agent/agent.agent_email') }}"
                value="{{ isset($model->agent_email) ? $model->agent_email : old('agent_email') }}"
                data-error="{{ __('agent/agent.agent_email') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_email')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_website">{{ __('agent/agent.agent_website') }}</label>
            <input type="text" id="agent_website" name="agent_website" class="form-control"
                placeholder="{{ __('agent/agent.agent_website') }}"
                value="{{ isset($model->agent_website) ? $model->agent_website : old('agent_website') }}"
                data-error="{{ __('agent/agent.agent_website') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_website')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_iata">{{ __('agent/agent.agent_iata') }}</label>
            <div class="demo-inline-spacing">
                <div class="custom-control custom-radio">
                    <input type="radio" id="agent_iata-yes" name="agent_iata" class="custom-control-input"
                        value="yes"
                        {{ $model->agent_iata == 'yes' || old('agent_iata') == 'yes' ? 'checked' : '' }} />
                    <label class="custom-control-label" for="agent_iata-yes">Yes</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="agent_iata-no" name="agent_iata" class="custom-control-input"
                        value="no"
                        {{ $model->agent_iata == 'no' || old('agent_iata') == 'no' ? 'checked' : '' }} />
                    <label class="custom-control-label" for="agent_iata-no">No</label>
                </div>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('agent_iata')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @php
        $hide = isset($model->agent_iata_number) ? '' : 'hide';
    @endphp
    <div class="col-4 iata_number_hide {{ $hide }}" id="iata_number_hide">
        <div class="form-group">
            <label class="form-label" for="agent_iata_number">{{ __('agent/agent.agent_iata_number') }}</label>
            <input type="text" id="agent_iata_number" name="agent_iata_number" class="form-control"
                placeholder="{{ __('agent/agent.agent_iata_number') }}"
                value="{{ isset($model->agent_iata_number) ? $model->agent_iata_number : old('agent_iata_number') }}"
                data-error="{{ __('agent/agent.agent_iata_number') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_iata_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label"
                for="agent_other_certification">{{ __('agent/agent.agent_other_certification') }}</label>
            <input type="text" id="agent_other_certification" name="agent_other_certification"
                class="form-control" placeholder="{{ __('agent/agent.agent_other_certification') }}"
                value="{{ isset($model->agent_other_certification) ? $model->agent_other_certification : old('agent_other_certification') }}"
                data-error="{{ __('agent/agent.agent_other_certification') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_other_certification')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_pan_number">{{ __('agent/agent.agent_pan_number') }}</label>
            <input type="text" id="agent_pan_number" name="agent_pan_number" class="form-control"
                placeholder="{{ __('agent/agent.agent_pan_number') }}"
                value="{{ isset($model->agent_pan_number) ? $model->agent_pan_number : old('agent_pan_number') }}"
                data-error="{{ __('agent/agent.agent_pan_number') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_pan_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_gst_number">{{ __('agent/agent.agent_gst_number') }}</label>
            <input type="text" id="agent_gst_number" name="agent_gst_number" class="form-control"
                placeholder="{{ __('agent/agent.agent_gst_number') }}"
                value="{{ isset($model->agent_gst_number) ? $model->agent_gst_number : old('agent_gst_number') }}"
                data-error="{{ __('agent/agent.agent_gst_number') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_gst_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
   
</div>


<div class="row">
    <div class="col-4">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">{{ __('agent/agent.management_details_title') }}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="mgmt_first_name">{{ __('agent/agent.mgmt_first_name') }}</label>
                <input type="text" id="mgmt_first_name" name="mgmt_first_name" class="form-control"
                    placeholder="{{ __('agent/agent.mgmt_first_name') }}"
                    value="{{ isset($model->mgmt_first_name) ? $model->mgmt_first_name : old('mgmt_first_name') }}"
                    data-error="{{ __('agent/agent.mgmt_first_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('mgmt_first_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="mgmt_last_name">{{ __('agent/agent.mgmt_last_name') }}</label>
                <input type="text" id="mgmt_last_name" name="mgmt_last_name" class="form-control"
                    placeholder="{{ __('agent/agent.mgmt_last_name') }}"
                    value="{{ isset($model->mgmt_last_name) ? $model->mgmt_last_name : old('mgmt_last_name') }}"
                    data-error="{{ __('agent/agent.mgmt_last_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('mgmt_last_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="mgmt_contact_number">{{ __('agent/agent.mgmt_contact_number') }}</label>
                <input type="text" id="mgmt_contact_number" name="mgmt_contact_number" class="form-control"
                    placeholder="{{ __('agent/agent.mgmt_contact_number') }}"
                    value="{{ isset($model->mgmt_contact_number) ? $model->mgmt_contact_number : old('mgmt_contact_number') }}"
                    data-error="{{ __('agent/agent.mgmt_contact_number') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('mgmt_contact_number')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="mgmt_email">{{ __('agent/agent.mgmt_email') }}</label>
                <input type="text" id="mgmt_email" name="mgmt_email" class="form-control"
                    placeholder="{{ __('agent/agent.mgmt_email') }}"
                    value="{{ isset($model->mgmt_email) ? $model->mgmt_email : old('mgmt_email') }}"
                    data-error="{{ __('agent/agent.mgmt_email') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('mgmt_email')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>

    </div>
    <div class="col-4">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">{{ __('agent/agent.account_details_title') }}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="account_first_name">{{ __('agent/agent.account_first_name') }}</label>
                <input type="text" id="account_first_name" name="account_first_name" class="form-control"
                    placeholder="{{ __('agent/agent.account_first_name') }}"
                    value="{{ isset($model->account_first_name) ? $model->account_first_name : old('account_first_name') }}"
                    data-error="{{ __('agent/agent.account_first_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('account_first_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="account_last_name">{{ __('agent/agent.account_last_name') }}</label>
                <input type="text" id="account_last_name" name="account_last_name" class="form-control"
                    placeholder="{{ __('agent/agent.account_last_name') }}"
                    value="{{ isset($model->account_last_name) ? $model->account_last_name : old('account_last_name') }}"
                    data-error="{{ __('agent/agent.account_last_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('account_last_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="account_contact_number">{{ __('agent/agent.mgmt_contact_number') }}</label>
                <input type="text" id="account_contact_number" name="account_contact_number" class="form-control"
                    placeholder="{{ __('agent/agent.account_contact_number') }}"
                    value="{{ isset($model->account_contact_number) ? $model->account_contact_number : old('account_contact_number') }}"
                    data-error="{{ __('agent/agent.account_contact_number') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('account_contact_number')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="account_email">{{ __('agent/agent.account_email') }}</label>
                <input type="text" id="account_email" name="account_email" class="form-control"
                    placeholder="{{ __('agent/agent.account_email') }}"
                    value="{{ isset($model->account_email) ? $model->account_email : old('account_email') }}"
                    data-error="{{ __('agent/agent.account_email') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('account_email')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">{{ __('agent/agent.reservation_details_title') }}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="reserve_first_name">{{ __('agent/agent.reserve_first_name') }}</label>
                <input type="text" id="reserve_first_name" name="reserve_first_name" class="form-control"
                    placeholder="{{ __('agent/agent.reserve_first_name') }}"
                    value="{{ isset($model->reserve_first_name) ? $model->reserve_first_name : old('reserve_first_name') }}"
                    data-error="{{ __('agent/agent.reserve_first_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('reserve_first_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="reserve_last_name">{{ __('agent/agent.account_last_name') }}</label>
                <input type="text" id="reserve_last_name" name="reserve_last_name" class="form-control"
                    placeholder="{{ __('agent/agent.reserve_last_name') }}"
                    value="{{ isset($model->reserve_last_name) ? $model->reserve_last_name : old('reserve_last_name') }}"
                    data-error="{{ __('agent/agent.reserve_last_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('reserve_last_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="reserve_contact_number">{{ __('agent/agent.reserve_contact_number') }}</label>
                <input type="text" id="reserve_contact_number" name="reserve_contact_number" class="form-control"
                    placeholder="{{ __('agent/agent.reserve_contact_number') }}"
                    value="{{ isset($model->reserve_contact_number) ? $model->reserve_contact_number : old('reserve_contact_number') }}"
                    data-error="{{ __('agent/agent.reserve_contact_number') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('reserve_contact_number')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="reserve_email">{{ __('agent/agent.reserve_email') }}</label>
                <input type="text" id="reserve_email" name="reserve_email" class="form-control"
                    placeholder="{{ __('agent/agent.reserve_email') }}"
                    value="{{ isset($model->reserve_email) ? $model->reserve_email : old('reserve_email') }}"
                    data-error="{{ __('agent/agent.reserve_email') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('reserve_email')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-4">
        <input type="hidden" value="{{ isset($model->id) ? 'yes' : 'no' }}" class="editPage" id="editPage">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">{{ __('agent/agent.access_details_title') }}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="agent_username">{{ __('agent/agent.agent_username') }}</label>
                <input type="text" id="agent_username" name="agent_username" class="form-control"
                    placeholder="{{ __('agent/agent.agent_username') }}"
                    value="{{ isset($model->user->email) ? $model->user->email : old('agent_username') }}"
                    data-error="{{ __('agent/agent.agent_username') }}"  autocomplete="off"/>
                <div class="valid-feedback">Looks good!</div>
                @error('agent_username')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="agent_password">{{ __('agent/agent.agent_password') }}</label>
                <input type="password" id="agent_password" name="agent_password" class="form-control"
                    placeholder="{{ __('agent/agent.agent_password') }}"
                    value=""
                    data-error="{{ __('agent/agent.agent_password') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('agent_password')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label"
                    for="agent_confirm_password">{{ __('agent/agent.agent_confirm_password') }}</label>
                <input type="password" id="agent_confirm_password" name="agent_confirm_password"
                    class="form-control" placeholder="{{ __('agent/agent.agent_confirm_password') }}"
                    value=""
                    data-error="{{ __('agent/agent.agent_confirm_password') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('agent_confirm_password')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">{{ __('agent/agent.document_details_title') }}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-3">
            <div class="form-group">
                <label class="form-label" for="agent_pan_card">{{ __('agent/agent.agent_pan_card') }}</label><br>
                <input type="file" name="agent_pan_card" id="agent_pan_card">
                <div class="valid-feedback">Looks good!</div>
                @error('agent_pan_card')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
            @if (strlen($model->agent_pan_card) > 0)
                <img src="{{ url('storage/app/upload/' . $model->user_id . '/' . $model->agent_pan_card) }}"
                    alt="{{ $model->agent_first_name }}" title="{{ $model->agent_first_name }}" width="100px;">
            @endif
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label"
                    for="agent_company_certificate">{{ __('agent/agent.agent_company_certificate') }}</label><br>
                <input type="file" name="agent_company_certificate" id="agent_company_certificate">
                <div class="valid-feedback">Looks good!</div>
                @error('agent_company_certificate')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
            @if (strlen($model->agent_company_certificate) > 0)
                <img src="{{ url('storage/app/upload/' . $model->user_id . '/' . $model->agent_company_certificate) }}"
                    alt="{{ $model->agent_company_name }}" title="{{ $model->agent_company_name }}"
                    width="100px;">
            @endif
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label"
                    for="agent_company_logo">{{ __('agent/agent.agent_company_logo') }}</label><br>
                <input type="file" name="agent_company_logo" id="agent_company_logo">
                <div class="valid-feedback">Looks good!</div>
                @error('agent_company_logo')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
            @if (strlen($model->agent_company_logo) > 0)
                <img src="{{ url('storage/app/upload/' . $model->user_id . '/' . $model->agent_company_logo) }}"
                    alt="{{ $model->agent_company_name }}" title="{{ $model->agent_company_name }}"
                    width="100px;">
            @endif
        </div>
    </div>
</div>
@section('extra-script')
    <script src="{{ asset('js/form/Agent.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script type="text/javascript">
        var moduleConfig = {
            redirectUrl: "{!! route('get-state-list') !!}",
            getCities: "{!! route('get-city-list') !!}",
        };
    </script>
@endsection
