<div>
	<div>{{ $message }}</div>
	@if($status == 'index')
		<table class="table">
			<button class="btn-success btn-lg" wire:click="setStatus('create')">Agregar</button>
			<thead>
				<tr>
					<th>
						Office
{{-- 						<select wire:model="selectedOffice" class="form-control">
							<option value="" selected>Office</option>
							@foreach($offices as $office)
								<option value="{{ $office->id }}">{{ $office->name }}</option>
							@endforeach
						</select> --}}
					</th>
					<th>Host</th>
					<th>Dia</th>
					<th>Inicio</th>
					<th>Fin</th>
					<th>Fecha Inicio</th>
					<th>Fecha Fin</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($schedules as $schedule)
				<tr>
					<td>{{ $schedule->office->code }}</td>
					<td>{{ $schedule->host->name }}</td>
					<td>{{ $schedule->day }}</td>
					<td>{{ $schedule->hour_start }}</td>
					<td>{{ $schedule->hour_end }}</td>
					<td>{{ $schedule->date_start }}</td>
					<td>{{ $schedule->date_end }}</td>
					<td>
						<button class="btn-warning btn-md">Editar</button>
						<button class="btn-danger btn-md">Eliminar</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	@endif
	@if($status == 'create')
		@livewire('schedule-create')
	@endif

</div>
