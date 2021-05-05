<div>
    <div class="container">
		<h1>DASHBOARD</h1>
		<div>************* NOW **************</div>
		<div>OPERADORES</div>
		@foreach($host_now as $window)
		<div>{{ $window->window }}</div>
		<div>{{ $window->host->name }}</div>
		<div>{{ $window->client->name }}</div>
		<div>{{ $window->time_busy }}</div>
		<div>{{ $window->time_paused }}</div>
		@endforeach
		<div>USUARIOS</div>
		<div>************* TODAY **************</div>
		<div>OPERADORES</div>
		<div>USUARIOS</div>
	</div>
</div>
