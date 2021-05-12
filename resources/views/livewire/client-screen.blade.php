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
    @if( $office_id == '' )
{{ $horarios }}
{{--     	@foreach($horarios as $horario_office)
			{{ $horario_office['office'] }}
    		@foreach($horario_office['horarios'] as $item)
				{{ $item }}
    		@endforeach
    	@endforeach --}}
    	<div>
    		
    	</div>
    @endif
    @if( $office_id != '' )
	    <div class="container">
	    	El horario de atención de hoy en {{ $office['name'] }} es:
	    	@foreach($horario as $hora)
		    <div class="row">
				<div class=col-sm-2>
				</div>
				<div class=col-sm-4>
		    		{{ $hora['ini']}} - {{ $hora['fin'] }}
				</div>
			</div>
	    	@endforeach
		</div>
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
			@if($status == 'Atendiendo')
				<h1>Espere, conectándose ....</h1>
			@endif
		</div>
		<div>
			@if($status == '')
				<button wire:click="wait" class="btn btn-large btn-warning">Poner en Cola</button>
			@endif
			@if($status == 'Llamando')
				<button wire:click="answer" class="btn btn-large btn-success">Responder</button>
			@endif
			@if($status == 'Atendiendo')
				<button wire:click="stop" class="btn btn-large btn-danger">Colgar</button>
			@endif
		</div>
    @endif
</div>