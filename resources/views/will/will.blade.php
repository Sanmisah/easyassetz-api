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


      

   
</body>
</html>




 

















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