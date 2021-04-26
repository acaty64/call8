<div>
	<div>
    	View: resources/views/livewire/client.blade.php
	</div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div>
			status: {{ $status }}
    </div>

    <div>
			user: {{ \Auth::user() }}
    </div>
    <div>
    	data_test: {{ $data_test }}
    </div>
    <div class="row">
		<div class=col-sm>
			Estado: {{ $status }}
		</div>
		<div class=col-sm>
			Esperando: {{ $qcalls }}
		</div>
		<div class=col-sm>
			Atendiendo: {{ $qwindows }}
		</div>
    </div>
	<div class="container" align="center">
		<h1>Client Video-chat Here</h1>
	</div>
	<div>
		@if(\Auth::user()->is_client)
			@if($status == '')
				<button wire:click="wait" class="btn btn-large btn-warning">Poner en Cola</button>
			@endif
			@if($status == 'Llamando')
				<button wire:click="connect" class="btn btn-large btn-success">Responder</button>
			@endif
			@if($status == 'Atendiendo')
				<button wire:click="disconnect" class="btn btn-large btn-danger">Colgar</button>
			@endif
		@endif
		@if(\Auth::user()->is_host)
			@if($status == 'Cerrado')
				<button wire:click="free" class="btn btn-large btn-success">Libre</button>
				<button wire:click="pause" class="btn btn-large btn-warning">En Pausa</button>
				<button wire:click="out" class="btn btn-large btn-danger">Salir</button>
			@endif
			@if($status == 'En Pausa')
				<button wire:click="free" class="btn btn-large btn-success">Libre</button>
				<button wire:click="disconnect" class="btn btn-large btn-danger">Salir</button>
			@endif
			@if($status == 'Libre')
				<button wire:click="call" class="btn btn-large btn-success">Llamar</button>
				<button wire:click="call" class="btn btn-large btn-warning">En Pausa</button>
				<button wire:click="stop" class="btn btn-large btn-danger">Salir</button>
			@endif
			@if($status == 'Llamando' || $status == 'Atendiendo' )
				<button wire:click="call" class="btn btn-large btn-danger">Colgar</button>
			@endif
		@endif
	</div>
</div>