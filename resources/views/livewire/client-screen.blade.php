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
		@if($status == '')
			<button wire:click="wait" class="btn btn-large btn-warning">Poner en Cola</button>
		@endif
		@if($status == 'Llamando')
			<button wire:click="connect" class="btn btn-large btn-success">Responder</button>
		@endif
		@if($status == 'Atendiendo')
			<button wire:click="disconnect" class="btn btn-large btn-danger">Colgar</button>
		@endif
	</div>
	<div>
		Boton de prueba
		<button wire:click="call" class="btn btn-large btn-success">Llamando</button>
	</div>
</div>
