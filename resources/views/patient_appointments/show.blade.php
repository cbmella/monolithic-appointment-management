@extends('layout')

@section('content')
	<h1>Citas Disponibles con {{ $professional->name }}</h1>

	<h2>Horarios más cercanos</h2>
	<ul>
		@foreach ($schedules as $schedule)
			<li>
				<a href="{{ route('patient_appointments.reserve', $schedule->id) }}">
					{{ $schedule->available_date->format('d/m/Y') }} {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
				</a>
			</li>
		@endforeach
	</ul>

	<!-- Botón para ver el calendario con el profesional seleccionado -->
	<a href="{{ route('appointments.calendar', ['professional' => $professional->id]) }}" class="btn btn-primary">Ver
		Calendario Completo</a>
@endsection
