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
		<h1>Video-chat</h1>
	</div>
	<div>
		<button wire:click="call" class="btn btn-large btn-warning">Poner en Cola</button>
		<button wire:click="connect" class="btn btn-large btn-success">Responder</button>
		<button wire:click="disconnect" class="btn btn-large btn-danger">Colgar</button>
	</div>
</div>
