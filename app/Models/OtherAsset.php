<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherAsset extends Model
{
    use HasFactory;

    public function setDueDateAttribute($value)
    {
       if($value){
           $this->attributes['due_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
       }
    }

    public function getDueDateAttribute($value)
    {
       if($value){
           return Carbon::parse($value)->format('m/d/Y');
       }
    }    

    public function setYearOfManufactureAttribute($value)
    {
       if($value){
           $this->attributes['year_of_manufacture'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
       }
    }

    public function getYearOfManufactureAttribute($value)
    {
       if($value){
           return Carbon::parse($value)->format('m/d/Y');
       }
    }    


    public function setYearOfExpiryAttribute($value)
    {
       if($value){
           $this->attributes['year_of_expiry'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
       }
    }

    public function getYearOfExpiryAttribute($value)
    {
       if($value){
           return Carbon::parse($value)->format('m/d/Y');
       }
    }    

    
}