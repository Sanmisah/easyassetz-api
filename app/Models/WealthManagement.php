<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WealthManagement extends Model
{
    use HasFactory;

    protected $table = 'wealth_managements';
    protected $primaryKey = 'id';
    
    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'wealth_management_nominee');
     }

     public function jointHolder(){
        return $this->belongsToMany(Beneficiary::class,'wealth_management_joint_holder');
     }


}
