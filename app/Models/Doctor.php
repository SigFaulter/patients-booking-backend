<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone_number',
        'city',
        'qualifications',
        'patients_treated',
        'rating' // TODO update this automaticall from users reviews
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
?>
