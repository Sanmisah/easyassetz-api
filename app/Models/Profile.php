<?php

namespace App\Models;

use App\Models\User;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'used_id');
    }

    public function beneficiary(){
        return $this->hasMany(Beneficiary::class, 'profile_id');
    }


}
