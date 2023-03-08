<table>
    <thead>
        <tr>           
            <th>First Name</th>
            <th>Last Name</th>           
            <th>Date Of Birth</th>           
            <th>Country</th>
            <th>State</th>
            <th>City</th>
            <th>Zipcode</th>
            <th>Telephone</th>
            <th>Mobile Number</th>           
            <th>Login Email</th>           
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
         
            <tr>              
                <td>{{ $customer->user->first_name }}</td>
                <td>{{ $customer->user->last_name }}</td>                
                <td>{{ $customer->dob }}</td>                
                <td>{{ $customer->countryname->name }}</td>
                <td>{{ $customer->statename->name }}</td>
                <td>{{ $customer->cityname->name }}</td>
                <td>{{ $customer->zipcode }}</td>
                <td>{{ $customer->telephone }}</td>
                <td>{{ $customer->mobile_number }}</td>
                <td>{{ $customer->user->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
