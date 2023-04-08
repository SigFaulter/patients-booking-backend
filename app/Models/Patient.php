<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'full_name',
        'phone_number',
        'id_card',
        'birthday',
        'medical_history',
        'image',
    ];

    protected $dates = [
        'birthday',
    ];


    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
?>