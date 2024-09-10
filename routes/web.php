<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PatientAppointmentController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

// Ruta para la página principal
Route::get('/', function () {
    return view('welcome');
});

// Ruta para el dashboard, requiere autenticación y verificación de email
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas para perfiles de usuarios (profesionales o admin)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// **Rutas públicas para seleccionar profesionales y ver horarios disponibles**
// Estas rutas serán accesibles para cualquier visitante, sin necesidad de autenticarse
Route::get('/appointments', [PatientAppointmentController::class, 'index'])->name('patient_appointments.index'); // Lista de profesionales
Route::get('/appointments/{professional}/calendar', [PatientAppointmentController::class, 'calendar'])->name('appointments.calendar');
Route::get('/appointments/{professional}/events', [PatientAppointmentController::class, 'getAvailableDates'])->name('appointments.events');
Route::get('/appointments/{professional}/times/{date}', [PatientAppointmentController::class, 'getAvailableTimes'])->name('appointments.times');
Route::get('/appointments/{professional}', [PatientAppointmentController::class, 'show'])->name('patient_appointments.show'); // Ver horarios disponibles de un profesional
Route::post('/appointments/{schedule}/book', [PatientAppointmentController::class, 'book'])->name('patient_appointments.book'); // Reservar cita
route::get('/appointments/{schedule}/reserve', [PatientAppointmentController::class, 'reserve'])->name('patient_appointments.reserve');
// Nueva ruta para ver el calendario

// Rutas adicionales para administración de citas y horarios (para profesionales)
Route::middleware('auth')->group(function () {
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index'); // Ver horarios del profesional
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create'); // Crear horario
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store'); // Almacenar horario

    Route::get('/all-appointments', [AppointmentController::class, 'index'])->name('appointments.index'); // Ver todas las citas (admin/profesional)
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create'); // Crear una cita manualmente
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store'); // Almacenar una cita
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit'); // Editar una cita
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update'); // Actualizar una cita
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy'); // Eliminar una cita
});

// Importar las rutas de autenticación generadas por Breeze
require __DIR__ . '/auth.php';
