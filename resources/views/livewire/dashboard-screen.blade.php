<div>
	<div class="container">
		<div class="card-header pb-0">
			<h3 align="center">OPERADORES ACTIVOS</h3>
		</div>
		<div class="card-body pt-0">
			<table class="table table-striped pt-0">
				<thead>
					<tr class="row">
							<th class='col col-sm'>Módulo</th>
							<th class='col col-sm'>Operador</th>
							<th class='col col-sm'>Usuario</th>
							<th class='col col-sm'>Estado</th>
							<th class='col col-sm'>Atendiendo</th>
							<th class='col col-sm'>En Pausa</th>
							<th class='col col-sm'>Libre</th>
					</tr>
				</thead>
				<tbody>
					@foreach($hosts_now as $window)
						<tr class="row">
							<td class='col col-sm'>{{ $window->window }}</td>
							<td class='col col-sm'>{{ $window->host->name }}</td>
							<td class='col col-sm'>{{ $window->client['name'] }}</td>
							<td class='col col-sm'>{{ $window->status['status'] }}</td>
							<td class='col col-sm'>{{ $window->time_busy }}</td>
							<td class='col col-sm'>{{ $window->time_paused }}</td>
							<td class='col col-sm'>{{ $window->time_free }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		<div class="card-header pb-0">
			<h3 align="center">USUARIOS EN ESPERA</h3>
		</div>
		<div class="card-body pt-0">
			<table class="table table-striped">
				<thead>
					<tr class="row">
						<th class='col col-sm'>Número</th>
						<th class='col col-sm'>Usuario</th>
						<th class='col col-sm'>En Pausa</th>
					</tr>
				</thead>
				<tbody>
					@foreach($clients_now as $call)
					<tr class="row">
						<td class='col col-sm'>{{ $call->number }}</td>
						<td class='col col-sm'>{{ $call->user['name'] }}</td>
						<td class='col col-sm'>{{ $call->time_paused }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="card-header pb-0">
			<h3 align="center">OPERADORES PROGRAMADOS</h3>
		</div>
		<div class="card-body pt-0">
			<table class="table table-striped">
				<thead>
					<tr class="row">
						<th class='col col-sm'>Operador</th>
						<th class='col col-sm'>Hora de Inicio</th>
						<th class='col col-sm'>Hora de Fin</th>
					</tr>
				</thead>
				<tbody>
					@foreach($schedules as $schedule)
					<tr class="row">
						<td class='col col-sm'>{{ $schedule->host->name }}</td>
						<td class='col col-sm'>{{ $schedule->hour_start }}</td>
						<td class='col col-sm'>{{ $schedule->hour_end }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
