<div>
    <div class="container">
		<h1>DASHBOARD</h1>
		<div>************* NOW **************</div>
		<div>OPERADORES</div>
		<div class="row">
			<div class='col col-sm'>Módulo</div>
			<div class='col col-sm'>Operador</div>
			<div class='col col-sm'>Usuario</div>
			<div class='col col-sm'>Estado</div>
			<div class='col col-sm'>Atendiendo</div>
			<div class='col col-sm'>En Pausa</div>
		</div>
		@foreach($host_now as $window)
		<div class="row">
			<div class='col col-sm'>{{ $window->window }}</div>
			<div class='col col-sm'>{{ $window->host->name }}</div>
			<div class='col col-sm'>{{ $window->client['name'] }}</div>
			<div class='col col-sm'>{{ $window->status['status'] }}</div>
			<div class='col col-sm'>{{ $window->time_busy }}</div>
			<div class='col col-sm'>{{ $window->time_paused }}</div>
		</div>
		@endforeach
		<br>
		<div>USUARIOS</div>
		<br>
		<div>************* TODAY **************</div>
		<div>OPERADORES</div>
		<br>
		<div>USUARIOS</div>
	</div>
</div>
