<div>
    <div class="container">
		<h1>DASHBOARD</h1>
		
		<div>************* NOW **************</div>
		<div>OPERADORES ACTIVOS</div>
		<div class="row">
			<div class='col col-sm'>Módulo</div>
			<div class='col col-sm'>Operador</div>
			<div class='col col-sm'>Usuario</div>
			<div class='col col-sm'>Estado</div>
			<div class='col col-sm'>Atendiendo</div>
			<div class='col col-sm'>En Pausa</div>
			<div class='col col-sm'>Libre</div>
		</div>
		@foreach($hosts_now as $window)
			<div class="row">
				<div class='col col-sm'>{{ $window->window }}</div>
				<div class='col col-sm'>{{ $window->host->name }}</div>
				<div class='col col-sm'>{{ $window->client['name'] }}</div>
				<div class='col col-sm'>{{ $window->status['status'] }}</div>
				<div class='col col-sm'>{{ $window->time_busy }}</div>
				<div class='col col-sm'>{{ $window->time_paused }}</div>
				<div class='col col-sm'>{{ $window->time_free }}</div>
			</div>
		@endforeach
		<br>
		<div>USUARIOS EN ESPERA</div>
		<div class="row">
			<div class='col col-sm'>Número</div>
			<div class='col col-sm'>Usuario</div>
			<div class='col col-sm'>En Pausa</div>
		</div>
		@foreach($clients_now as $call)
			<div class="row">
				<div class='col col-sm'>{{ $call->number }}</div>
				<div class='col col-sm'>{{ $call->user['name'] }}</div>
				<div class='col col-sm'>{{ $call->time_paused }}</div>
			</div>
		@endforeach
		<br>
		<div>************* TODAY **************</div>
		<div>OPERADORES (Todo)</div>
		<br>
		<div>USUARIOS (Todo)</div>
	</div>
</div>
