<?php

namespace App\Models;

use App\Models\AssetAllocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Will extends Model
{
    use HasFactory;

    protected $casts = [
        'first_call_at' => 'datetime',
        'latest_call_at' => 'datetime',
    ];

    protected $fillable = [
        'profile_id',
    ];

    public function assetAllocation(){
        return $this->hasMany(AssetAllocation::class, 'will_id');
    }

}
