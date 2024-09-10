@extends('layout')

@section('content')
	<h1>Calendario de Citas Disponibles</h1>

	<div class="row">
		<!-- Columna para el calendario -->
		<div class="col-md-6">
			<!-- Contenedor para el calendario -->
			<div id="calendar"></div>
		</div>

		<!-- Columna para los horarios disponibles -->
		<div class="col-md-6">
			<h3>Horarios Disponibles</h3>
			<div id="available-times">
				<p>Selecciona una fecha para ver los horarios disponibles.</p>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');
			var availableTimesEl = document.getElementById('available-times');
			var professionalId = {{ $professional->id }}; // Obtener el ID del profesional
			var availableDates = []; // Para almacenar las fechas que tienen eventos


			var calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: ''
				},
				events: `{{ route('appointments.events', ':professional_id') }}`.replace(':professional_id',
					professionalId),

				// Al cargar los eventos, guardar las fechas disponibles
				eventDidMount: function(info) {
					var eventDate = new Date(info.event.start).toISOString().split('T')[0];
					availableDates.push(eventDate); // Almacenar las fechas con eventos disponibles
				},

				// Usar datesSet para asegurarse de que las fechas estén procesadas completamente
				datesSet: function() {
					// Esperar a que se carguen los eventos antes de aplicar los estilos
					setTimeout(function() {
							var allDays = document.querySelectorAll('.fc-daygrid-day');

							// Limpiar los días deshabilitados del mes anterior
							allDays.forEach(function(day) {
								day.classList.remove('fc-daygrid-day-disabled');
							});

							// Volver a recorrer los días para deshabilitar los que no están en availableDates
							allDays.forEach(function(day) {
								var dateStr = day.getAttribute('data-date');
								if (!availableDates.includes(dateStr)) {
									day.classList.add(
										'fc-daygrid-day-disabled'
									); // Aplicar estilo gris a fechas no disponibles
								}
							});
						},
						300
					); // Dar un ligero retraso para asegurar que los eventos están completamente cargados
				},

				dateClick: function(info) {
					// Solo permitir seleccionar fechas que no estén deshabilitadas
					if (info.dayEl.classList.contains('fc-daygrid-day-disabled')) {
						return; // No hacer nada si la fecha está deshabilitada
					}

					// Limpiar selección anterior
					var selectedDayEl = document.querySelector('.fc-daygrid-day-selected');
					if (selectedDayEl) {
						selectedDayEl.classList.remove('fc-daygrid-day-selected');
					}

					// Marcar el nuevo día como seleccionado
					info.dayEl.classList.add('fc-daygrid-day-selected');

					// Limpiar la lista de horarios disponibles cuando se selecciona una fecha
					availableTimesEl.innerHTML = "<p>Cargando horarios disponibles...</p>";

					// Generar la URL dinámica para obtener los horarios disponibles
					var url = `{{ route('appointments.times', [':professional_id', ':date']) }}`
						.replace(':professional_id', professionalId)
						.replace(':date', info.dateStr);

					// Realizar una petición AJAX para obtener los horarios disponibles de la fecha seleccionada
					fetch(url)
						.then(response => response.json())
						.then(data => {
							availableTimesEl.innerHTML = ''; // Limpiar el contenido

							// Si hay horarios disponibles
							if (data.length > 0) {
								data.forEach(function(time) {
									var routeUrl =
										`{{ route('patient_appointments.reserve', ':schedule_id') }}`;
									routeUrl = routeUrl.replace(':schedule_id', time
										.schedule_id);

									var timeEl = document.createElement('a');
									timeEl.href = routeUrl;
									timeEl.classList.add('available-time');
									timeEl.innerText = `Disponible: ${time.start_time}`;
									availableTimesEl.appendChild(timeEl);
								});
							} else {
								availableTimesEl.innerHTML =
									'<p>No hay horarios disponibles para esta fecha.</p>';
							}
						})
						.catch(error => {
							console.error('Error al obtener los horarios:', error);
							availableTimesEl.innerHTML =
								'<p>Error al cargar los horarios. Intenta nuevamente más tarde.</p>';
						});
				}
			});

			calendar.render();
		});
	</script>
@endpush
