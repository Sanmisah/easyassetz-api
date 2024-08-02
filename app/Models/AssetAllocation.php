<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'will_id',
        'beneficiary_id',
        'asset_id',
        'asset_type',
        'level',
        'allocation',
    ];

}
