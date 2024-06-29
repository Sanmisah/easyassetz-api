<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleLoan extends Model
{
    use HasFactory;

    public function setEmiDateAttribute($value)
    {
        if($value){
            $this->attributes['emi_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        }
    }

    public function getEmiDateAttribute($value)
    {
        if($value){       
            return Carbon::parse($value)->format('m/d/Y');
        }
    }    


    public function setStartDateAttribute($value)
    {
        if($value){
            $this->attributes['start_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        }
    }

    public function getStartDateAttribute($value)
    {
        if($value){       
            return Carbon::parse($value)->format('m/d/Y');
        }
    }    



}
