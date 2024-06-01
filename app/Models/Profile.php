<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fullLegalName',
        'gender',
        'dob',
        'nationality',
        'countryOfResidence',
        'religion',
        'maritalStatus',
        'marriedUnderSpecialAct',
        'correspondenceEmail',
        'permanentHouseFlatNo',
        'permanentAddressLine1',
        'permanentAddressLine2',
        'permanentPincode',
        'permanentCity',
        'permanentState',
        'permanentCountry',
        //'current_address',
        'currentHouseFlatNo',
        'currentAddressLine1',
        'currentAddressLine2',
        'currentPincode',
        'currentCity',
        'currentState',
        'currentCountry',
       // 'identification_details',
        'adharNumber',
        'adharName',
        'adharFile',
        'panNumber',
        'panName',
        'panFile',
        'passportNumber',
        'passportName',
        'passportExpiryDate',
        'passportPlaceOfIssue',
        'passportFile',
        'drivingLicenceNumber',
        'drivingLicenceName',
        'drivingLicenceExpiryDate',
        'drivingLicencePlaceOfIssue',
        'drivingLicenceFile',
    ];
}
