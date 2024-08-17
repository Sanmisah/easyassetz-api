<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Will</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; margin-bottom: 20px;">Will</h1>
      <p>Name: {{ $user->name }}</p>
      <p>Email: {{ $user->email }}</p>
      <p>Phone: {{ $user->mobile }}</p>
      <p>Address: {{ $profile->permanent_address_line_1 }}</p>


     {{-- @foreach ($assets as $asset)

       if($asset->asset_type === "motorInsurance"){
        <h2 style="text-align: center;">Motor Insurance</h2>
         <h3 style="text-align: center;">{{$asset->motorInsurance->company_name}} - {{$asset->motorInsurance->policy_number}}</h3>
       }
         
         
         
         @endforeach

            <h4 style="text-align: center;">Primary Allocation</h4>

             <table>  
        <tbody>
            @foreach ($assets as $asset)
            <tr>
                <th>{{$asset->beneficiary->full_legal_name}}</th>
                <td>{{$asset->allocation}}</td>
            </tr>
            @endforeach
          
            <tr>
                <th>Data 11</th>
                <td>Data 12</td>
            </tr>
        </tbody>
    </table> 

  <h1>end</h1> --}}

  {{-- @foreach ($motorInsuranceData as $data)
     <h2 style="text-align: center;">Motor Insurance</h2>
     <h3 style="text-align: center">{{ $data['primaryAllocation'][0]->motorInsurance->company_name }} - {{$data['primaryAllocation'][0]->motorInsurance->policy_number}}</h3> 
      <h4 style="text-align: center;">Primary Allocation</h4>
    <table>
        <thead>
            <tr>
                <th>Beneficiary</th>
                <th>Allocation</th>
            </tr>
        </thead>
        <tbody>
   @foreach ($data['primaryAllocation'] as $primary)        
                    <tr>
                        <td>{{$primary->beneficiary->full_legal_name}}</td>
                        <td>{{$primary->allocation}}</td>
                    </tr>     
    @endforeach
</tbody>
</table>

     <h4 style="text-align: center; margin-top: 20px;">Secondary Allocation</h4>
    <table>
        <thead>
            <tr>
                <th>Beneficiary</th>
                <th>Allocation</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($data['secondaryAllocation'] as $secondary)        
                    <tr>
                        <td>{{$secondary->beneficiary->full_legal_name}}</td>
                        <td>{{$secondary->allocation}}</td>
                    </tr>     
    @endforeach
    </tbody>
    </table>

     <h4 style="text-align: center; margin-top: 20px;">Tertiary Allocation</h4>
    <table>
        <thead>
            <tr>
                <th>Beneficiary</th>
                <th>Allocation</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($data['tertiaryAllocation'] as $tertiary)
                    <tr>
                        <td>{{$tertiary->beneficiary->full_legal_name}}</td>
                        <td>{{$tertiary->allocation}}</td>
                    </tr>     
    @endforeach
    </tbody>
    </table>

@endforeach

   
</body>
</html>




 --}}

















 {{-- <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Primary Beneficiaries</th>
                <th>secondary Beneficiaries</th>
                <th>Tertiary Beneficiaries</th>
                <th>Allocation 5</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($motorInsurance as $asset)
            <tr>
                <td>{{$asset->motorInsurance->company_name}}</td>
                <td>{{$asset->beneficiary->full_legal_name}}</td>
                <td>Data 4</td>
                <td>Data 5</td>
            </tr>
            @endforeach
           
            <tr>
                <td>Data 6</td>
                <td>Data 7</td>
                <td>Data 8</td>
                <td>Data 9</td>
                <td>Data 10</td>
            </tr>
            <tr>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
            </tr>
        </tbody>
    </table> --}}