<?php

namespace App\Models;

use App\Models\Membership;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use HasFactory;
    
    public function nominee(){
    return $this->belongsToMany(Beneficiary::class,'membership_nominee');
    }
    
}