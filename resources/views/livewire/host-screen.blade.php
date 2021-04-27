<div>
	<div>
    	View: resources/views/livewire/host-screen.blade.php
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
		@if($status == 'Cerrado')
			<button wire:click="free" class="btn btn-large btn-success">Libre</button>
			<button wire:click="pauseWindow" class="btn btn-large btn-warning">En Pausa</button>
			<button wire:click="outWindow" class="btn btn-large btn-danger">Salir</button>
		@endif
		@if($status == 'En Pausa')
			<button wire:click="free" class="btn btn-large btn-success">Libre</button>
			<button wire:click="outWindow" class="btn btn-large btn-danger">Salir</button>
		@endif
		@if($status == 'Libre')
			<button wire:click="startWindow" class="btn btn-large btn-success">Llamar</button>
			<button wire:click="pauseWindow" class="btn btn-large btn-warning">En Pausa</button>
			<button wire:click="outWindow" class="btn btn-large btn-danger">Salir</button>
		@endif
		@if($status == 'Llamando' || $status == 'Atendiendo' )
			<button wire:click="stopWindow" class="btn btn-large btn-danger">Colgar</button>
		@endif
	</div>
</div>
