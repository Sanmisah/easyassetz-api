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
            margin-bottom: 20px;
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

    @foreach ($Assets as $assetType => $allocations)
        <h2 style="text-align: center;">{{ ucfirst($assetType) }}</h2>

        @foreach (['primaryAllocation' => 'Primary', 'secondaryAllocation' => 'Secondary', 'tertiaryAllocation' => 'Tertiary'] as $key => $level)
            <h4 style="text-align: center;">{{ $level }} Beneficiary</h4>
            <table>
                <thead>
                    <tr>
                        @if (in_array($assetType, ['motorInsurance', 'lifeInsurance', 'healthInsurance', 'generalInsurance']))
                            <th>Company Name</th>
                        @elseif (in_array($assetType, ['bullion']))
                            <th>Metal Type</th>
                        @else
                            <th>Asset Info</th>
                        @endif
                        <th>Beneficiaries</th>
                        <th>Allocation</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allocations[$key] as $asset)
                        <tr>
                            @if (in_array($assetType, ['motorInsurance', 'lifeInsurance', 'generalInsurance', 'healthInsurance']))
                                <td>{{ $asset->{$assetType}->company_name ?? 'N/A' }}</td>
                            @elseif ($assetType === 'bullion')
                                <td>{{ $asset->{$assetType}->metal_type ?? 'N/A' }}</td>
                            @else
                                <td>{{ $asset->{$assetType}->info ?? 'N/A' }}</td>
                            @endif
                            <td>{{ $asset->beneficiary->full_legal_name ?? 'N/A' }}</td>
                            <td>{{ $asset->allocation ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No {{ strtolower($level) }} allocations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endforeach
    @endforeach
</body>
</html>
