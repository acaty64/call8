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
data_test: {{$data_test}}
    @if($screen == 'open')
	    <div class="container">
	    	<div><h1>{{ $window['office']['name']  }}</h1></div>
		    <div class="row">
				<div class=col-sm>
					Estado: {{ $status }}
				</div>
				<div class=col-sm>
					Esperando: {{ $qclients }}
				</div>
				<div class=col-sm>
					Atendiendo: {{ $qwindows }}
				</div>
		    </div>
	    </div>
		<div>
			@if($status == 'Atendiendo')
				<button wire:click="connect" class="btn btn-large btn-success">Conectar</button>
			@endif
			@if($status == 'Cerrado')
				<button wire:click="free" class="btn btn-large btn-primary">Libre</button>
				<button wire:click="pauseWindow" class="btn btn-large btn-warning">En Pausa</button>
				<button wire:click="outWindow" class="btn btn-large btn-danger">Salir</button>
			@endif
			@if($status == 'En Pausa')
				<button wire:click="free" class="btn btn-large btn-primary">Libre</button>
				<button wire:click="outWindow" class="btn btn-large btn-danger">Salir</button>
			@endif
			@if($status == 'Libre')
				@if($qclients > 0)
					<button wire:click="startWindow" class="btn btn-large btn-success">Llamar</button>
				@endif
				<button wire:click="pauseWindow" class="btn btn-large btn-warning">En Pausa</button>
				<button wire:click="outWindow" class="btn btn-large btn-danger">Salir</button>
			@endif
			@if($status == 'Llamando' || $status == 'Atendiendo' )
				<button wire:click="stopWindow" class="btn btn-large btn-danger">Colgar</button>
			@endif
		</div>
	@else
		<h1>No tiene turno</h1>
	@endif
</div>
