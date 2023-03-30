<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $table = 'availability';

    protected $fillable = [
        'doctor_id',
        'available_date',
        'start_time',
        'end_time'
    ];

    protected $dates = [
        'available_date',
        'start_time',
        'end_time'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
?>