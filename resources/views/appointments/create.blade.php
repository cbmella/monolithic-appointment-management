@extends('layout')

@section('content')
	<h1>{{ isset($appointment) ? 'Editar Cita' : 'Agregar Cita' }}</h1>

	<form action="{{ isset($appointment) ? route('appointments.update', $appointment->id) : route('appointments.store') }}"
		method="POST">
		@csrf
		@if (isset($appointment))
			@method('PUT')
		@endif

		<div class="form-group">
			<label for="patient_name">Nombre del Paciente</label>
			<input type="text" name="patient_name" class="form-control"
				value="{{ $appointment->patient_name ?? old('patient_name') }}" required>
		</div>

		<div class="form-group">
			<label for="doctor_name">Nombre del Doctor</label>
			<input type="text" name="doctor_name" class="form-control"
				value="{{ $appointment->doctor_name ?? old('doctor_name') }}" required>
		</div>

		<div class="form-group">
			<label for="appointment_time">Fecha y Hora</label>
			<input type="datetime-local" name="appointment_time" class="form-control"
				value="{{ isset($appointment) && $appointment->appointment_time instanceof \Carbon\Carbon ? $appointment->appointment_time->format('Y-m-d\TH:i') : old('appointment_time') }}"
				required>
		</div>

		<button type="submit" class="btn btn-primary">{{ isset($appointment) ? 'Actualizar' : 'Guardar' }}</button>
	</form>
@endsection
