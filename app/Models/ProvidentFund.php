<?php

namespace App\Models;

use App\Models\ProvidentFund;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProvidentFund extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(ProvidentFund::class,'provident_fund_nominee');
     }

}
