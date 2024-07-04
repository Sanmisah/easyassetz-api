<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessAsset extends Model
{
    use HasFactory;

    public function setExpiryDateAttribute($value)
    {
       if($value){
           $this->attributes['expiry_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
       }
    }

    public function getExpiryDateAttribute($value)
    {
       if($value){
           return Carbon::parse($value)->format('m/d/Y');
       }
    }    

    public function setDateOfAssignmentAttribute($value)
    {
       if($value){
           $this->attributes['date_of_assignment'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
       }
    }

    public function getDateOfAssignmentAttribute($value)
    {
       if($value){
           return Carbon::parse($value)->format('m/d/Y');
       }
    }    

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'business_asset_nominee');
     }

   

}
