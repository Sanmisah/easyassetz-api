<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MutualFund extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'mutual_fund_nominee');
     }

     public function jointHolder(){
        return $this->belongsToMany(Beneficiary::class,'mutual_fund_joint_holder');
     }

}
