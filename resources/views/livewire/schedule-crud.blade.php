<div>
	@if($status == 'index')
		<div class="row">
			<div class="col-sm-3">
					<button class="btn-success">Agregar</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">Office</div>
			<div class="col-sm-4">Host</div>
			<div class="col-sm-1">Dia</div>
			<div class="col-sm-1">Inicio</div>
			<div class="col-sm-1">Fin</div>
			<div class="col-sm-1">Actions</div>
		</div>
		@foreach($schedules as $schedule)
			<div class="row">
				<div class="col-sm-1">
					{{ $schedule->office->code }}
				</div>
				<div class="col-sm-4">
					{{ $schedule->host->name }}
				</div>
				<div class="col-sm-1">
					{{ $schedule->day }}
				</div>
				<div class="col-sm-1">
					{{ $schedule->hour_start }}
				</div>
				<div class="col-sm-1">
					{{ $schedule->hour_end }}
				</div>
				<div class="col-sm-3">
						<button class="btn-warning">Editar</button>
						<button class="btn-danger">Eliminar</button>
				</div>
			</div>
		@endforeach
	@endif
	@if($status == 'create')
		@livewire('schedule-create')
	@endif

</div>
