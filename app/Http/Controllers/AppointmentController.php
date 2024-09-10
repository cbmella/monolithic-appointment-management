<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        // Obtener el horario reservado
        $schedule = Schedule::findOrFail($request->schedule_id);

        Appointment::create([
            'professional_id' => $schedule->professional_id,
            'schedule_id' => $schedule->id,
            'patient_name' => $request->input('patient_name'),
            'appointment_time' => $schedule->available_date . ' ' . $schedule->start_time,
        ]);

        // Marcar el horario como reservado
        $schedule->update(['is_booked' => true]);

        return redirect()->route('appointments.index')
            ->with('success', 'Cita creada correctamente.');
    }

    public function edit(Appointment $appointment)
    {
        $appointment->appointment_time = \Carbon\Carbon::parse($appointment->appointment_time);
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_name' => 'required',
            'appointment_time' => 'required|date',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')
            ->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Cita eliminada correctamente.');
    }
}
