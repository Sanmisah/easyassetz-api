<?php

namespace App\Models;

use App\Models\SuperAnnuation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuperAnnuation extends Model
{
    use HasFactory;


    public function nominee(){
        return $this->belongsToMany(SuperAnnuation::class, 'super_annuation_nominee');
    }
    
}
