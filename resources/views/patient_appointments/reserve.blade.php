@extends('layout')

@section('content')
	<h1>Reservar Cita para el {{ $schedule->available_date->format('d/m/Y') }} a las {{ $schedule->start_time }}</h1>

	<form action="{{ route('patient_appointments.book', $schedule->id) }}" method="POST">
		@csrf
		<input type="text" name="patient_name" placeholder="Tu nombre" required>
		<button type="submit">Confirmar Reserva</button>
	</form>
@endsection
