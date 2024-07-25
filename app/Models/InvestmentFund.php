<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Beneficiary;

class InvestmentFund extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'investment_fund_nominee');
     }
}
