<div>
	<div>
    	View: resources/views/livewire/host-screen.blade.php
	</div>
    <div>
        {{-- @if (session()->has('message')) --}}
        @if ($message)
            <div class="alert alert-warning">
            	{{ $message }}
            </div>
        @endif
    </div>
    @if(env('APP_DEBUG'))
    <div>*************************************</div>
    <div>
			status: {{ $status }}
    </div>

    <div>
			user: {{ \Auth::user()->name }}
    </div>
    <div>
    	data_test: {{ $data_test }}
    </div>
    <div>
    	window: {{ $window }}
    </div>
    @endif
    <div>*************************************</div>
    <div class="container">
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
</div>
