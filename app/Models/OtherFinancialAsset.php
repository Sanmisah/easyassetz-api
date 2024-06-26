<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherFinancialAsset extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'other_financial_nominee');
     }

     public function jointHolder(){
        return $this->belongsToMany(Beneficiary::class,'other_financial_joint_holder');
     }
     
}
