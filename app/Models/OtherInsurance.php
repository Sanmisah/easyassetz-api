<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherInsurance extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class, 'other_insurance_nominee');
    }
}
