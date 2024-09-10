@extends('layout')

@section('content')
	<div class="max-w-2xl mx-auto px-4 py-8">
		<h1 class="text-3xl font-bold mb-6">Reservar una Cita</h1>

		<h2 class="text-xl font-semibold mb-4">Elige un Profesional</h2>

		<!-- Select de profesionales con búsqueda integrada de Select2 -->
		<form action="" method="GET" id="selectProfessionalForm">
			<select id="professionalSelect"
				class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
				onchange="goToProfessional()">
				<option value="" disabled selected>Selecciona un profesional</option>
				@foreach ($professionals as $professional)
					<option value="{{ route('patient_appointments.show', $professional->id) }}">
						{{ $professional->name }}
					</option>
				@endforeach
			</select>
		</form>
	</div>
@endsection

@push('scripts')
	<!-- Script para inicializar Select2 y forzar foco en el input de búsqueda -->
	<script>
		$(document).ready(function() {
			// Inicializar Select2
			$('.select2').select2({
				width: '100%',
				theme: 'tailwind'
			});

			// Forzar el foco en el campo de búsqueda cuando se abre el dropdown de Select2
			$(document).on('select2:open', () => {
				document.querySelector('.select2-search__field').focus();
			});

			// Redirigir al profesional seleccionado
			$('#professionalSelect').on('change', function() {
				var url = $(this).val();
				if (url) {
					window.location.href = url;
				}
			});
		});
	</script>
@endpush
