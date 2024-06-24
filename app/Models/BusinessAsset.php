<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessAsset extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'business_asset_nominee');
     }

     public function jointHolder(){
        return $this->belongsToMany(Beneficiary::class,'business_asset_joint_holder');
     }

     public function setExpiryDateAttribute($value)
     {
         $this->attributes['expiry_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
     }
 
     public function getExpiryDateAttribute($value)
     {
         return Carbon::parse($value)->format('d/m/Y');
     }    

}
