<div>
	@if(env('APP_DEBUG'))
	<div>
    	View: resources/views/livewire/host-screen.blade.php
	</div>
	@endif
    <div>
        {{-- @if (session()->has('message')) --}}
        @if ($message)
            <div class="alert alert-warning">
            	{{ $message }}
            </div>
        @endif
    </div>
    <h1>{{ $office['name'] }}</h1>
    @if($window)
	    <h1>Ventanilla: {{ $window['id'] }}</h1>
	    <h1>Call: {{ $window['call_id'] }}</h1>
	    <h1>ChannelName: {{ $channelName }}</h1>
	    <button wire:click="test_channel()">Test Channel</button>
    @endif
    <div class="card-header" align="center">
	    <h1>Hora: {{ $custom_time }}</h1>
    </div>
    <br>
    @if($screen == 'open')
	    <div class="card-header">
		    <div class="row">
		    	@if($status!="")
					<div class=col-sm>
						<button type="button" class="btn btn-primary btn-large">Estado:<span class="badge badge-light">{{ $status }}</span></button>
					</div>
				@endif
				<div class=col-sm>
					<button type="button" class="btn btn-warning btn-large">Esperando:<span class="badge badge-light">{{ $qclients }}</span></button>
				</div>
				<div class=col-sm>
					<button type="button" class="btn btn-success btn-large">Atendiendo:<span class="badge badge-light">{{ $qwindows }}</span></button>
				</div>
		    </div>
		</div>
		<div class="card-body mt-1">
			@if($status == 'Atendiendo')
				<button wire:click="connect" class="btn btn-lg btn-success">Conectar</button>
			@endif
			@if($status == 'Cerrado')
				<button wire:click="free" class="btn btn-lg btn-primary">Libre</button>
				<button wire:click="pauseWindow" class="btn btn-lg btn-warning">En Pausa</button>
				<button wire:click="outWindow" class="btn btn-lg btn-danger">Salir</button>
			@endif
			@if($status == 'En Pausa')
				<button wire:click="free" class="btn btn-lg btn-primary">Libre</button>
				<button wire:click="outWindow" class="btn btn-lg btn-danger">Salir</button>
			@endif
			@if($status == 'Libre')
				@if($qclients > 0)
					<button wire:click="startWindow" class="btn btn-lg btn-success">Llamar</button>
				@endif
				<button wire:click="pauseWindow" class="btn btn-lg btn-warning">En Pausa</button>
				<button wire:click="outWindow" class="btn btn-lg btn-danger">Salir</button>
			@endif
			@if($status == 'Llamando' || $status == 'Atendiendo' )
				<button wire:click="stopWindow" class="btn btn-lg btn-danger">Colgar</button>
			@endif
		</div>
	@else
		<h1>No tiene turno programado.</h1>
	@endif
	<div class="card">
		<div class="card-header" align="center">
			<h2>Programación</h1>
		</div>
		<div class="card-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Dia</th>
						<th scope="col">Hora de Inicio</th>
						<th scope="col">Hora de Fin</th>
					</tr>
				</thead>
				<tbody>
					@foreach($program as $item)
						<tr>
							<td>{{$item['fecha']}}</td>
							<td>{{$item['hora_ini']}}</td>
							<td>{{$item['hora_fin']}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

</div>
