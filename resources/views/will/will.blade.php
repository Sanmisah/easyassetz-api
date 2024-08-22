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
        .header {
            text-align: right;
            margin-bottom: 20px;
        }
        .header .date {
            font-size: 12px;
            color: #555;
        }
        .info {
            margin-bottom: 20px;
            text-align: center;
        }
        .info .date {
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="date">{{ $will->latest_call_at->format('d-m-Y') }}</div>
        <div class="date">{{ $will->latest_call_at->format('H:i:s') }}</div>
        <div class="date">First Generated Date: {{ $will->first_call_at->format('d-m-Y') }}</div>
        <div class="date">First Generated Time: {{ $will->first_call_at->format('H:i:s') }}</div>
        <div class="date">Count {{$will->call_count}}</div>
    </div>
    {{-- <div class="info">
        
    </div> --}}
    <h1 style="text-align: center; margin-bottom: 20px;">Will</h1>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Phone: {{ $user->mobile }}</p>
    <p>Address: {{$profile->permanent_house_flat_no}}, {{ $profile->permanent_address_line_1 }}, {{ $profile->permanent_pincode }}. </p>

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
                        case 'otherInsurance':
                            $assetName = $asset->{$assetType}->company_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->policy_number ?? 'Unknown';
                            break;
                        case 'superAnnuation':
                            $assetName = $asset->{$assetType}->company_name ?? 'Unknown';
                            $assetDescription = null;
                            break;
                        case 'shareDetail':
                            $assetName = $asset->{$assetType}->company_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->folio_number ?? 'Unknown';
                            break;
                        case 'mutualFund':
                            $assetName = $asset->{$assetType}->fund_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->folio_number ?? 'Unknown';
                            break;
                        case 'esop':
                            $assetName = $asset->{$assetType}->company_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->units_granted ?? 'Unknown';
                            break;
                        case 'debenture':
                        case 'bond':
                            $assetName = $asset->{$assetType}->bank_service_provider ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->folio_number ?? 'Unknown';
                            break;
                        case 'bullion':
                            $assetName = $asset->{$assetType}->metal_type ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->article_details ?? 'Unknown';
                            break;
                        case 'membership':
                            $assetName = $asset->{$assetType}->organization_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->membership_id ?? 'Unknown';
                            break;
                        case 'alternateInvestmentFund':
                        case 'portfolioManagement':
                            $assetName = $asset->investmentFund->fund_name ?? 'Unknown';
                            $assetDescription = $asset->investmentFund->folio_number ?? 'Unknown';
                            break;
                        case 'otherFinancialAsset':
                            $assetName = $asset->{$assetType}->bank_service_provider ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->folio_number ?? 'Unknown';
                            break;
                        case 'dematAccount':
                            $assetName = $asset->{$assetType}->depository ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->depository_name ?? 'Unknown';
                            break;
                        case 'wealthManagementAccount':
                            $assetName = $asset->{$assetType}->wealth_manager_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->account_number ?? 'Unknown';
                            break;
                        case 'brokingAccount':
                            $assetName = $asset->{$assetType}->broker_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->broking_account_number ?? 'Unknown';
                            break;
                        case 'jewellery':
                            $assetName = $asset->otherAsset->jewellery_type ?? 'Unknown';
                            $assetDescription = null;
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
                            $assetDescription = null;
                            break;
                        case 'partnershipFirm':
                            $assetName = $asset->businessAsset->firm_name ?? 'Unknown';
                            $assetDescription = null;
                            break;
                        case 'company':
                            $assetName = $asset->businessAsset->company_name ?? 'Unknown';
                            $assetDescription = $asset->businessAsset->company_address ?? 'Unknown';
                            break;
                        case 'intellectualProperty':
                            $assetName = $asset->businessAsset->type_of_ip ?? 'Unknown';
                            $assetDescription = $asset->businessAsset->firms_registration_number ?? 'Unknown';
                            break;
                        case 'land':
                            $assetName = $asset->{$assetType}->property_type ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->survey_number ?? 'Unknown';
                            break;
                        case 'residentialProperty':
                        case 'commercialProperty':
                            $assetName = $asset->{$assetType}->property_type ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->city ?? 'Unknown';
                            break;
                        case 'publicProvidentFund':
                        case 'bankLocker':
                        case 'homeLoan':
                        case 'personalLoan':
                        case 'otherLoan':
                            $assetName = $asset->{$assetType}->bank_name ?? 'Unknown';
                            $assetDescription = null;
                            break;
                        case 'providentFund':
                        case 'gratuity':
                            $assetName = $asset->{$assetType}->employer_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->employer_id ?? 'Unknown';
                            break;
                        case 'vehicleLoan':
                        case 'homeLoan':
                        case 'otherLoan':
                            $assetName = $asset->{$assetType}->bank_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->loan_account_no ?? 'Unknown';
                            break;
                        case 'bankAccount':
                            $assetName = $asset->{$assetType}->bank_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->account_type ?? 'Unknown';
                            break;
                        case 'fixDeposite':   //migit be type error
                            $assetName = $asset->{$assetType}->bank_name ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->branch_name ?? 'Unknown';
                            break;
                        case 'nps':
                            $assetName = $asset->{$assetType}->permanent_retirement_account_no ?? 'Unknown';
                            $assetDescription = null;
                            break;
                        case 'postalSavingAccount':
                            $assetName = $asset->{$assetType}->account_number ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->post_office_branch ?? 'Unknown';
                            break;
                        case 'postSavingScheme':
                            $assetName = $asset->{$assetType}->type ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->amount ?? 'Unknown';
                            break;
                        case 'otherDeposite': //might be error
                            $assetName = $asset->{$assetType}->fd_number ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->company ?? 'Unknown';
                            break;  
                        case 'litigation':
                            $assetName = $asset->{$assetType}->litigation_type ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->court_name ?? 'Unknown';
                            break;
                        case 'crypto':
                            $assetName = $asset->{$assetType}->crypto_wallet_type ?? 'Unknown';
                            $assetDescription = $asset->{$assetType}->crypto_wallet_type ?? 'Unknown';
                            break;
                        case 'digitalAsset':
                            $assetName = $asset->{$assetType}->digital_asset ?? 'Unknown';
                            $assetDescription = null;
                            break;
                        // Add other cases for different asset types
                        default:
                            $assetName = $asset->{$assetType}->info ?? 'Unknown'; // Use a generic field
                            $assetDescription = null;
                            break;
                    }
                }
            @endphp

            <h3 style="margin-bottom: 0px; margin-top:2px">{{ $assetName }}</h3>
            <p style="margin-top: 1px; margin-botton: 1px;">{{ @$assetDescription }}</p>
            
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
