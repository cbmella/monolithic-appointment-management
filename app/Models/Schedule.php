<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'available_date',
        'start_time',
        'end_time',
        'is_booked',
    ];

    /**
     * Relación con el profesional.
     * Un horario pertenece a un solo profesional.
     */
    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    /**
     * Relación con una cita (appointment).
     * Un horario puede estar relacionado con una cita, si ha sido reservado.
     */
    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
