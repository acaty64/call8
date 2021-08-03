<div>
	<div class="container">
		<div class="form-group row">
			<div class="col-sm-12">
				<div class="input-group mt-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Office</span>
					</div>
					<div class="col-md-8 pl-0">
						<select wire:model="selectedOffice" class="form-control">
							<option value="" selected>Choose office</option>
							@foreach($offices as $office)
							<option value="{{ $office->id }}">{{ $office->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-2">
						<a href="{{ route('schedule.crud') }}" class="btn btn-success btn-lg">Horarios</a>
					</div>
				</div>
			</div>
		</div>
		<div class="card-header">
			<div class="row">
				<div class="col-sm-1">Id</div>
				<div class="col-sm-5">Operador</div>
			</div>
		</div>
		<div class="card-body">
			@foreach($hosts as $host)
			<div class="row">
				<div class="col-sm-1">{{ $host->id }}</div>
				<div class="col-sm-5">{{ $host->name }}</div>
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
	<table class="table table-sm table-bordered table-hover">
		<thead>
			<tr>
				<th scope="col" style="text-align: center;">Franja</th>
				<th scope="col" style="text-align: center">DOM</th>
				<th scope="col" style="text-align: center">LUN</th>
				<th scope="col" style="text-align: center">MAR</th>
				<th scope="col" style="text-align: center">MIE</th>
				<th scope="col" style="text-align: center">JUE</th>
				<th scope="col" style="text-align: center">VIE</th>
				<th scope="col" style="text-align: center">SAB</th>
			</tr>
		</thead>
		<tbody>
			@foreach($schedule as $item)
			<tr>
				@foreach($item as $hora)
				<td style="text-align: center">
					{{ ($hora['value'] > 0 ? $hora['value'] : '') }}
				</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
