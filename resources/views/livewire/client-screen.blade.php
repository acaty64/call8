<div>
	<div>
    	View: resources/views/livewire/client-screen.blade.php
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
    <div>*********************************************</div>

    <div>
			status: {{ $status }}
    </div>

    <div>
			user: {{ \Auth::user()->name }} - id: {{ \Auth::user()->id }}
    </div>
    <div>
    	data_test: {{ $data_test }}
    </div>
    <div>
    	call_id: {{ $call_id }}
    </div>
    <div>*********************************************</div>
    @endif
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
</div>