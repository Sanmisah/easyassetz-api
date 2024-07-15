<?php

namespace App\Models;

use App\Models\Beneficiary;
use App\Models\PublicProvidentFund;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublicProvidentFund extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'public_provident_fund_nominee');
     }

}
