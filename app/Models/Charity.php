<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charity extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'organizationName',
        'address1',
        'address2',
        'charityCity',
        'state',
        'phoneNumber',
        'email',
        'contactPerson',
        'website',
        'specificInstruction',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}
