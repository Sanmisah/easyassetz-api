<?php

namespace App\Models;

use App\Models\User;
use App\Models\Charity;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'currentHouseFlatNo',
        'currentAddressLine1',
        'currentAddressLine2',
        'currentPincode',
        'currentCity',
        'currentState',
        'currentCountry',
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

   public function user(){
    return $this->belongsTo(User::class, 'user_id');
   }

   public function beneficiary(){
    return $this->hasMany(Beneficiary::class, 'profile_id');
  }

    public function charity(){
        return $this->hasMany(Charity::class, 'profile_id');
    }


}
