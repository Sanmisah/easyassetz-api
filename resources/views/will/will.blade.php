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

    <h2 style="text-align: center;">Motor Insurance</h2>

    <h4 style="text-align: center;">Primary Beneficiary</h4>
    <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Beneficiaries</th>
                <th>Allocation</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($Assets['primaryAllocation'] as $asset)
                <tr>
                    <td>{{ $asset->motorInsurance->company_name }}</td>
                    <td>{{ $asset->beneficiary->full_legal_name }}</td>
                    <td>{{ $asset->allocation }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No primary allocations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 style="text-align: center;">Secondary Beneficiary</h4>
    <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Beneficiaries</th>
                <th>Allocation</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($Assets['secondaryAllocation'] as $asset)
                <tr>
                    <td>{{ $asset->motorInsurance->company_name }}</td>
                    <td>{{ $asset->beneficiary->full_legal_name }}</td>
                    <td>{{ $asset->allocation }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No secondary allocations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 style="text-align: center;">Tertiary Beneficiary</h4>
    <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Beneficiaries</th>
                <th>Allocation</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($Assets['tertiaryAllocation'] as $asset)
                <tr>
                    <td>{{ $asset->motorInsurance->company_name }}</td>
                    <td>{{ $asset->beneficiary->full_legal_name }}</td>
                    <td>{{ $asset->allocation }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No tertiary allocations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
