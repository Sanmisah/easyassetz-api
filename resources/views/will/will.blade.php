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
        <h2 style=" margin-top: 50px;">
            {{ ucwords(str_replace('_', ' ', preg_replace('/(?<!^)([A-Z])/', ' $1', $assetType))) }}
        </h2>

        @foreach ($allocationsById as $assetId => $allocations)
            {{-- Get the asset name based on asset type --}}
            @php
                $asset = $allocations['primaryAllocation']->first() ?? $allocations['secondaryAllocation']->first() ?? $allocations['tertiaryAllocation']->first();
                $assetName = 'Unknown';
                $assetDescription = 'Unknown';

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
                            $assetDescription = $asset->{$assetType}->article_details ?? 'Unknown';
                            break;
                        case 'membership':
                            $assetName = $asset->{$assetType}->organization_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->membership_id ?? 'Unknown';
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
                            $assetDescription = $asset->{$assetType}->model ?? 'Unknown';
                            break;
                        case 'huf':
                            $assetName = $asset->otherAsset->huf_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->pan_number ?? 'Unknown';
                            break;
                        case 'vehicle':
                            $assetName = $asset->otherAsset->vehicle_type ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->model ?? 'Unknown';
                            break;
                        case 'otherAsset':
                            $assetName = $asset->otherAsset->name_of_asset ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->asset_description ?? 'Unknown';
                            break;
                        case 'recoverable':
                            $assetName = $asset->otherAsset->name_of_borrower ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->address ?? 'Unknown';
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
                            $assetDescription = $asset->{$assetType}->crypto_wallet_type ?? 'Unknown';
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

            <h3>{{ $assetName }}</h3>
            
            <table>
                <thead>
                    <tr>
                        <th>Beneficiaries</th>
                        <th>Allocation</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Primary Allocation --}}
                    @if (count($allocations['primaryAllocation']) > 0)
                        <tr>
                            <th colspan="2">Primary Beneficiaries</th>
                        </tr>
                        @foreach ($allocations['primaryAllocation'] as $asset)
                            <tr>
                                <td>{{ $asset->beneficiary->full_legal_name ?? 'N/A' }}</td>
                                <td>{{ $asset->allocation ?? 'N/A' }}%</td>

                            </tr>
                        @endforeach
                    @endif

                    {{-- Secondary Allocation --}}
                    @if (count($allocations['secondaryAllocation']) > 0)
                        <tr>
                            <th colspan="2">Secondary Beneficiaries</th>
                        </tr>
                        @foreach ($allocations['secondaryAllocation'] as $asset)
                            <tr>
                                <td>{{ $asset->beneficiary->full_legal_name ?? 'N/A' }}</td>
                                <td>{{ $asset->allocation ?? 'N/A' }}%</td>
                            </tr>
                        @endforeach
                    @endif

                    {{-- Tertiary Allocation --}}
                    @if (count($allocations['tertiaryAllocation']) > 0)
                        <tr>
                            <th colspan="2">Tertiary Beneficiaries</th>
                        </tr>
                        @foreach ($allocations['tertiaryAllocation'] as $asset)
                            <tr>
                                <td>{{ $asset->beneficiary->full_legal_name ?? 'N/A' }}</td>
                                <td>{{ $asset->allocation ?? 'N/A' }}%</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endforeach
    @endforeach
    
</body>
</html>
