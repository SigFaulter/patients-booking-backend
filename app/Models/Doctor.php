<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'full_name',
        'phone_number',
        'city',
        'qualifications',
        'patients_treated',
        'rating',
        'image',
        'clinic_address',
        'price',
    ];
}
?>
