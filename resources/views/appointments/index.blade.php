@extends('layout')

@section('content')
	<h1>Citas</h1>

	<a href="{{ route('appointments.create') }}" class="btn btn-primary">Agregar Cita</a>

	<table class="table">
		<thead>
			<tr>
				<th>Paciente</th>
				<th>Doctor</th>
				<th>Fecha y Hora</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($appointments as $appointment)
				<tr>
					<td>{{ $appointment->patient_name }}</td>
					<td>{{ $appointment->doctor_name }}</td>
					<td>{{ $appointment->appointment_time }}</td>
					<td>
						<a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning">Editar</a>
						<form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline-block;">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger">Eliminar</button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
