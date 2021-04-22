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
		Esperando: {{ $qcalls }}
	</div>
	<div>
		Atendiendo: {{ $qwindows }}
	</div>
	<div>
		Status: {{ $status }}
	</div>
	<div>
		<button wire:click="connect" class="btn btn-large btn-success">Responder</button>
		<button wire:click="disconnect" class="btn btn-large btn-danger">Colgar</button>
	</div>
</div>
