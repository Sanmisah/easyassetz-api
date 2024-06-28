<?php

namespace App\Models;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankLocker extends Model
{
    use HasFactory;

    public function setRentDueDateAttribute($value)
    {
       if($value){
           $this->attributes['rent_due_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
       }
    }

    public function getRentDueDateAttribute($value)
    {
       if($value){
           return Carbon::parse($value)->format('d/m/Y');
       }
    }    

    public function nominee(){
        return $this->belongsToMany(Beneficiary::class,'bank_locker_nominee');
     }

     public function jointHolder(){
        return $this->belongsToMany(Beneficiary::class,'bank_locker_joint_holder');
     }

}
