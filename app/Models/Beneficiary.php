<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beneficiary extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'profile_id',
        'fullLegalName',
        'relationship',
        'gender',
        'dob',
        'guardianFullLegalName',
        'guardianMobileNumber',
        'guardianEmail',
        'guardianCity',
        'guardianState',
        'adharNumber',
        'panNumber',
        'passportNumber',
        'drivingLicenceNumber',
        'religion',
        'nationality',
        'houseFlatNo',
        'addressLine1',
        'addressLine2',
        'pincode',
        'beneficiaryCity',
        'beneficiaryState',
        'country',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class, 'profile_id');
    }

}
