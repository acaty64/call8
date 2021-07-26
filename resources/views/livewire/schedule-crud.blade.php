<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
	@if($status == 'index')
		<div class="container">
			<div class="row">
				<div class="col-6">
					<button class="btn-success btn-lg" wire:click="setStatus('create')">Agregar</button>
				</div>
				<div class="col-6" align="right">
					<button class="btn-success btn-lg" wire:click="export()">Exportar</button>
				</div>
			</div>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th><b>Id</b></th>
					<th>
						<b>Office</b>
						<select wire:model="selectedOffice" class="form-control">
							<option value="" selected>Todos</option>
							@foreach($offices as $office)
								<option value="{{ $office->id }}">{{ $office->code }}</option>
							@endforeach
						</select>
					</th>
					<th>
						<b>Host</b>
						<select wire:model="selectedHost" class="form-control">
							<option value="" selected>Todos</option>
							@foreach($hosts as $host)
								<option value="{{ $host->id }}">{{ $host->name }}</option>
							@endforeach
						</select>
					</th>
					<th>
						<b>Dia</b>
						<select wire:model="selectedDay" class="form-control">
							<option value="" selected>Todos</option>
							@foreach($days as $key => $day)
								<option value="{{ $key }}">{{ $day }}</option>
							@endforeach
						</select>
					</th>
					<th><b>Inicio</b></th>
					<th><b>Fin</b></th>
					<th><b>Fecha Inicio</b></th>
					<th><b>Fecha Fin</b></th>
					<th><b>Actions</b></th>
				</tr>
			</thead>
			<tbody>
				@foreach($schedules as $schedule)
				<tr>
					<td>{{ $schedule->id }}</td>
					<td>{{ $schedule->office->code }}</td>
					<td>{{ $schedule->host->name }}</td>
					<td>{{ $semana[$schedule->day] }}</td>
					<td>{{ $schedule->hour_start }}</td>
					<td>{{ $schedule->hour_end }}</td>
					<td>{{ $schedule->date_start }}</td>
					<td>{{ $schedule->date_end }}</td>
					<td>
						<button wire:click="edit({{$schedule->id}})" class="btn-warning btn-md">Editar</button>
						<button wire:click="destroy({{$schedule->id}})" class="btn-danger btn-md">Eliminar</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	@endif
	@if($status == 'create')
		@livewire('schedule-create')
	@endif

	@if($status == 'edit')
		@livewire('schedule-edit', ['schedule_id' => $schedule_id])
	@endif

</div>
