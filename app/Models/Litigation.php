<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Litigation extends Model
{
    use HasFactory;

    public function setCaseFillingDateAttribute($value)
    {
        if($value){
            $this->attributes['case_filling_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        }
    }

    public function getCaseFillingDateAttribute($value)
    {
        if($value){       
            return Carbon::parse($value)->format('m/d/Y');
        }
    }    

}
