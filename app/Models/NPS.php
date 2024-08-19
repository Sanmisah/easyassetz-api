<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NPS extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'n_p_s_nominee');
     }

     public function jointHolder(){
        return $this->belongsToMany(Beneficiary::class,'n_p_s_joint_holder');
     }
     
}