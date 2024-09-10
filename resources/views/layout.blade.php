<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gestión de Citas</title>

	<!-- Bootstrap CSS -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

	<!-- Select2 CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

	<!-- FullCalendar CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">

	<!-- Tu archivo CSS personalizado -->
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<style>
		#calendar {
			max-width: 70%;
			margin: 0 auto;
		}

		#available-times {
			padding: 15px;
		}

		.available-time {
			padding: 10px;
			background-color: #f8f9fa;
			margin-bottom: 10px;
			cursor: pointer;
			border: 1px solid #ced4da;
			text-align: center;
		}

		.available-time:hover {
			background-color: #e2e6ea;
		}

		/* Ocultar los eventos en el calendario */
		.fc-event {
			display: none;
		}

		/* Estilo para el día seleccionado */
		.fc-daygrid-day-selected {
			background-color: #4CAF50 !important;
			/* Verde */
			color: white !important;
		}

		/* Estilo para las fechas no disponibles */
		.fc-daygrid-day-disabled {
			background-color: #e0e0e0 !important;
			/* Gris */
			pointer-events: none;
			/* No clickeables */
			color: #a9a9a9 !important;
			/* Texto gris */
		}
	</style>
</head>

<body>
	<header class="bg-primary text-white text-center py-3">
		<h1>Gestión de Citas</h1>
	</header>

	<div class="container mt-4">
		@yield('content') <!-- Aquí se insertará el contenido de cada vista -->
	</div>

	<footer class="bg-light text-center py-3 mt-4">
		<p>&copy; 2024 Gestión de Citas</p>
	</footer>

	<!-- Colocar scripts al final del body -->

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Select2 JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

	<!-- FullCalendar JS -->
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

	<!-- Bootstrap JS, Popper.js, and Bootstrap JS Bundle (includes Popper.js) -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<!-- Scripts globales -->
	@stack('scripts') <!-- Esto permite que vistas individuales inserten scripts -->
</body>

</html>
