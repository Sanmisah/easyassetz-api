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

    @foreach ($Assets as $assetType => $allocationsById)
        {{-- <h2 style="text-align: center;">{{ ucfirst($assetType) }}</h2> --}}
        <h2 style="text-align: center; margin-top: 50px;">
            {{ ucwords(str_replace('_', ' ', preg_replace('/(?<!^)([A-Z])/', ' $1', $assetType))) }}
        </h2>
        

        @foreach ($allocationsById as $assetId => $allocations)
            {{-- Get the asset name based on asset type --}}
            @php
                $asset = $allocations['primaryAllocation']->first() ?? $allocations['secondaryAllocation']->first() ?? $allocations['tertiaryAllocation']->first();
                $assetName = 'Unknown';

                if ($asset) {
                    switch ($assetType) {
                        case 'motorInsurance':
                        case 'lifeInsurance':
                        case 'healthInsurance':
                        case 'generalInsurance':
                        case 'shareDetail':
                        case 'esop':
                        case 'superAnnuation':
                            $assetName = $asset->{$assetType}->company_name ?? 'Unknown';
                            break;
                        case 'bullion':
                            $assetName = $asset->{$assetType}->metal_type ?? 'Unknown';
                            break;
                        case 'membership':
                            $assetName = $asset->{$assetType}->organization_name ?? 'Unknown';
                            break;
                        case 'mutualFund':
                        case 'investmentFund':
                        case 'portfolioManagement':
                            $assetName = $asset->{$assetType}->fund_name ?? 'Unknown';
                            break;
                        case 'debenture':
                        case 'bond':
                        case 'otherFinancialAsset':
                            $assetName = $asset->{$assetType}->bank_service_provider ?? 'Unknown';
                            break;
                        case 'dematAccount':
                            $assetName = $asset->{$assetType}->depository ?? 'Unknown';
                            break;
                        case 'wealthManagementAccount':
                            $assetName = $asset->{$assetType}->wealth_manager_name ?? 'Unknown';
                            break;
                        case 'brokingAccount':
                            $assetName = $asset->{$assetType}->brocker_name ?? 'Unknown';
                            break;
                        case 'jewellery':
                            $assetName = $asset->otherAsset->jewellery_type ?? 'Unknown';
                            break;
                        case 'watch':
                            $assetName = $asset->otherAsset->company ?? 'Unknown';
                            break;
                        case 'huf':
                            $assetName = $asset->otherAsset->huf_name ?? 'Unknown';
                            break;
                        case 'vehicle':
                            $assetName = $asset->otherAsset->vehicle_type ?? 'Unknown';
                            break;
                        case 'otherAsset':
                            $assetName = $asset->otherAsset->name_of_asset ?? 'Unknown';
                            break;
                        case 'recoverable':
                            $assetName = $asset->otherAsset->name_of_borrower ?? 'Unknown';
                            break;
                        case 'propritorship':
                            $assetName = $asset->businessAsset->firm_name ?? 'Unknown';
                            break;
                        case 'partnershipFirm':
                            $assetName = $asset->businessAsset->firm_name ?? 'Unknown';
                            break;
                        case 'company':
                            $assetName = $asset->businessAsset->company_name ?? 'Unknown';
                            break;
                        case 'intellectualProperty':
                            $assetName = $asset->businessAsset->type_of_ip ?? 'Unknown';
                            break;
                        case 'land':
                        case 'residentialProperty':
                        case 'commercialProperty':
                            $assetName = $asset->{$assetType}->property_type ?? 'Unknown';
                            break;
                        case 'publicProvidentFund':
                        case 'bankAccount':
                        case 'bankLocker':
                        case 'fixDeposite':   //migit be type error
                        case 'homeLoan':
                        case 'personalLoan':
                        case 'vehicleLoan':
                        case 'otherLoan':
                            $assetName = $asset->{$assetType}->bank_name ?? 'Unknown';
                            break;
                        case 'providentFund':
                        case 'gratuity':
                            $assetName = $asset->{$assetType}->employer_name ?? 'Unknown';
                            break;
                        case 'nps':
                            $assetName = $asset->{$assetType}->permanent_retirement_account_no ?? 'Unknown';
                            break;
                        case 'postalSavingAccount':
                            $assetName = $asset->{$assetType}->account_number ?? 'Unknown';
                            break;
                        case 'postSavingScheme':
                            $assetName = $asset->{$assetType}->type ?? 'Unknown';
                            break;
                        case 'otherDeposite':
                            $assetName = $asset->{$assetType}->fd_number ?? 'Unknown';
                            break;
                        case 'homeLoan':
                            $assetName = $asset->{$assetType}->fd_number ?? 'Unknown';
                            break;
                        case 'litigation':
                            $assetName = $asset->{$assetType}->litigation_type ?? 'Unknown';
                            break;
                        case 'crypto':
                            $assetName = $asset->{$assetType}->crypto_wallet_type ?? 'Unknown';
                            break;
                        case 'digitalAsset':
                            $assetName = $asset->{$assetType}->digital_asset ?? 'Unknown';
                            break;
                        // Add other cases for different asset types
                        default:
                            $assetName = $asset->{$assetType}->info ?? 'Unknown'; // Use a generic field
                            break;
                    }
                }
            @endphp

            <h3 style="text-align: center;">{{ $assetName }}</h3>
            
            @foreach (['primaryAllocation' => 'Primary', 'secondaryAllocation' => 'Secondary', 'tertiaryAllocation' => 'Tertiary'] as $key => $level)
                <h4 style="text-align: center;">{{ $level }} Beneficiary</h4>
                <table>
                    <thead>
                        <tr>
                            {{-- @if (in_array($assetType, ['motorInsurance', 'lifeInsurance', 'healthInsurance', 'generalInsurance','shareDetail']))
                                <th>Company Name</th>
                            @elseif (in_array($assetType, ['bullion']))
                                <th>Metal Type</th>
                            @elseif (in_array($assetType, ['membership']))
                                <th>Organization Name</th>
                            @elseif (in_array($assetType, ['mutualFund']))
                                <th>Fund Name</th>
                            @elseif (in_array($assetType, ['debenture']))
                                <th>bank service provider</th>
                            @else
                                <th>Asset Info</th>
                            @endif --}}
                            <th>Beneficiaries</th>
                            <th>Allocation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allocations[$key] as $asset)
                            <tr>
                                {{-- @if (in_array($assetType, ['motorInsurance', 'lifeInsurance', 'generalInsurance', 'healthInsurance','shareDetail']))
                                    <td>{{ $asset->{$assetType}->company_name ?? 'N/A' }}</td>
                                @elseif ($assetType === 'bullion')
                                    <td>{{ $asset->{$assetType}->metal_type ?? 'N/A' }}</td>
                                @elseif ($assetType === 'membership')
                                    <td>{{ $asset->{$assetType}->organization_name ?? 'N/A' }}</td>
                                @elseif ($assetType === 'mutualFund')
                                    <td>{{ $asset->{$assetType}->fund_name ?? 'N/A' }}</td>
                                @elseif ($assetType === 'debenture')
                                    <td>{{ $asset->{$assetType}->bank_service_provider ?? 'N/A' }}</td>
                                @else
                                    <td>{{ $asset->{$assetType}->info ?? 'N/A' }}</td>
                                @endif --}}
                                <td>{{ $asset->beneficiary->full_legal_name ?? 'N/A' }}</td>
                                <td>{{ $asset->allocation ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No {{ strtolower($level) }} allocations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endforeach
        @endforeach
    @endforeach
</body>
</html>
