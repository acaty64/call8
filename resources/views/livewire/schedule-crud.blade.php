<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
	@if($status == 'index')
		<table class="table">
			<button class="btn-success btn-lg" wire:click="setStatus('create')">Agregar</button>
			<thead>
				<tr>
					<th><b>Id</b></th>
					<th>
						<b>Office
{{-- 						<select wire:model="selectedOffice" class="form-control">
							<option value="" selected>Office</option>
							@foreach($offices as $office)
								<option value="{{ $office->id }}">{{ $office->name }}</option>
							@endforeach
						</select> --}}
					</th>
					<th><b>Host</b></th>
					<th><b>Dia</b></th>
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
					<td>{{ $schedule->day }}</td>
					<td>{{ $schedule->hour_start }}</td>
					<td>{{ $schedule->hour_end }}</td>
					<td>{{ $schedule->date_start }}</td>
					<td>{{ $schedule->date_end }}</td>
					<td>
						{{-- <button class="btn-warning btn-md">Editar</button> --}}
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

</div>
