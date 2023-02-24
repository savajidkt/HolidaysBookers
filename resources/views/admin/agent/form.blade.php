<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">{{__('agent/agent.company_details_title')}}</h4>
        </div>
        <hr class="my-2" />
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_company_name">{{__('agent/agent.agent_company_name')}}</label>
            <input type="text" id="agent_company_name" name="agent_company_name" class="form-control" placeholder="{{__('agent/agent.agent_company_name')}}" value="{{(isset($model->agent_company_name))? $model->agent_company_name :old('agent_company_name')}}" data-error="{{ __('agent/agent.agent_company_name') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_company_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_company_type">{{__('agent/agent.agent_company_type')}}</label>
            <input type="text" id="agent_company_type" name="agent_company_type" class="form-control" placeholder="{{__('agent/agent.agent_company_type')}}" value="{{(isset($model->agent_company_type))? $model->agent_company_type :old('agent_company_type')}}" data-error="{{ __('agent/agent.agent_company_type') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_company_type')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="nature_of_business">{{__('agent/agent.nature_of_business')}}</label>
            <input type="text" id="nature_of_business" name="nature_of_business" class="form-control" placeholder="{{__('agent/agent.nature_of_business')}}" value="{{(isset($model->nature_of_business))? $model->nature_of_business :old('nature_of_business')}}" data-error="{{ __('agent/agent.nature_of_business') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('nature_of_business')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_first_name">{{__('agent/agent.agent_first_name')}}</label>
            <input type="text" id="agent_first_name" name="agent_first_name" class="form-control" placeholder="{{__('agent/agent.agent_first_name')}}" value="{{(isset($model->agent_first_name))? $model->agent_first_name :old('agent_first_name')}}" data-error="{{ __('agent/agent.agent_first_name') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_first_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_last_name">{{__('agent/agent.agent_last_name')}}</label>
            <input type="text" id="agent_last_name" name="agent_last_name" class="form-control" placeholder="{{__('agent/agent.agent_last_name')}}" value="{{(isset($model->agent_last_name))? $model->agent_last_name :old('agent_last_name')}}" data-error="{{ __('agent/agent.agent_last_name') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_last_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_designation">{{__('agent/agent.agent_designation')}}</label>
            <input type="text" id="agent_designation" name="agent_designation" class="form-control" placeholder="{{__('agent/agent.agent_designation')}}" value="{{(isset($model->agent_designation))? $model->agent_designation :old('agent_designation')}}" data-error="{{ __('agent/agent.agent_designation') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_designation')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_dob">{{__('agent/agent.agent_dob')}}</label>
            <input type="text" id="agent_dob" name="agent_dob" class="form-control" placeholder="{{__('agent/agent.agent_dob')}}" value="{{(isset($model->agent_dob))? $model->agent_dob :old('agent_dob')}}" data-error="{{ __('agent/agent.agent_dob') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_dob')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_office_address">{{__('agent/agent.agent_office_address')}}</label>
            <input type="text" id="agent_office_address" name="agent_office_address" class="form-control" placeholder="{{__('agent/agent.agent_office_address')}}" value="{{(isset($model->agent_office_address))? $model->agent_office_address :old('agent_office_address')}}" data-error="{{ __('agent/agent.agent_office_address') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_office_address')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_country">{{__('agent/agent.agent_country')}}</label>
            <input type="text" id="agent_country" name="agent_country" class="form-control" placeholder="{{__('agent/agent.agent_country')}}" value="{{(isset($model->agent_country))? $model->agent_country :old('agent_country')}}" data-error="{{ __('agent/agent.agent_country') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_country')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_state">{{__('agent/agent.agent_state')}}</label>
            <input type="text" id="agent_state" name="agent_state" class="form-control" placeholder="{{__('agent/agent.agent_state')}}" value="{{(isset($model->agent_state))? $model->agent_state :old('agent_state')}}" data-error="{{ __('agent/agent.agent_state') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_state')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_city">{{__('agent/agent.agent_city')}}</label>
            <input type="text" id="agent_city" name="agent_city" class="form-control" placeholder="{{__('agent/agent.agent_city')}}" value="{{(isset($model->agent_city))? $model->city :old('agent_city')}}" data-error="{{ __('agent/agent.agent_city') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_city')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_pincode">{{__('agent/agent.agent_pincode')}}</label>
            <input type="text" id="agent_pincode" name="agent_pincode" class="form-control" placeholder="{{__('agent/agent.agent_pincode')}}" value="{{(isset($model->agent_pincode))? $model->agent_pincode :old('agent_pincode')}}" data-error="{{ __('agent/agent.agent_pincode') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_pincode')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_telephone">{{__('agent/agent.agent_telephone')}}</label>
            <input type="text" id="agent_telephone" name="agent_telephone" class="form-control" placeholder="{{__('agent/agent.agent_telephone')}}" value="{{(isset($model->agent_telephone))? $model->agent_telephone :old('agent_telephone')}}" data-error="{{ __('agent/agent.agent_telephone') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_telephone')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_mobile_number">{{__('agent/agent.agent_mobile_number')}}</label>
            <input type="text" id="agent_mobile_number" name="agent_mobile_number" class="form-control" placeholder="{{__('agent/agent.agent_mobile_number')}}" value="{{(isset($model->agent_mobile_number))? $model->agent_mobile_number :old('agent_mobile_number')}}" data-error="{{ __('agent/agent.agent_mobile_number') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_mobile_number')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_email">{{__('agent/agent.agent_email')}}</label>
            <input type="text" id="agent_email" name="agent_email" class="form-control" placeholder="{{__('agent/agent.agent_email')}}" value="{{(isset($model->agent_email))? $model->agent_email :old('agent_email')}}" data-error="{{ __('agent/agent.agent_email') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_email')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_website">{{__('agent/agent.agent_website')}}</label>
            <input type="text" id="agent_website" name="agent_website" class="form-control" placeholder="{{__('agent/agent.agent_website')}}" value="{{(isset($model->agent_website))? $model->agent_website :old('agent_website')}}" data-error="{{ __('agent/agent.agent_website') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_website')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_iata">{{__('agent/agent.agent_iata')}}</label>
            <input type="text" id="agent_iata" name="agent_iata" class="form-control" placeholder="{{__('agent/agent.agent_iata')}}" value="{{(isset($model->agent_iata))? $model->agent_iata :old('agent_iata')}}" data-error="{{ __('agent/agent.agent_iata') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_iata')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_iata_number">{{__('agent/agent.agent_iata_number')}}</label>
            <input type="text" id="agent_iata_number" name="agent_iata_number" class="form-control" placeholder="{{__('agent/agent.agent_iata_number')}}" value="{{(isset($model->agent_iata_number))? $model->agent_iata_number :old('agent_iata_number')}}" data-error="{{ __('agent/agent.agent_iata_number') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_iata_number')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_other_certification">{{__('agent/agent.agent_other_certification')}}</label>
            <input type="text" id="agent_other_certification" name="agent_other_certification" class="form-control" placeholder="{{__('agent/agent.agent_other_certification')}}" value="{{(isset($model->agent_other_certification))? $model->agent_other_certification :old('agent_other_certification')}}" data-error="{{ __('agent/agent.agent_other_certification') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_other_certification')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_pan_number">{{__('agent/agent.agent_pan_number')}}</label>
            <input type="text" id="agent_pan_number" name="agent_pan_number" class="form-control" placeholder="{{__('agent/agent.agent_pan_number')}}" value="{{(isset($model->agent_pan_number))? $model->agent_pan_number :old('agent_pan_number')}}" data-error="{{ __('agent/agent.agent_pan_number') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_pan_number')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="form-label" for="agent_gst_number">{{__('agent/agent.agent_gst_number')}}</label>
            <input type="text" id="agent_gst_number" name="agent_gst_number" class="form-control" placeholder="{{__('agent/agent.agent_gst_number')}}" value="{{(isset($model->agent_gst_number))? $model->agent_gst_number :old('agent_gst_number')}}" data-error="{{ __('agent/agent.agent_gst_number') }}" />
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
            <h4 class="mb-0 ml-75">{{__('agent/agent.management_details_title')}}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="mgmt_first_name">{{__('agent/agent.mgmt_first_name')}}</label>
                <input type="text" id="mgmt_first_name" name="mgmt_first_name" class="form-control" placeholder="{{__('agent/agent.mgmt_first_name')}}" value="{{(isset($model->mgmt_first_name))? $model->mgmt_first_name :old('mgmt_first_name')}}" data-error="{{ __('agent/agent.mgmt_first_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('mgmt_first_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="mgmt_last_name">{{__('agent/agent.mgmt_last_name')}}</label>
                <input type="text" id="mgmt_last_name" name="mgmt_last_name" class="form-control" placeholder="{{__('agent/agent.mgmt_last_name')}}" value="{{(isset($model->mgmt_last_name))? $model->mgmt_last_name :old('mgmt_last_name')}}" data-error="{{ __('agent/agent.mgmt_last_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('mgmt_last_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="mgmt_contact_number">{{__('agent/agent.mgmt_contact_number')}}</label>
                <input type="text" id="mgmt_contact_number" name="mgmt_contact_number" class="form-control" placeholder="{{__('agent/agent.mgmt_contact_number')}}" value="{{(isset($model->mgmt_contact_number))? $model->mgmt_contact_number :old('mgmt_contact_number')}}" data-error="{{ __('agent/agent.mgmt_contact_number') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('mgmt_contact_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="mgmt_email">{{__('agent/agent.mgmt_email')}}</label>
                <input type="text" id="mgmt_email" name="mgmt_email" class="form-control" placeholder="{{__('agent/agent.mgmt_email')}}" value="{{(isset($model->mgmt_email))? $model->mgmt_email :old('mgmt_email')}}" data-error="{{ __('agent/agent.mgmt_email') }}" />
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
            <h4 class="mb-0 ml-75">{{__('agent/agent.account_details_title')}}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="account_first_name">{{__('agent/agent.account_first_name')}}</label>
                <input type="text" id="account_first_name" name="account_first_name" class="form-control" placeholder="{{__('agent/agent.account_first_name')}}" value="{{(isset($model->account_first_name))? $model->account_first_name :old('account_first_name')}}" data-error="{{ __('agent/agent.account_first_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('account_first_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="account_last_name">{{__('agent/agent.account_last_name')}}</label>
                <input type="text" id="account_last_name" name="account_last_name" class="form-control" placeholder="{{__('agent/agent.account_last_name')}}" value="{{(isset($model->account_last_name))? $model->account_last_name :old('account_last_name')}}" data-error="{{ __('agent/agent.account_last_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('account_last_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="account_contact_number">{{__('agent/agent.mgmt_contact_number')}}</label>
                <input type="text" id="account_contact_number" name="account_contact_number" class="form-control" placeholder="{{__('agent/agent.account_contact_number')}}" value="{{(isset($model->account_contact_number))? $model->account_contact_number :old('account_contact_number')}}" data-error="{{ __('agent/agent.account_contact_number') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('account_contact_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="account_email">{{__('agent/agent.account_email')}}</label>
                <input type="text" id="account_email" name="account_email" class="form-control" placeholder="{{__('agent/agent.account_email')}}" value="{{(isset($model->account_email))? $model->account_email :old('account_email')}}" data-error="{{ __('agent/agent.account_email') }}" />
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
            <h4 class="mb-0 ml-75">{{__('agent/agent.reservation_details_title')}}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="reserve_first_name">{{__('agent/agent.reserve_first_name')}}</label>
                <input type="text" id="reserve_first_name" name="reserve_first_name" class="form-control" placeholder="{{__('agent/agent.reserve_first_name')}}" value="{{(isset($model->reserve_first_name))? $model->reserve_first_name :old('reserve_first_name')}}" data-error="{{ __('agent/agent.reserve_first_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('reserve_first_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="reserve_last_name">{{__('agent/agent.account_last_name')}}</label>
                <input type="text" id="reserve_last_name" name="reserve_last_name" class="form-control" placeholder="{{__('agent/agent.reserve_last_name')}}" value="{{(isset($model->reserve_last_name))? $model->reserve_last_name :old('reserve_last_name')}}" data-error="{{ __('agent/agent.reserve_last_name') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('reserve_last_name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="reserve_contact_number">{{__('agent/agent.reserve_contact_number')}}</label>
                <input type="text" id="reserve_contact_number" name="reserve_contact_number" class="form-control" placeholder="{{__('agent/agent.reserve_contact_number')}}" value="{{(isset($model->reserve_contact_number))? $model->reserve_contact_number :old('reserve_contact_number')}}" data-error="{{ __('agent/agent.reserve_contact_number') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('reserve_contact_number')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="reserve_email">{{__('agent/agent.reserve_email')}}</label>
                <input type="text" id="reserve_email" name="reserve_email" class="form-control" placeholder="{{__('agent/agent.reserve_email')}}" value="{{(isset($model->reserve_email))? $model->reserve_email :old('reserve_email')}}" data-error="{{ __('agent/agent.reserve_email') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('reserve_email')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-6">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">{{__('agent/agent.access_details_title')}}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-6">
            <div class="form-group">
                <label class="form-label" for="agent_username">{{__('agent/agent.agent_username')}}</label>
                <input type="text" id="agent_username" name="reserve_first_name" class="form-control" placeholder="{{__('agent/agent.agent_username')}}" value="{{(isset($model->agent_username))? $model->agent_username :old('agent_username')}}" data-error="{{ __('agent/agent.agent_username') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('agent_username')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="form-label" for="agent_password">{{__('agent/agent.agent_password')}}</label>
                <input type="text" id="agent_password" name="agent_password" class="form-control" placeholder="{{__('agent/agent.agent_password')}}" value="{{(isset($model->agent_password))? $model->agent_password :old('agent_password')}}" data-error="{{ __('agent/agent.agent_password') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('agent_password')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="form-label" for="agent_confirm_password">{{__('agent/agent.agent_confirm_password')}}</label>
                <input type="text" id="agent_confirm_password" name="agent_confirm_password" class="form-control" placeholder="{{__('agent/agent.agent_confirm_password')}}" value="{{(isset($model->agent_confirm_password))? $model->agent_confirm_password :old('agent_confirm_password')}}" data-error="{{ __('agent/agent.agent_confirm_password') }}" />
                <div class="valid-feedback">Looks good!</div>
                @error('agent_confirm_password')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="d-flex align-items-center mb-1 mt-1">
            <i data-feather="user" class="font-medium-3"></i>
            <h4 class="mb-0 ml-75">{{__('agent/agent.document_details_title')}}</h4>
        </div>
        <hr class="my-2" />
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Single File Upload</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        By default, dropzone is a multiple file uploader and does not have specific option allowing us to switch to
                        single file uploading mode, but this functionality can be achieved by adding more options to the plugin
                        settings, such as
                        <code>maxfilesexceeded</code> callback and <code>maxFiles</code> option set to 1.
                        <code>maxFiles: 1</code> is used to tell dropzone that there should be only one file.
                    </p>
                    <form action="#" class="dropzone dropzone-area" id="dpz-single-file">
                        <div class="dz-message">Drop files here or click to upload.</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="agent_password">{{__('agent/agent.agent_password')}}</label>
            <input type="text" id="agent_password" name="agent_password" class="form-control" placeholder="{{__('agent/agent.agent_password')}}" value="{{(isset($model->agent_password))? $model->agent_password :old('agent_password')}}" data-error="{{ __('agent/agent.agent_password') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_password')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="agent_confirm_password">{{__('agent/agent.agent_confirm_password')}}</label>
            <input type="text" id="agent_confirm_password" name="agent_confirm_password" class="form-control" placeholder="{{__('agent/agent.agent_confirm_password')}}" value="{{(isset($model->agent_confirm_password))? $model->agent_confirm_password :old('agent_confirm_password')}}" data-error="{{ __('agent/agent.agent_confirm_password') }}" />
            <div class="valid-feedback">Looks good!</div>
            @error('agent_confirm_password')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
</div>
<div class="modal fade text-left" id="CompanyForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Create Company</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Company: </label>
                <div class="form-group">
                    <input type="text" placeholder="Company" name="company_name" id="company_name" class="form-control" />
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="create-company" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>

@section('extra-script')
<script src="{{asset('app-assets/vendors/js/extensions/dropzone.min.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/forms/form-file-uploader.js')}}"></script>
<script type="text/javascript">
    jQuery(function() {
        function generatePassword() {
            return Math.random() // Generate random number, eg: 0.123456
                .toString(36) // Convert  to base-36 : "0.4fzyo82mvyr"
                .slice(-8); // Cut off last 8 characters : "yo82mvyr"
        }
        jQuery('#generate_password').on('click', function() {
            var password = generatePassword();
            jQuery('#password').val(password);
            jQuery('#confirm-password').val(password);
        });

    })
</script>
@endsection