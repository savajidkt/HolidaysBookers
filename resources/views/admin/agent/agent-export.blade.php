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
                <td>{{ $agent->agent_company_name }}</td>
                <td>{{ $agent->company->company_type }}</td>
                <td>{{ $agent->nature_of_business }}</td>
                <td>{{ $agent->agent_first_name }}</td>
                <td>{{ $agent->agent_last_name }}</td>
                <td>{{ $agent->agent_designation }}</td>
                <td>{{ $agent->agent_dob }}</td>
                <td>{{ $agent->agent_office_address }}</td>
                <td>{{ $agent->agent_country }}</td>
                <td>{{ $agent->agent_state }}</td>
                <td>{{ $agent->agent_city }}</td>
                <td>{{ $agent->agent_pincode }}</td>
                <td>{{ $agent->agent_telephone }}</td>
                <td>{{ $agent->agent_mobile_number }}</td>
                <td>{{ $agent->agent_email }}</td>
                <td>{{ $agent->agent_website }}</td>
                <td>{{ $agent->agent_iata }}</td>
                <td>{{ $agent->agent_iata_number }}</td>
                <td>{{ $agent->agent_other_certification }}</td>
                <td>{{ $agent->agent_pan_number }}</td>
                <td>{{ $agent->agent_gst_number }}</td>
                <td>{{ $agent->agent_know_about }}</td>
                <td>{{ $agent->othername }}</td>                
                <td>{{ $agent->mgmt_first_name }}</td>
                <td>{{ $agent->mgmt_last_name }}</td>
                <td>{{ $agent->mgmt_contact_number }}</td>
                <td>{{ $agent->mgmt_email }}</td>
                <td>{{ $agent->account_first_name }}</td>
                <td>{{ $agent->account_last_name }}</td>
                <td>{{ $agent->account_contact_number }}</td>
                <td>{{ $agent->account_email }}</td>
                <td>{{ $agent->reserve_first_name }}</td>
                <td>{{ $agent->reserve_last_name }}</td>
                <td>{{ $agent->reserve_contact_number }}</td>
                <td>{{ $agent->reserve_email }}</td>
                <td>{{ $agent->user->email }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>
