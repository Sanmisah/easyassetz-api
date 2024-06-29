<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostSavingScheme extends Model
{
    use HasFactory;

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'post_saving_scheme_nominee');
     }

     public function jointHolder(){
        return $this->belongsToMany(Beneficiary::class,'post_saving_scheme_joint');
     }

}
