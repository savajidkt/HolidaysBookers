@extends('admin.layout.app')
@section('page_title', __('agent/agent.form_view_title'))
@section('content')
    <section id="page-account-settings">
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">Agent Profile: #{{ $model->agent_code }}</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('agents.index') }}"><button type="reset"
                            class="btn btn-outline-secondary waves-effectt">
                            {{ __('core.back') }}</button></a>
                </div>
            </div>

        </div>
        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column nav-left">
                    <!-- company-details -->
                    <li class="nav-item">
                        <a class="nav-link active" id="account-pill-company-details" data-toggle="pill"
                            href="#account-vertical-company-details" aria-expanded="true">
                            <i class="fa fa-building fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">{{ __('agent/agent.company_details_title') }}</span>
                        </a>
                    </li>
                    <!-- management -->
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-management" data-toggle="pill"
                            href="#account-vertical-management" aria-expanded="false">
                            <i class="fa fa-briefcase fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">{{ __('agent/agent.management_details_title') }}</span>
                        </a>
                    </li>
                    <!-- accounts -->
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-accounts" data-toggle="pill" href="#account-vertical-accounts"
                            aria-expanded="false">
                            <i class="fa fa-suitcase fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">{{ __('agent/agent.account_details_title') }}</span>
                        </a>
                    </li>
                    <!-- operations-reservations -->
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-operations-reservations" data-toggle="pill"
                            href="#account-vertical-operations-reservations" aria-expanded="false">
                            <i class="fa fa-tasks fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">{{ __('agent/agent.reservation_details_title') }}</span>
                        </a>
                    </li>
                    <!-- access-details -->
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-access-details" data-toggle="pill"
                            href="#account-vertical-access-details" aria-expanded="false">
                            <i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">{{ __('agent/agent.access_details_title') }}</span>
                        </a>
                    </li>
                    <!-- documents-upload -->
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-documents-upload" data-toggle="pill"
                            href="#account-vertical-documents-upload" aria-expanded="false">
                            <i class="fa fa-file fa-2x" aria-hidden="true"></i>
                            <span class="font-weight-bold">{{ __('agent/agent.document_details_title') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--/ left menu section -->

            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- company-details tab -->
                            <div role="tabpanel" class="tab-pane active" id="account-vertical-company-details"
                                aria-labelledby="account-pill-company-details" aria-expanded="true">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_company_name') }}</label>
                                            <strong
                                                class="disp-below">{{ isset($model->agent_company_name) ? $model->agent_company_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.agent_company_type') }}</label>
                                            @php
                                                $agent_company_type = '';
                                            @endphp
                                            @foreach ($companies as $key => $company)
                                                @if ($model->agent_company_type == $company->id)
                                                    @php
                                                        $agent_company_type = $company->company_type;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <strong
                                                class="disp-below">{{ isset($agent_company_type) ? $agent_company_type : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.nature_of_business') }}</label>
                                            <strong
                                                class="disp-below">{{ isset($model->nature_of_business) ? $model->nature_of_business : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_first_name') }}</label>                                           
                                            <strong
                                                class="disp-below">{{ isset($model->agent_first_name) ? $model->agent_first_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_last_name') }}</label>
                                           
                                            <strong
                                                class="disp-below">{{ isset($model->agent_last_name) ? $model->agent_last_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.agent_designation') }}</label>
                                            
                                            <strong
                                                class="disp-below">{{ isset($model->agent_designation) ? $model->agent_designation : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_dob') }}</label>                                           
                                            <strong
                                                class="disp-below">{{(isset($model->agent_dob))? formatdate($model->agent_dob):''}}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.agent_office_address') }}</label>                                           
                                            <strong
                                                class="disp-below">{{ isset($model->agent_office_address) ? $model->agent_office_address : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_country') }}</label>
                                            @php
                                                $agent_country = '';
                                            @endphp
                                            @foreach ($countries as $country)
                                                @if ($model->agent_country == $country->id)
                                                    @php
                                                        $agent_country = $country->name;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach                                            
                                            <strong
                                                class="disp-below">{{ isset($agent_country) ? $agent_country : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_state') }}</label>
                                            @php
                                                $agent_state = '';
                                            @endphp
                                            @php $states = getCountryStates($model->agent_country);  @endphp
                                            @if ($states->count() > 0)
                                                @foreach ($states as $state)
                                                    @if ($model->agent_state == $state->id)
                                                        @php
                                                            $agent_state = $state->name;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif                                           
                                            <strong
                                                class="disp-below">{{ isset($agent_state) ? $agent_state : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_city') }}</label>
                                            @php
                                                $agent_city = '';
                                            @endphp
                                            @php $cities = getStateWiseCity($model->agent_state);  @endphp
                                            @if ($cities->count() > 0)
                                                @foreach ($cities as $city)
                                                    @if ($model->agent_city == $city->id)
                                                        @php
                                                            $agent_city = $city->name;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif                                         
                                            <strong
                                                class="disp-below">{{ isset($agent_city) ? $agent_city : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_pincode') }}</label>                                          
                                            <strong
                                                class="disp-below">{{ isset($model->agent_pincode) ? $model->agent_pincode : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_telephone') }}</label>                                          
                                            <strong
                                                class="disp-below">{{ isset($model->agent_telephone) ? $model->agent_telephone : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.agent_mobile_number') }}</label>                                           
                                            <strong
                                                class="disp-below">{{ isset($model->agent_mobile_number) ? $model->agent_mobile_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_email') }}</label>                                           
                                            <strong
                                                class="disp-below">{{ isset($model->agent_email) ? $model->agent_email : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_website') }}</label>                                           
                                            <strong
                                                class="disp-below">{{ isset($model->agent_website) ? $model->agent_website : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_iata') }}</label>                                            
                                            <strong
                                                class="disp-below">{{ isset($model->agent_iata) ? ucfirst($model->agent_iata) : '' }}</strong>
                                        </div>
                                    </div>
                                    @if ($model->agent_iata == 'yes')
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label
                                                    for="account-username">{{ __('agent/agent.agent_iata_number') }}</label>                                               
                                                <strong
                                                    class="disp-below">{{ isset($model->agent_iata_number) ? $model->agent_iata_number : '' }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.agent_other_certification') }}</label>
                                            <strong
                                                class="disp-below">{{ isset($model->agent_other_certification) ? $model->agent_other_certification : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_pan_number') }}</label>
                                            <strong
                                                class="disp-below">{{ isset($model->agent_pan_number) ? $model->agent_pan_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_gst_number') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->agent_gst_number) ? $model->agent_gst_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_know_about') }}</label>
                                            @php
                                                $agent_know_about = '';
                                                $agent_know_about_lable = '';
                                                $agent_know_about_show = 0;
                                            @endphp
                                            @foreach ($reach as $rech)
                                                @if ($model->agent_know_about == $rech->id)
                                                    @php
                                                        $agent_know_about = $rech->name;
                                                        $agent_know_about_lable = $rech->textbox_lable;
                                                        $agent_know_about_show = $rech->show_other_textbox;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            <strong
                                                class="disp-below">{{ isset($agent_know_about) ? $agent_know_about : '' }}</strong>
                                        </div>
                                    </div>
                                    @if ($agent_know_about_show == 1)
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label for="account-username">{{ $agent_know_about_lable }}</label>
                                                <strong
                                                    class="disp-below">{{ isset($model->othername) ? $model->othername : '' }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!--/ company-details tab -->

                            <!-- management -->
                            <div class="tab-pane fade" id="account-vertical-management" role="tabpanel"
                                aria-labelledby="account-pill-management" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.mgmt_first_name') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->mgmt_first_name) ? $model->mgmt_first_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.mgmt_last_name') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->mgmt_last_name) ? $model->mgmt_last_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.mgmt_contact_number') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->mgmt_contact_number) ? $model->mgmt_contact_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.mgmt_email') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->mgmt_email) ? $model->mgmt_email : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ management -->

                            <!-- accounts -->
                            <div class="tab-pane fade" id="account-vertical-accounts" role="tabpanel"
                                aria-labelledby="account-pill-accounts" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.account_first_name') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->account_first_name) ? $model->account_first_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.account_last_name') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->account_last_name) ? $model->account_last_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.account_contact_number') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->account_contact_number) ? $model->account_contact_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.account_email') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->account_email) ? $model->account_email : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ accounts -->

                            <!-- operations-reservations -->
                            <div class="tab-pane fade" id="account-vertical-operations-reservations" role="tabpanel"
                                aria-labelledby="account-pill-operations-reservations" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.reserve_first_name') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->reserve_first_name) ? $model->reserve_first_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.reserve_last_name') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->reserve_last_name) ? $model->reserve_last_name : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label
                                                for="account-username">{{ __('agent/agent.reserve_contact_number') }}</label>

                                            <strong
                                                class="disp-below">{{ isset($model->reserve_contact_number) ? $model->reserve_contact_number : '' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.reserve_email') }}</label>
                                            <strong
                                                class="disp-below">{{ isset($model->reserve_email) ? $model->reserve_email : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ operations-reservations -->

                            <!-- access-details -->
                            <div class="tab-pane fade" id="account-vertical-access-details" role="tabpanel"
                                aria-labelledby="account-pill-access-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="account-username">{{ __('agent/agent.agent_username') }}</label>
                                            <strong
                                                class="disp-below">{{ isset($model->user->email) ? $model->user->email : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ access-details -->

                            <!-- documents-upload -->
                            <div class="tab-pane fade" id="account-vertical-documents-upload" role="tabpanel"
                                aria-labelledby="account-pill-documents-upload" aria-expanded="false">
                                <div class="media">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            @if (strlen($model->agent_pan_card) > 0)
                                                <a target="_blank"
                                                    href="{{ url('storage/app/upload/' . $model->user_id . '/' . $model->agent_pan_card) }}"
                                                    class="mr-25">
                                                    <img src="{{ url('storage/app/upload/' . $model->user_id . '/' . $model->agent_pan_card) }}"
                                                        id="account-upload-img" class="rounded mr-50" alt="profile image"
                                                        height="80" width="80">
                                                </a>
                                                <div class="media-body mt-75 ml-1">
                                                    <p>{{ __('agent/agent.agent_pan_card') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            @if (strlen($model->agent_company_certificate) > 0)
                                                <a target="_blank"
                                                    href="{{ url('storage/app/upload/' . $model->user_id . '/' . $model->agent_company_certificate) }}"
                                                    class="mr-25">
                                                    <img src="{{ url('storage/app/upload/' . $model->user_id . '/' . $model->agent_company_certificate) }}"
                                                        id="account-upload-img" class="rounded mr-50" alt="profile image"
                                                        height="80" width="80">
                                                </a>
                                                <div class="media-body mt-75 ml-1">
                                                    <p>{{ __('agent/agent.agent_company_certificate') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            @if (strlen($model->agent_company_logo) > 0)
                                                <a target="_blank"
                                                    href="{{ url('storage/app/upload/' . $model->user_id . '/' . $model->agent_company_logo) }}"
                                                    class="mr-25">
                                                    <img src="{{ url('storage/app/upload/' . $model->user_id . '/' . $model->agent_company_logo) }}"
                                                        id="account-upload-img" class="rounded mr-50" alt="profile image"
                                                        height="80" width="80">
                                                </a>
                                                <div class="media-body mt-75 ml-1">
                                                    <p>{{ __('agent/agent.agent_company_logo') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!--/ documents-upload -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ right content section -->
        </div>
    </section>
@endsection
