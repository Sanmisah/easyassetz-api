<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LifeInsurance extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }


}
