<?php

namespace App\Models;

use App\Models\Membership;
use App\Models\Beneficiary;
use App\Models\LifeInsurance;
use App\Models\MotorInsurance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'will_id',
        'beneficiary_id',
        'asset_id',
        'asset_type',
        'level',
        'allocation',
    ];


    public function beneficiary(){
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }


    public function motorInsurance(){
        return $this->belongsTo(MotorInsurance::class, 'asset_id');
    }

    public function lifeInsurance(){
        return $this->belongsTo(LifeInsurance::class, 'asset_id');
    }

    public function membership(){
        return $this->belongsTo(Membership::class, 'asset_id');
    }


}