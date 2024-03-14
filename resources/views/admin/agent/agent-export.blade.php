<table>
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Firm Company Type</th>
            <th>Nature of Business</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Designation</th>
            <th>Date Of Birth</th>
            <th>Office address</th>
            <th>Country</th>
            <th>State</th>
            <th>City</th>
            <th>Zipcode</th>
            <th>Telephone</th>
            <th>Mobile Number</th>
            <th>Email Address</th>
            <th>Website</th>
            <th>IATA certified</th>
            <th>IATA Number</th>
            <th>Other Certification</th>
            <th>PAN Number</th>
            <th>GST Number</th>
            <th>Know About</th>
            <th>Know Other</th>
            <th>Management First Name</th>
            <th>Management Last Name</th>
            <th>Management Contact Number</th>
            <th>Management Email Address</th>
            <th>Accounts First Name</th>
            <th>Accounts Last Name</th>
            <th>Accounts Contact Number</th>
            <th>Accounts Email Address</th>
            <th>Operations First Name</th>
            <th>Operations Last Name</th>
            <th>Operations Contact Number</th>
            <th>Operations Email Address</th>
            <th>Login Email</th>           
        </tr>
    </thead>
    <tbody>
        @foreach ($agents as $agent)
       
            <tr>
                <td>{{ isset($agent->agent_company_name) ? $agent->agent_company_name : ''  }}</td>
                <td>{{ isset($agent->company->company_type) ? $agent->company->company_type : ''  }}</td>
                <td>{{ isset($agent->nature_of_business) ? $agent->nature_of_business : ''  }}</td>
                <td>{{ isset($agent->agent_first_name) ? $agent->agent_first_name : ''  }}</td>
                <td>{{ isset($agent->agent_last_name) ? $agent->agent_last_name : ''  }}</td>
                <td>{{ isset($agent->agent_designation) ? $agent->agent_designation : ''  }}</td>
                <td>{{ isset($agent->agent_dob) ? $agent->agent_dob : ''  }}</td>
                <td>{{ isset($agent->agent_office_address) ? $agent->agent_office_address : ''  }}</td>
                <td>{{ isset($agent->country->name) ? $agent->country->name : ''  }}</td>
                <td>{{ isset($agent->state->name) ? $agent->state->name : ''  }}</td>
                <td>{{ isset($agent->city->name) ? $agent->city->name : ''  }}</td>
                <td>{{ isset($agent->agent_pincode) ? $agent->agent_pincode : ''  }}</td>
                <td>{{ isset($agent->agent_telephone) ? $agent->agent_telephone : ''  }}</td>
                <td>{{ isset($agent->agent_mobile_number) ? $agent->agent_mobile_number : ''  }}</td>
                <td>{{ isset($agent->agent_email) ? $agent->agent_email : ''  }}</td>                
                <td>{{ isset($agent->agent_website) ? $agent->agent_website : ''  }}</td>                
                <td>{{ isset($agent->agent_iata) ? $agent->agent_iata : ''  }}</td>                
                <td>{{ isset($agent->agent_iata_number) ? $agent->agent_iata_number : ''  }}</td>                
                <td>{{ isset($agent->agent_other_certification) ? $agent->agent_other_certification : ''  }}</td>                
                <td>{{ isset($agent->agent_pan_number) ? $agent->agent_pan_number : ''  }}</td>                
                <td>{{ isset($agent->agent_gst_number) ? $agent->agent_gst_number : ''  }}</td> 
                <td>{{ (isset($agent->reachus->name)) ?$agent->reachus->name : '' }}</td>
                <td>{{ (isset($agent->othername)) ?$agent->othername : '' }}</td>
                <td>{{ (isset($agent->mgmt_first_name)) ?$agent->mgmt_first_name : '' }}</td>
                <td>{{ (isset($agent->mgmt_last_name)) ?$agent->mgmt_last_name : '' }}</td>
                <td>{{ (isset($agent->mgmt_contact_number)) ?$agent->mgmt_contact_number : '' }}</td>
                <td>{{ (isset($agent->mgmt_email)) ?$agent->mgmt_email : '' }}</td>
                <td>{{ (isset($agent->account_first_name)) ?$agent->account_first_name : '' }}</td>
                <td>{{ (isset($agent->account_last_name)) ?$agent->account_last_name : '' }}</td>
                <td>{{ (isset($agent->account_contact_number)) ?$agent->account_contact_number : '' }}</td>
                <td>{{ (isset($agent->account_email)) ?$agent->account_email : '' }}</td>
                <td>{{ (isset($agent->reserve_first_name)) ?$agent->reserve_first_name : '' }}</td>
                <td>{{ (isset($agent->reserve_last_name)) ?$agent->reserve_last_name : '' }}</td>
                <td>{{ (isset($agent->reserve_contact_number)) ?$agent->reserve_contact_number : '' }}</td>
                <td>{{ (isset($agent->reserve_email)) ?$agent->reserve_email : '' }}</td>
                <td>{{ (isset($agent->user->email)) ?$agent->user->email : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
