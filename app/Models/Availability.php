<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'start_time',
        'end_time'
    ];

    protected $dates = [
        'available_date',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
?>