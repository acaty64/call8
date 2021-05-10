<div>
	<div class="container card mb-3">
		<div class="card-body">
			<h3>SCHEDULE CREATE</h3>
		</div>
	</div>
	<div class="container">
		@livewire('search-host')

		<div class="form-group row">
			<div class="col-sm-12">
				<div class="input-group mb">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Office</span>
					</div>
					<div class="col-md-8">
						<select wire:model="selectedOffice" class="form-control">
							<option value="" selected>Choose office</option>
							@foreach($offices as $office)
								<option value="{{ $office->id }}">{{ $office->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4">
				<div class="input-group mb">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Day</span>
					</div>
					<div class="col-md-8">
						<select wire:model="selectedDay" class="form-control">
							<option value="" selected>Choose day</option>
							@foreach($days as $key => $day)
								<option value="{{ $key }}">{{ $day }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-group mb">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Hora Inicio</span>
					</div>
					<div class="col-md-8">
						<select wire:model="hour_start" class="form-control">
							<option value="" selected>Choose hour start</option>
							@foreach($hours_start as $kh => $hour)
								<option value="{{ $kh }}">{{ $hour }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-group mb">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Hora de Fin</span>
					</div>
					<div class="col-md-8">
						<select wire:model="hour_end" class="form-control">
							<option value="" selected>Choose hour end</option>
							@foreach($hours_end as $kh2 => $hour2)
								<option value="{{ $kh2 }}">{{ $hour2 }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Fecha de inicio</span>
					</div>
					<input type="date" class="form-control" value="{{ $date_start }}" wire:model="date_start"  aria-label="fecha_ini" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Fecha de fin</span>
					</div>
					<input type="date" class="form-control" value="{{ $date_end }}" wire:model="fin"  aria-label="date_end" aria-describedby="basic-addon1">
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<button class="btn-success btn-lg">Grabar</button>
			</div>
		</div>
	</div>
</div>
