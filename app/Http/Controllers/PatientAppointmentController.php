<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PatientAppointmentController extends Controller
{
    // Mostrar lista de profesionales para que el paciente elija
    public function index()
    {
        $professionals = User::where('role', 'professional')->get();
        return view('patient_appointments.index', compact('professionals'));
    }

    // Mostrar citas disponibles (horarios) de un profesional específico
    public function show($professional_id)
    {
        // Obtener los horarios no reservados
        $schedules = Schedule::where('professional_id', $professional_id)
            ->where('is_booked', false)
            ->where('available_date', '>=', now())
            ->orderBy('available_date', 'asc')
            ->take(3)
            ->get();

        // Convertir los campos de fecha a objetos Carbon si es necesario
        foreach ($schedules as $schedule) {
            $schedule->available_date = Carbon::parse($schedule->available_date);
            $schedule->start_time = Carbon::parse($schedule->start_time);
        }

        $professional = User::findOrFail($professional_id);

        return view('patient_appointments.show', compact('schedules', 'professional'));
    }

    public function reserve($schedule_id)
    {
        // Obtener el horario específico para la reserva
        $schedule = Schedule::findOrFail($schedule_id);

        // Convertir los campos a Carbon para poder usar el método format() en la vista
        $schedule->available_date = Carbon::parse($schedule->available_date);
        $schedule->start_time = Carbon::parse($schedule->start_time)->format('H:i');

        return view('patient_appointments.reserve', compact('schedule'));
    }

    // Reservar una cita
    public function book(Request $request, $schedule_id)
    {
        $request->validate([
            'patient_name' => 'required',
        ]);

        // Buscar el horario disponible
        $schedule = Schedule::where('id', $schedule_id)
            ->where('is_booked', false)
            ->firstOrFail();

        // Crear la cita vinculada al horario seleccionado
        Appointment::create([
            'professional_id' => $schedule->professional_id,
            'schedule_id' => $schedule->id,
            'patient_name' => $request->input('patient_name'),
            'appointment_time' => $schedule->available_date . ' ' . $schedule->start_time, // Guardar la fecha y hora de la cita
        ]);

        // Marcar el horario como reservado
        $schedule->update(['is_booked' => true]);

        return redirect()->route('patient_appointments.index')->with('success', 'Cita reservada con éxito.');
    }

    public function calendar($professional_id)
    {
        // Buscar el profesional usando el professional_id
        $professional = User::findOrFail($professional_id);

        // Devolver la vista del calendario con el objeto del profesional
        return view('patient_appointments.calendar', compact('professional'));
    }


    public function getAvailableDates($professional_id)
    {
        // Obtener los horarios no reservados y que pertenezcan al profesional específico
        $schedules = Schedule::where('professional_id', $professional_id)
            ->where('is_booked', false)
            ->get();

        $events = [];

        // Crear los eventos para el calendario
        foreach ($schedules as $schedule) {
            $events[] = [
                'title' => 'Disponible: ' . \Carbon\Carbon::parse($schedule->start_time)->format('H:i A'),
                'start' => $schedule->available_date . 'T' . $schedule->start_time,
                'end' => $schedule->available_date . 'T' . $schedule->end_time,
                'color' => '#28a745', // Color para las fechas disponibles
            ];
        }

        return response()->json($events);
    }

    public function getAvailableTimes($professional_id, $date)
    {
        // Obtener los horarios disponibles para la fecha y profesional específico
        $schedules = Schedule::where('professional_id', $professional_id)
            ->where('available_date', $date)
            ->where('is_booked', false)
            ->get();

        // Crear un array de horarios con el ID de la cita y la hora de inicio
        $times = $schedules->map(function ($schedule) {
            return [
                'schedule_id' => $schedule->id,
                'start_time' => \Carbon\Carbon::parse($schedule->start_time)->format('H:i A'),
            ];
        });

        // Devolver los horarios en formato JSON
        return response()->json($times);
    }
}
