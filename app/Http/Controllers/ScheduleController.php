<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Mostrar el formulario para que los profesionales carguen sus horarios
    public function create()
    {
        return view('schedules.create');
    }

    // Almacenar el horario del profesional
    public function store(Request $request)
    {
        $request->validate([
            'available_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Schedule::create([
            'professional_id' => auth()->id(), // Profesional autenticado
            'available_date' => $request->available_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Horario creado correctamente.');
    }

    // Mostrar los horarios de un profesional
    public function index()
    {
        $schedules = Schedule::where('professional_id', auth()->id())->get();
        return view('schedules.index', compact('schedules'));
    }
}
