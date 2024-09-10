<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'schedule_id',
        'patient_name',
        'appointment_time',
    ];

    /**
     * Relación con el profesional.
     * Una cita está relacionada con un profesional.
     */
    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    /**
     * Relación con el horario reservado (schedule).
     * Una cita pertenece a un solo horario.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
