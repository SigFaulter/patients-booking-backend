<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone_number',
        'id_card',
        'birthday',
        'age',
        'medical_history',
    ];

    protected $dates = [
        'birthday',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
?>