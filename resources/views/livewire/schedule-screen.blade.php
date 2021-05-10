<div>
	<div class="container">
		<div class="card-body">
			@foreach($hosts as $host)
				<div class="row">
					<div class="col-sm">{{ $host->id }}</div>
					<div class="col-sm-3">{{ $host->name }}</div>
					<div class="col-sm">{{ $host->dia }}</div>
					<div class="col-sm">{{ $host->hora_ini }}</div>
					<div class="col-sm">{{ $host->hora_fin }}</div>
					<div class="col-sm">{{ $host->fecha_ini }}</div>
					<div class="col-sm">{{ $host->fecha_fin }}</div>
				</div>
			@endforeach
		</div>
	</div>
	<div class="container">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="basic-addon1">Fecha de inicio</span>
					  </div>
					  <input type="date" class="form-control" value="{{ $inicio }}" wire:model="inicio"  aria-label="fecha_ini" aria-describedby="basic-addon1">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="basic-addon1">Fecha de fin</span>
					  </div>
					  <input type="date" class="form-control" value="{{ $fin }}" aria-label="fecha_ini" aria-describedby="basic-addon1" disabled>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-2">
					Franja
				</div>
				<div class="col-sm-1">
					LUN
				</div>
				<div class="col-sm-1">
					MAR
				</div>
				<div class="col-sm-1">
					MIE
				</div>
				<div class="col-sm-1">
					JUE
				</div>
				<div class="col-sm-1">
					VIE
				</div>
				<div class="col-sm-1">
					SAB
				</div>
				<div class="col-sm-1">
					DOM
				</div>
			</div>
		</div>
		<div class="card-body">
			@foreach($schedule as $item)
				<div class="row">
					@foreach($item as $hora)
						<div class="{{ $hora['class'] }}">
								{{ ($hora['value'] > 0 ? $hora['value'] : '') }}
						</div>
					@endforeach
				</div>
			@endforeach
		</div>
	</div>
</div>